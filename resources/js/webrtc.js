// resources/js/webrtc.js
import SimplePeer from "simple-peer";

// Create a SimplePeer instance
let peer;

const videoContainer = document.getElementById("video-container");
const startStreamBtn = document.getElementById("start-stream-btn");
const stopStreamBtn = document.getElementById("stop-stream-btn");

// Start the stream
startStreamBtn.addEventListener("click", () => {
    // Generate a unique stream ID
    const streamId = Date.now().toString();

    // Save the stream ID in the user's session or database
    // based on your application's requirements

    // Hide the start stream button and show the stop stream button
    startStreamBtn.style.display = "none";
    stopStreamBtn.style.display = "inline-block";

    // Create a new SimplePeer instance as the stream initiator
    peer = new SimplePeer({
        initiator: true, // Set to true to initiate the connection
        trickle: false, // Disable trickle ICE to improve latency
    });

    // Subscribe to the stream-stopped event from the broadcasting user
    window.Echo.channel("stream-channel").listen("stream-stopped", (event) => {
        const { streamId: stoppedStreamId } = event;
        if (streamId === stoppedStreamId) {
            // Stop the stream and reset the UI
            stopStream();
        }
    });

    // Get access to the user's camera and microphone
    navigator.mediaDevices
        .getUserMedia({
            video: true,
            audio: true,
        })
        .then((stream) => {
            // Display the local video stream
            const videoElement = document.createElement("video");
            videoElement.srcObject = stream;
            videoElement.autoplay = true;
            videoElement.muted = true;
            videoContainer.appendChild(videoElement);

            // Add the local video stream to the peer connection
            peer.addStream(stream);

            // Handle incoming signals from the broadcasting user
            peer.on("signal", (signal) => {
                // Send the signal to the broadcasting user
                window.Echo.private(`stream-channel.${streamId}`).whisper(
                    "signal",
                    signal
                );

                // Handle signals from the broadcasting user
                window.Echo.private(
                    `stream-channel.${streamId}`
                ).listenForWhisper(
                    "signal",
                    (signal) => {
                        // Add the broadcasting user's signal to the peer connection
                        peer.signal(signal);
                    }

                    // Handle the error
                );

                peer.on(
                    "error",
                    (error) => {
                        console.error("Error with peer connection:", error);
                    }

                    // Handle the connection success
                );

                peer.on(
                    "connect",
                    () => {
                        console.log("Peer connection successful");
                    }

                    // Handle the connection closing
                );

                peer.on(
                    "close",
                    () => {
                        console.log("Peer connection closed");
                    }

                    // Handle the connection disconnection
                );

                peer.on(
                    "disconnect",
                    () => {
                        console.log("Peer connection disconnected");
                    }

                    // Handle the connection error
                );
            });

            // Handle incoming stream from the broadcasting user
            peer.on("stream", (remoteStream) => {
                // Display the remote video stream
                const remoteVideoElement = document.createElement("video");
                remoteVideoElement.srcObject = remoteStream;
                remoteVideoElement.autoplay = true;
                videoContainer.appendChild(remoteVideoElement);
            });
        })
        .catch((error) => {
            console.error("Error accessing media devices:", error);
        });
});

// Stop the stream
stopStreamBtn.addEventListener("click", () => {
    stopStream();
});

// Function to stop the stream and reset the UI
function stopStream() {
    // Clear the video container
    while (videoContainer.firstChild) {
        videoContainer.firstChild.remove();
    }

    // Hide the stop stream button and show the start stream button
    stopStreamBtn.style.display = "none";
    startStreamBtn.style.display = "inline-block";

    // Close the SimplePeer connection
    if (peer) {
        peer.destroy();
        peer = null;
    }

    // Clear the user's session or update the database to reflect the stream has ended
    // For example, you can make an AJAX request to the server to stop the stream and update the database
    // Example AJAX request:
    /*
            $.ajax({
                method: 'POST',
                url: '/stream/stop',
                data: {
                    streamId, // Stream ID of the broadcasting user
                },
                success: (response) => {
                    // Handle the response
                },
                error: (error) => {
                    // Handle the error
                },
            });
            */
}
