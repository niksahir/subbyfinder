@extends('layouts.subcontractor')
@section('title')
    Chat - Subby Finder
@endsection
@section('content')
    <section class="charting-section">
        <div class="row">
            <div class="col-md-5">
                <div class="left-chat">

                    <div class="search">
                        <input type="text" placeholder="Search messages" class="form-control" id="searchContacts">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>


                    <div id="contactListWrapper">
                        @include('subcontractor.massage.contact-list', [
                            'sortedProjects' => $sortedProjects,
                        ])
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="chat-detail d-flex flex-column" style="height: 100vh;">
                    <div class="user-topbar">
                        <div class="name-with-img">
                            <img src="{{ asset('assets/images/team-1.jpg') }}" alt="" class="img-fluid">

                            <div class="name">
                                <h6>Jan Mayer</h6>
                                <p>Recruiter at Nomad</p>
                            </div>
                        </div>


                        <div class="icons">
                            <i class="fa-solid fa-thumbtack"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </div>

                    </div>


                    {{-- <div class="center-user-info">
                        <img src="{{ asset('assets/images/team-2.jpg') }}" alt="">
                        <h6>Jan Mayer</h6>
                        <p>Recruiter at <span>Nomad</span> </p>
                        <p>This is the very beginning of your direct message with <b>Jan Mayer</b></p>

                        <div class="today">
                            <p><i class="fa-solid fa-angle-down"></i> Today</p>
                        </div>
                    </div> --}}

                    <div class="message-box flex-grow-1 overflow-auto px-3 py-2 border d-flex flex-column" id="messageBox">
                        <div class="mt-auto d-flex flex-column">
                            <!-- Messages -->
                            <div class="message incoming mb-2">
                                <p><strong>New message from:</strong> Hello there!</p>
                            </div>
                            <div class="message outgoing text-end">
                                <p><strong>You:</strong> Hi, how can I help?</p>
                            </div>
                        </div>
                    </div>

                    <div class="send-box-item">
                        <input type="text" class="form-control" placeholder="Reply message" id="messageInput">
                        <input type="file" id="imageInput" accept="image/*" style="display: none;">
                        <i class="fa-solid fa-paperclip" id="triggerFileInput" style="cursor: pointer;"></i>
                        <img src="{{ asset('assets/images/smile.png') }}" alt="">
                        <button id="sendMessageBtn"> <i class="fa-solid fa-paper-plane"></i></button>
                    </div>

                </div>
            </div>
        </div>



    </section>
@endsection
@section('scripts')
    <script>
        function loadContacts() {
            $.ajax({
                url: '{{ route('subcontractor.messages.index') }}', // adjust route if needed
                method: 'GET',
                success: function(response) {
                    $('#contactListWrapper').html(response); // wrapper for .pepoles
                },
                error: function() {
                    alert('Failed to load contacts.');
                }
            });
        }

        // Call this function where appropriate
        loadContacts();

        document.getElementById('searchContacts').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            document.querySelectorAll('#contactListWrapper .pepoles .inner-item').forEach(function(user) {
                const name = user.dataset.name.toLowerCase();
                if (name.includes(searchTerm)) {
                    user.style.display = '';
                } else {
                    user.style.display = 'none';
                }
            });
        });

        document.getElementById('triggerFileInput').addEventListener('click', function() {
            document.getElementById('imageInput').click();
        });

        let receiverId;
        let receiverType;

        window.authUser = {
            id: {{ auth('subcontractor')->id() }},
            type: 'subcontractor'
        };

        document.getElementById('contactListWrapper').addEventListener('click', function(e) {
            const item = e.target.closest('.user-chat-trigger');
            if (!item) return; // Click wasn't on a user-chat-trigger

            receiverId = item.dataset.id;
            receiverType = item.dataset.type;
            console.log('Selected user:', receiverId, receiverType);

            // Enable send button
            document.getElementById('sendMessageBtn').disabled = false;

            // Update user topbar
            document.querySelector('.chat-detail .user-topbar img').src = item.dataset.photo;
            document.querySelector('.chat-detail .user-topbar .name h6').textContent = item.dataset.name;

            // Clear old messages
            const chatDetail = document.querySelector('.chat-detail');
            chatDetail.querySelectorAll('.message').forEach(msg => msg.remove());

            // Fetch previous messages via AJAX
            axios.get(`/get-messages?receiver_id=${receiverId}&receiver_type=${receiverType}`)
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
            appendMessage(data.message, 'incoming');
        });

        function appendMessage(msg) {
            console.log(parseInt(receiverId), receiverType);

            loadContacts();
            // Check if the message belongs to the current chat window
            const isCurrentChat =
                (receiverId == msg.from_user_id && receiverType === msg.sender_type) ||
                (receiverId == msg.to_user_id && receiverType === msg.receiver_type);

            if (!isCurrentChat) {
                console.log('Message not for current chat:', msg);

                return
            }; // Skip unrelated messages

            const isMyMessage = msg.from_user_id === window.authUser.id && msg.sender_type === window.authUser.type;
            const direction = isMyMessage ? 'outgoing' : 'incoming';


            const chatBox = document.querySelector('.message-box');
            const messageElement = document.createElement('div');
            messageElement.classList.add('message', direction);

            if (direction === 'outgoing') {
                messageElement.classList.add('text-end');
            }

            let content = '';
            if (msg.body) {
                content += `<p><strong>${direction === 'incoming' ? 'New message from:' : 'You:'}</strong> ${msg.body}</p>`;
            }

            if (msg.image) {
                content += `<img src="/storage/${msg.image}" class="img-fluid rounded mt-2" style="max-width: 200px;">`;
            }

            messageElement.innerHTML = content;
            chatBox.appendChild(messageElement);
            chatBox.scrollTop = chatBox.scrollHeight;
        }


        // Initially disable send button
        document.getElementById('sendMessageBtn').disabled = true;
        loadContacts();
    </script>
@endsection
