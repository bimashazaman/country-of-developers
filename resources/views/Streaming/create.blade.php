<!-- resources/views/posts/create.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <br>
                <br>
                <br>
                <br>
                <div class="">
                    <div class="card-header">Start Streaming</div>

                    <div class="card-body">
                        <div id="video-container" style="display: flex; flex-wrap: wrap; justify-content: center;"></div>
                        <button id="start-stream-btn" class="btn btn-primary">Start Stream</button>
                        <button id="stop-stream-btn" class="btn btn-danger" style="display: none;">Stop Stream</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/webrtc.js') }}"></script>
    <script src="https://unpkg.com/peerjs@1.4.7/dist/peerjs.min.js"></script>

    <script>
        const videoContainer = document.getElementById('video-container');
        const startStreamBtn = document.getElementById('start-stream-btn');
        const stopStreamBtn = document.getElementById('stop-stream-btn');
        let localStream = null;
        let peer = null;
        let peerStream = null;
        let peerStreamId = null;
        let streamStarted = false;

        startStreamBtn.addEventListener('click', async () => {
            if (!streamStarted) {
                try {
                    localStream = await navigator.mediaDevices.getUserMedia({
                        video: true,
                        audio: true
                    });

                    const localVideo = document.createElement('video');
                    localVideo.srcObject = localStream;
                    localVideo.autoplay = true;
                    localVideo.muted = true;
                    localVideo.style.width = '300px';
                    localVideo.style.height = '300px';
                    videoContainer.appendChild(localVideo);

                    startStreamBtn.style.display = 'none';
                    stopStreamBtn.style.display = 'inline-block';

                    // Send a request to start the stream
                    const response = await fetch('http://127.0.0.1:8001/api/stream/start', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        // body: JSON.stringify({})
                    }).then(response => response.json()).then(data => data).catch(error => console.log(
                        error));

                    const data = await response.json();
                    if (data.streamStarted) {
                        peer = new Peer({
                            host: 'http://127.0.0.1:',
                            port: 8001,
                            path: '/myapp'
                        });

                        peer.on('open', (id) => {
                            console.log('Connected with peer ID: ' + id);
                        });

                        peer.on('call', (call) => {
                            call.answer(localStream);
                            call.on('stream', (stream) => {
                                peerStream = stream;
                                peerStreamId = call.peer;

                                const peerVideo = document.createElement('video');
                                peerVideo.srcObject = peerStream;
                                peerVideo.autoplay = true;
                                peerVideo.style.width = '300px';
                                peerVideo.style.height = '300px';
                                videoContainer.appendChild(peerVideo);
                            });
                        });

                        peer.on('error', (error) => {
                            console.log('PeerJS error:', error);
                        });

                        streamStarted = true;
                    } else {
                        console.log('Error starting the stream');
                    }
                } catch (error) {
                    console.log('Error accessing media devices:', error);
                }
            } else {
                console.log('Stream is already running');
            }
        });

        stopStreamBtn.addEventListener('click', async () => {
            if (streamStarted) {
                try {
                    const response = await fetch('api/stream/stop', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({})
                    });

                    const data = await response.json();
                    if (data.streamStopped) {
                        localStream.getTracks().forEach((track) => {
                            track.stop();
                        });

                        peerStream.getTracks().forEach((track) => {
                            track.stop();
                        });

                        videoContainer.innerHTML = '';

                        startStreamBtn.style.display = 'inline-block';
                        stopStreamBtn.style.display = 'none';

                        streamStarted = false;
                    } else {
                        console.log('Error stopping the stream');
                    }
                } catch (error) {
                    console.log('Error stopping the stream:', error);
                }
            }
        });
    </script>
@endsection
