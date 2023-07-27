                <ul class="list-unstyled">
                    @foreach ($comments as $comment)
                        <div style='background-color: #141A29;' class="card p-3 m-3 rounded-lg" x-data="{ open: false }">
                            @include('comments.partials.commentHead')
                            @include('comments.partials.commentActions')
                        </div>
                        @include('comments.partials.replyComments')
                    @endforeach
                </ul>
