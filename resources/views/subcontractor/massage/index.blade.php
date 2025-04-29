@extends('layouts.subcontractor')
@section('title')
    Sub Contractor
@endsection
@section('content')
    <section class="charting-section">
        <div class="row">
            <div class="col-md-5">
                <div class="left-chat">

                    <div class="search">
                        <input type="text" placeholder="Search messages" class="form-control">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>


                    <div class="pepoles">
                        <div class="inner-item">
                            <img src="{{ asset('assets/images/team-1.jpg') }}" alt="" class="img-fluid">

                            <div class="content">
                                <h6>Jan Mayer <span>3:40 PM</span></h6>
                                <p>We want to invite you for a qui...</p>
                            </div>
                        </div>
                        <div class="inner-item">
                            <img src="{{ asset('assets/images/team-1.jpg') }}" alt="" class="img-fluid">

                            <div class="content">
                                <h6>Jan Mayer <span>3:40 PM</span></h6>
                                <p>We want to invite you for a qui...</p>
                            </div>
                        </div>
                        <div class="inner-item">
                            <img src="{{ asset('assets/images/team-1.jpg') }}" alt="" class="img-fluid">

                            <div class="content">
                                <h6>Jan Mayer <span>3:40 PM</span></h6>
                                <p>We want to invite you for a qui...</p>
                            </div>
                        </div>
                        <div class="inner-item">
                            <img src="{{ asset('assets/images/team-1.jpg') }}" alt="" class="img-fluid">

                            <div class="content">
                                <h6>Jan Mayer <span>3:40 PM</span></h6>
                                <p>We want to invite you for a qui...</p>
                            </div>
                        </div>
                        <div class="inner-item">
                            <img src="{{ asset('assets/images/team-1.jpg') }}" alt="" class="img-fluid">

                            <div class="content">
                                <h6>Jan Mayer <span>3:40 PM</span></h6>
                                <p>We want to invite you for a qui...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="chat-detail">
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


                    <div class="center-user-info">
                        <img src="{{ asset('assets/images/team-2.jpg') }}" alt="">
                        <h6>Jan Mayer</h6>
                        <p>Recruiter at <span>Nomad</span> </p>
                        <p>This is the very beginning of your direct message with <b>Jan Mayer</b></p>

                        <div class="today">
                            <p><i class="fa-solid fa-angle-down"></i> Today</p>
                        </div>
                    </div>



                    <div class="send-box-item">
                        <input type="text" class="form-control" placeholder="Reply message" id="messageInput">
                        <i class="fa-solid fa-paperclip"></i>
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
        window.authUser = {
            id: {{ auth('subcontractor')->id() }},
            type: 'subcontractor'
        };

        let receiverId;
        let receiverType;

        // Example: dynamically set when user clicks contact
        receiverId = 1; // Example contractor id
        receiverType = 'contractor';

        document.getElementById('sendMessageBtn').addEventListener('click', function() {
            const messageInput = document.getElementById('messageInput');
            const body = messageInput.value.trim();
            if (!body) return;

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
@endsection
