@extends('layouts.contractor')
@section('title')
    Chat - Subby Finder
@endsection
@section('content')
    <section class="charting-section min-vh-100">
        <div class="row">
            <div class="col-md-5">
                <div class="left-chat">

                    <div class="search">
                        <input type="text" placeholder="Search messages" class="form-control" id="searchContacts">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>


                    <div id="contactListWrapper">
                        @include('contractor.messages.contact-list', [
                            'sortedProjects' => $sortedProjects,
                        ])
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="chat-detail d-none flex-column" style="height: 100vh;">
                    <div class="user-topbar">
                        <div class="name-with-img">
                            <img src="{{ asset('assets/images/team-1.jpg') }}" alt="Profile Photo" class="img-fluid">

                            <div class="name">
                                <h6>Jan Mayer</h6>
                                <p>Recruiter at Nomad</p>
                            </div>
                        </div>


                        <div class="icons">
                            {{-- <i class="fa-solid fa-thumbtack"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-solid fa-ellipsis-vertical"></i> --}}
                            <i class="fas fa-trash delete-chat-btn" title="Delete All Messages"
                                style="cursor: pointer;"></i>
                        </div>

                    </div>


                    <div class="center-user-info">
                        <img src="{{ asset('assets/images/team-1.jpg') }}" alt="Profile Photo" class="img-fluid">
                        <h6>Jan Mayer</h6>
                        {{-- <p>Recruiter at <span>Nomad</span> </p> --}}
                        <p>This is the very beginning of your direct message with <b>Jan Mayer</b></p>

                        <div class="today">
                            <p><i class="fa-solid fa-angle-down"></i> Today</p>
                        </div>
                    </div>


                    <div class="message-box flex-grow-1 overflow-auto px-3 py-2 border d-flex flex-column" id="messageBox">
                        <div class="mt-auto d-flex flex-column">

                            <!-- Jan Mayer's message (incoming) -->
                            {{-- <div class="d-flex align-items-start mb-3">
                                <img src="https://via.placeholder.com/40" class="rounded-circle me-2" alt="Jan Mayer">
                                <div>
                                    <p class="mb-1 fw-bold">Jan Mayer</p>
                                    <div class="bg-light p-2 rounded border message incoming mb-2">
                                        Hey Jake, I wanted to reach out because we saw your work contributions and were
                                        impressed by your work.
                                    </div>
                                    <div class="bg-light p-2 rounded border message outgoing">
                                        We want to invite you for a quick interview
                                    </div>
                                    <div class="text-muted small mt-1">12 mins ago</div>
                                </div>
                            </div>

                            <!-- Your message (outgoing) -->
                            <div class="d-flex align-items-start justify-content-end text-end mb-2">
                                <div>
                                    <div class="bg-primary text-white p-2 rounded mb-1 outgoing">
                                        Hi Jan, sure I would love to. Thanks for taking the time to see my work!
                                    </div>
                                    <div class="text-muted small">12 mins ago</div>
                                </div>
                                <img src="https://via.placeholder.com/40" class="rounded-circle ms-2" alt="You">
                            </div> --}}

                        </div>
                    </div>

                    {{-- <div class="message-box flex-grow-1 overflow-auto px-3 py-2 border d-flex flex-column" id="messageBox">
                        <div class="mt-auto d-flex flex-column">
                            <!-- Messages -->
                            <div class="message incoming mb-2">
                                <p><strong>New message from:</strong> Hello there!</p>
                            </div>
                            <div class="message outgoing text-end">
                                <p><strong>You:</strong> Hi, how can I help?</p>
                            </div>
                        </div>
                    </div> --}}

                    <div class="send-box-item">
                        <input type="text" class="form-control" placeholder="Reply message" id="messageInput">
                        <input type="file" id="imageInput" accept="image/*" style="display: none;">
                        <i class="fa-solid fa-paperclip" id="triggerFileInput" style="cursor: pointer;"></i>
                        <img src="{{ asset('assets/images/smile.png') }}" alt="">
                        <button id="sendMessageBtn"> <i class="fa-solid fa-paper-plane"></i></button>
                    </div>

                </div>
                <div class="no-messages d-flex flex-column justify-content-center align-items-center text-center h-100">
                    <p>Select user for chat</p>
                </div>
            </div>
        </div>



    </section>
@endsection
{{-- @section('scripts')
    <script>
        @if (isset($receiverId) && isset($receiverType))
            console.log('Receiver ID:', {{ $receiverId }}, 'Receiver Type:', '{{ $receiverType }}');

            window.addEventListener('DOMContentLoaded', function() {
                const contactItem =
                    document.querySelector(
                        `.user-chat-trigger [data-id="{{ $receiverId }}"][data-type="{{ $receiverType }}"]`);
                if (contactItem) {
                    contactItem.click(); // Trigger the chat load
                }
            });
        @endif

        document.getElementById('searchContacts').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            let matchCount = 0;

            const items = document.querySelectorAll('#contactListWrapper .inner-item');

            items.forEach(function(el) {
                const name = (el.dataset.name || '').toLowerCase();

                if (name.includes(searchTerm)) {
                    el.classList.remove('d-none');
                    matchCount++;
                } else {
                    el.classList.add('d-none');
                }
            });

            // Toggle "No messages found"
            const noResultsDiv = document.getElementById('noResultsMessage');
            if (matchCount === 0) {
                noResultsDiv.classList.remove('d-none');
            } else {
                noResultsDiv.classList.add('d-none');
            }
        });

        function loadContacts() {
            $.ajax({
                url: '{{ route('contractor.messages.index') }}',
                method: 'GET',
                success: function(response) {
                    $('#contactListWrapper').html(response);
                },
                error: function() {
                    alert('Failed to load contacts.');
                }
            });
        }

        document.getElementById('triggerFileInput').addEventListener('click', function() {
            document.getElementById('imageInput').click();
        });

        let receiverId;
        let receiverType;

        window.authUser = {
            id: {{ auth('contractor')->id() }},
            type: 'contractor',
            name: "{{ auth('contractor')->user()->name }}",
            photo: "{{ auth('contractor')->user()->profile_photo ? asset('storage/' . auth('contractor')->user()->profile_photo) : asset('assets/images/icons8-person-94.png') }}"
        };

        document.getElementById('contactListWrapper').addEventListener('click', function(e) {
            const item = e.target.closest('.user-chat-trigger');
            if (!item) return; // Click wasn't on a user-chat-trigger

            receiverId = item.dataset.id;
            receiverType = item.dataset.type;
            console.log('Selected user:', receiverId, receiverType);

            document.querySelectorAll('.chat-detail').forEach(function(el) {
                el.classList.remove('d-none');
                el.classList.add('d-flex');
            });

            document.querySelector('.no-messages').classList.add('d-none');

            // Enable send button
            document.getElementById('sendMessageBtn').disabled = false;

            // Update user topbar
            document.querySelector('.chat-detail .user-topbar img').src = item.dataset.photo;
            document.querySelector('.chat-detail .user-topbar .name h6').textContent = item.dataset.name;
            document.querySelector('.chat-detail .center-user-info h6').textContent = item.dataset.name;
            document.querySelector('.chat-detail .center-user-info p b').textContent = item.dataset.name;
            document.querySelector('.chat-detail .center-user-info img').src = item.dataset.photo;

            // console.log('Image:', item.dataset.incomig);
            // document.querySelector('#incoming_image').src = item.dataset
            //     .incomig;

            // Clear old messages
            const chatDetail = document.querySelector('.chat-detail');
            chatDetail.querySelectorAll('.message').forEach(msg => msg.remove());

            // Fetch previous messages via AJAX
            axios.get(`/get-messages?receiver_id=${receiverId}&receiver_type=${receiverType}`)
                // const image = res.data.image;
                .then(res => {
                    res.data.messages.forEach(msg => {
                        appendMessage(msg, msg.from_user_id == window.authUser.id ? 'outgoing' :
                            'incoming');
                    });
                })
                .catch(err => {
                    console.error('Failed to load messages', err);
                });

            axios.post('/mark-as-seen', {
                from_user_id: receiverId,
                receiver_type: receiverType
            }, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                }
            }).then(res => {
                loadContacts();

                axios.get('/unseen-count')
                    .then(countRes => {
                        const newCount = countRes.data.count;
                        const sidebarBadge = document.getElementById('sidebar-unseen-count');

                        if (sidebarBadge) {
                            if (newCount > 0) {
                                sidebarBadge.textContent = newCount;
                                sidebarBadge.classList.remove('d-none');
                            } else {
                                sidebarBadge.textContent = '';
                                sidebarBadge.classList.add('d-none');
                            }
                        }
                    });

                // Remove individual badge from selected user
                const badge = item.querySelector('.unseen-badge');
                if (badge) badge.remove();

            }).catch(err => {
                console.error('Failed to mark as seen', err);
            });
        });


        document.getElementById('sendMessageBtn').addEventListener('click', function() {
            const messageInput = document.getElementById('messageInput');
            const body = messageInput.value.trim();

            if (!receiverId || !receiverType) {
                alert("Please select a user to start chatting.");
                return;
            }

            if (!body) return;

            console.log('Sending message to:', receiverId, receiverType);

            axios.post('/send-message', {
                to_user_id: receiverId,
                receiver_type: receiverType,
                message: body
            }).then(res => {
                appendMessage(res.data.message, 'outgoing');
                messageInput.value = '';
                refreshUnseenCount();
                loadContacts();
            }).catch(error => {
                console.error('Message send failed', error);
            });
        });

        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('image', file);
            formData.append('to_user_id', receiverId);
            formData.append('receiver_type', receiverType);

            axios.post('/send-image', formData)
                .then(res => {
                    appendMessage(res.data.message, 'outgoing');
                    refreshUnseenCount();
                    loadContacts();
                })
                .catch(err => {
                    console.error('Image send failed:', err);
                });
        });

        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            forceTLS: true
        });

        const channel = pusher.subscribe('chat.' + window.authUser.id + '.' + window.authUser.type);
        console.log('Subscribed to channel:', 'chat.' + window.authUser.id + '.' + window.authUser.type);

        channel.bind_global(function(eventName, data) {
            console.log('Global event received:', eventName, data);
        });

        channel.bind('MessageSent', function(data) {
            console.log('Received message:', data.message);

            const msg = data.message;
            const image = data.image;
            const isCurrentChat =
                (receiverId == msg.from_user_id && receiverType === msg.sender_type) ||
                (receiverId == msg.to_user_id && receiverType === msg.receiver_type);

            if (isCurrentChat) {
                appendMessage(msg, image); // Message for open chat

                axios.post('/mark-as-seen', {
                    from_user_id: msg.from_user_id,
                    receiver_type: msg.sender_type
                }, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                }).then(() => {
                    loadContacts();
                    refreshUnseenCount(); // Just in case any other sender still has unseen
                });
            } else {
                console.log('Message not for current chat:', msg);
                loadContacts(); // So unseen badge appears on sender in the list
                refreshUnseenCount(); // Only do this when it's not for the active chat
            }
        });


        function appendMessage(msg, image) {

            const isCurrentChat =
                (receiverId == msg.from_user_id && receiverType === msg.sender_type) ||
                (receiverId == msg.to_user_id && receiverType === msg.receiver_type);

            if (!isCurrentChat) return;

            const isMyMessage = msg.from_user_id === window.authUser.id && msg.sender_type === window.authUser.type;
            const direction = isMyMessage ? 'outgoing' : 'incoming';

            const chatBox = document.querySelector('.message-box');
            const messageElement = document.createElement('div');
            messageElement.classList.add('message', direction);
            messageElement.dataset.id = msg.id; // <-- Assign message ID for deletion
            messageElement.style.cursor = 'pointer';

            if (direction === 'outgoing') {
                messageElement.classList.add('text-end');
            }

            // let senderName = msg.sender_name || 'User';
            // let senderImage = msg.sender.profile_photo || `{{ asset('assets/images/icons8-person-94.png') }}`;/

            const isoTime = msg.created_at;
            const date = new Date(isoTime);

            const options = {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            };

            const messageTime = date.toLocaleString('en-US', options);

            let content = '';

            if (isMyMessage) {
                content += `
        <div class="d-flex align-items-start justify-content-end text-end mb-2">
            <div>
                ${msg.body ? `<div class="text-dark p-2 rounded mb-1 outgoing">${msg.body}</div>` : ''}
                ${msg.image ? `<img src="/storage/${msg.image}" class="img-fluid rounded mt-2" style="max-width: 200px;">` : ''}
                <div class="text-muted small">${messageTime}</div>
            </div>
            <img src="${window.authUser.photo}" class="rounded-circle ms-2" alt="You" style="width: 40px; height: 40px;">
        </div>
    `;
            } else {
                let senderImage = (msg.sender && msg.sender.profile_photo) || `{{ asset('assets/images/icons8-person-94.png') }}`;

                // Incoming message
                content += `
            <div class="d-flex align-items-start mb-3">
                <img src="/storage/${senderImage}" class="rounded-circle me-2" alt="" style="width: 40px; height: 40px;">
                <div>
                    ${msg.body ? `<div class="bg-light p-2 rounded border mb-1 incoming">${msg.body}</div>` : ''}
                    ${msg.image ? `<img src="/storage/${msg.image}" class="img-fluid rounded mt-2" style="max-width: 200px;">` : ''}
                    <div class="text-muted small mt-1">${messageTime}</div>
                </div>
            </div>
        `;
            }

            messageElement.innerHTML = content;
            chatBox.appendChild(messageElement);
            chatBox.scrollTop = chatBox.scrollHeight;
        }


        // Initially disable send button
        document.getElementById('sendMessageBtn').disabled = true;
        loadContacts();

        function refreshUnseenCount() {
            axios.get('/unseen-count')
                .then(countRes => {
                    const newCount = countRes.data.count;
                    const sidebarBadge = document.getElementById('sidebar-unseen-count');

                    if (sidebarBadge) {
                        if (newCount > 0) {
                            sidebarBadge.textContent = newCount;
                            sidebarBadge.classList.remove('d-none');
                        } else {
                            sidebarBadge.textContent = '';
                            sidebarBadge.classList.add('d-none');
                        }
                    }
                });
        }

        document.querySelector('.message-box').addEventListener('click', function(e) {
            const messageEl = e.target.closest('.message');
            if (!messageEl) return;

            const messageId = messageEl.dataset.id;
            if (!messageId) return;

            if (confirm('Do you want to delete this message?')) {
                axios.delete(`/delete-message/${messageId}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                }).then(() => {
                    messageEl.remove();
                    loadContacts();
                }).catch(err => {
                    console.error('Delete failed', err);
                    alert('Could not delete message.');
                });
            }
        });

        document.querySelector('.delete-chat-btn').addEventListener('click', function() {
            if (!receiverId || !receiverType) return;

            if (confirm('Are you sure you want to delete all messages in this chat?')) {
                axios.delete(`/delete-all-messages/${receiverId}/${receiverType}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                }).then(() => {
                    document.querySelector('.message-box').innerHTML = '';
                    loadContacts();
                }).catch(err => {
                    console.error('Delete All Failed', err);
                    alert('Could not delete chat.');
                });
            }
        });
    </script>
