@foreach ($latestChats as $list)
    @if ($list->sender_id == Auth::id())
        <a href="{{ route('consultations.person', $list->recipient_id) }}" class="d-flex chat-list p-2 mt-2 rounded position-relative" data-id="{{ $list->recipient_id }}" onclick="showUserInfo('{{ $list->recipient_id }}', event)">
            <div class="position-relative">
                @if ($list->recipient->image == 'default/user.png')
                    <img src="{{ asset($list->recipient->image) }}" class="avatar avatar-md-sm rounded-circle border shadow" alt="avatar">
                @else
                    <img src="{{ asset('storage/users/' . $list->recipient->image) }}" class="avatar avatar-md-sm rounded-circle border shadow" alt="avatar">
                @endif
                <i class="mdi mdi-checkbox-blank-circle {{ $list->recipient->is_online == 1 ? 'text-success' : 'text-danger' }} on-off align-text-bottom"></i>
            </div>
            <div class="overflow-hidden flex-1 ms-2">
                <div class="d-flex justify-content-between">
                    <h6 class="text-dark mb-0 d-block">{{ $list->recipient->name }}</h6>
    @else
        <a href="{{ route('consultations.person', $list->sender_id) }}" class="d-flex chat-list p-2 mt-2 rounded position-relative" data-id="{{ $list->sender_id }}" onclick="showUserInfo('{{ $list->sender_id }}', event)">
            <div class="position-relative">
                @if ($list->sender->image == 'default/user.png')
                    <img src="{{ asset($list->sender->image) }}" class="avatar avatar-md-sm rounded-circle border shadow" alt="avatar">
                @else
                    <img src="{{ asset('storage/users/' . $list->sender->image) }}" class="avatar avatar-md-sm rounded-circle border shadow" alt="avatar">
                @endif
                <i class="mdi mdi-checkbox-blank-circle {{ $list->recipient->is_online == 1 ? 'text-success' : 'text-danger' }} on-off align-text-bottom"></i>
            </div>
            <div class="overflow-hidden flex-1 ms-2">
                <div class="d-flex justify-content-between">
                    <h6 class="text-dark mb-0 d-block">{{ $list->sender->name }}</h6>
    @endif
                    <small class="text-muted">{{ str_replace(' yang lalu', '', \Illuminate\Support\Carbon::parse($list->created_at)->locale('id')->shortRelativeDiffForHumans()) }}</small>
                </div>
                <div class="justify-content-between">
                    @php
                        if ($list->sender_id == Auth::id()) {
                            $count = 0;
                        } else {
                            $count = \App\Models\Consultation::where('sender_id', $list->sender_id)
                                                    ->where('status', 'unread')
                                                    ->count();
                        }
                    @endphp
                    @if ($count > 0)
                        <span class="badge bg-soft-danger float-end">{{ $count }}</span>
                    @endif
                        @if ($list->message != '')
                            <span class="{{ $count > 0 ? 'text-dark' : 'text-muted'}} h6 mb-0 text-truncate" data-id="{{ $list->sender_id }}">{{ $list->message }}</span>
                        @elseif ($list->attachment != '')
                        <span class="{{ $count > 0 ? 'text-dark' : 'text-muted'}} h6 mb-0 text-truncate" data-id="{{ $list->sender_id }}"><i class="fas fa-image"></i> Foto</span>
                        @endif
                </div>
            </div>
        </a>
@endforeach
