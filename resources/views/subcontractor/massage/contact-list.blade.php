<div class="pepoles">
    @foreach ($sortedProjects as $item)
        @php
            $project = $item['project'];
            $isUnseen = $item['unseen_count'] > 0;
            $isImage = $item['last_message_image'] && !$item['last_message_body'];
            $preview = $item['last_message_body'] ?? ($isImage ? '📷 Image' : 'No messages yet');
        @endphp

        <div class="inner-item user-chat-trigger d-flex align-items-start" style="cursor: pointer;"
            data-id="{{ $project->contractor->id }}" data-type="contractor"
            data-name="{{ $project->contractor->contact_name }}"
            data-photo="{{ asset('storage/' . $project->contractor->profile_photo) }}">

            <img src="{{ asset('storage/' . $project->contractor->profile_photo) }}" alt=""
                class="img-fluid rounded-circle" width="45" height="45">

            <div class="content flex-grow-1 ms-2">
                <h6 class="d-flex justify-content-between mb-1">
                    <span>{{ $project->contractor->contact_name }}</span>
                    @if ($item['last_message_time'])
                        <small class="text-muted">{{ \Carbon\Carbon::parse($item['last_message_time'])->format('h:i A') }}</small>
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
