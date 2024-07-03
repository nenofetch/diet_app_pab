@foreach($chats as $chat)
    @if($chat->sender_id == Auth::id())
        <li class="chat-right">
            <div class="d-inline-block">
                <div class="d-flex chat-type mb-3">
                    <div class="chat-msg" style="max-width: 500px;">
                        @if ($chat->message != '')
                            <p class="msg text-white small shadow px-3 py-2 rounded mb-1 bg-primary">{{ $chat->message }}</p>
                        @elseif ($chat->attachment != '')
                            <div class="bg-primary p-2 shadow rounded mb-1" style="display: inline-block; width: 50%;">
                                <img src="{{ asset('storage/attachments/' . $chat->attachment) }}" class="msg rounded" style="width: 100%;" alt="attachment">
                            </div>
                        @endif
                        <small class="text-muted msg-time">{{ $chat->created_at->locale('id')->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
        </li>
    @else
        <li>
            <div class="d-inline-block">
                <div class="d-flex chat-type mb-3">
                    <div class="chat-msg" style="max-width: 500px;">
                        @if ($chat->message != '')
                            <p class="msg text-muted small shadow px-3 py-2 rounded mb-2">{{ $chat->message }}</p>
                        @elseif ($chat->attachment != '')
                            <div class="p-2 shadow rounded mb-2" style="display: inline-block; width: 50%;">
                                <img src="{{ asset('storage/attachments/' . $chat->attachment) }}" class="msg rounded" style="width: 100%;" alt="attachment">
                            </div>
                        @endif
                        <small class="text-muted msg-time">{{ $chat->created_at->locale('id')->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
        </li>
    @endif
@endforeach