@endsection --}}

{{-- @section('scripts')
    <script>
        let receiverId;
        let receiverType;
        document.querySelectorAll('.user-chat-trigger').forEach(item => {
            item.addEventListener('click', function() {
                receiverId = this.dataset.id;
                receiverType = this.dataset.type;

                // Update user topbar
                document.querySelector('.chat-detail .user-topbar img').src = this.dataset.photo;
                document.querySelector('.chat-detail .user-topbar .name h6').textContent = this.dataset
                    .name;

                // Clear old messages
                const chatDetail = document.querySelector('.chat-detail');
                chatDetail.querySelectorAll('.message').forEach(msg => msg.remove());

                // Fetch previous messages via AJAX
                axios.get(`/get-messages?receiver_id=${receiverId}&receiver_type=${receiverType}`)
                    .then(res => {
                        res.data.messages.forEach(msg => {
                            appendMessage(msg, msg.from_user_id == window.authUser.id ?
                                'outgoing' : 'incoming');
                        });
                    })
                    .catch(err => {
                        console.error('Failed to load messages', err);
                    });
            });
        });
        window.authUser = {
            id: {{ auth('contractor')->id() }},
            type: 'contractor'
        };


        // // Example: dynamically set when user clicks contact (you can improve this)
        // receiverId = 1; // Example subcontractor id
        // receiverType = 'subcontractor';

        document.getElementById('sendMessageBtn').addEventListener('click', function() {
            const messageInput = document.getElementById('messageInput');
            // receiverId = this.dataset.id;
            // receiverType = this.dataset.type;

            console.log('Sending message to:', receiverId, receiverType);

            const body = messageInput.value.trim();
            if (!body || !receiverId || !receiverType) return;

            axios.post('/send-message', {
                to_user_id: receiverId,
                receiver_type: receiverType,
                message: body
            }).then(res => {
                appendMessage(res.data.message, 'outgoing');
                messageInput.value = '';
            }).catch(error => {
                console.error('Message send failed', error);
            });
        });

        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            forceTLS: true
        });

        const channel = pusher.subscribe('chat.' + window.authUser.id + '.' + window.authUser.type);
        console.log('Subscribed to channel:', 'chat.' + window.authUser.id + '.' + window.authUser.type);


        channel.bind_global(function(eventName, data) {
            console.log('Global event received:', eventName, data);
        });

        channel.bind('MessageSent', function(data) {
            console.log('Received message:', data.message);
            appendMessage(data.message, 'incoming');
        });

        function appendMessage(msg, type = 'incoming') {
            const chatBox = document.querySelector('.chat-detail');
            const messageElement = document.createElement('div');
            messageElement.classList.add('message', type);
            messageElement.innerHTML =
                `<p><strong>${type === 'incoming' ? 'New message from' : 'You'}:</strong> ${msg.body}</p>`;
            chatBox.appendChild(messageElement);
        }
    </script>
@endsection --}}
