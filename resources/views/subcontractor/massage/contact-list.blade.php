<div class="pepoles">
    <div id="noResultsMessage" class="text-center text-muted my-3 d-none">
        No messages found
    </div>
    @foreach ($sortedProjects as $item)
        @php
            $contractor = $item['contractor'];
            $isUnseen = $item['unseen_count'] > 0;
            $isImage = $item['last_message_image'] && !$item['last_message_body'];
            $preview = $item['last_message_body'] ?? ($isImage ? '📷 Image' : 'No messages yet');
            $image = $item['image'] ? $item['image'] : asset('assets/images/icons8-person-94.png');
            // $chatId = $item['chat_id'] ?? null;
        @endphp

        <div class="inner-item user-chat-trigger d-flex align-items-start" style="cursor: pointer;"
            data-id="{{ $contractor->id }}" data-type="contractor" data-name="{{ $contractor->contact_name }}"
            data-photo="{{ $contractor->profile_photo ? asset('storage/' . $contractor->profile_photo) : asset('assets/images/icons8-person-94.png') }}"
            data-incomig="{{ $image }}">

            <img src="{{ $contractor->profile_photo ? asset('storage/' . $contractor->profile_photo) : asset('assets/images/icons8-person-94.png') }}"
                alt="Profile Photo" class="img-fluid rounded-circle" width="45" height="45">

            <div class="content flex-grow-1 ms-2">
                <h6 class="d-flex justify-content-between mb-1">
                    <span>{{ $contractor->contact_name }}</span>
                    @if ($item['last_message_time'])
                        <small
                            class="text-muted">{{ \Carbon\Carbon::parse($item['last_message_time'])->timezone('Asia/Kolkata')->format('h:i A') }}</small>
                    @endif
                </h6>

                <p class="{{ $isUnseen ? 'fw-bold text-dark' : 'text-muted' }}">
                    {{ $preview }}
                </p>
            </div>

            @if ($isUnseen)
                <span class="badge bg-danger rounded-pill align-self-center ms-2">{{ $item['unseen_count'] }}</span>
            @endif
        </div>
    @endforeach
</div>
