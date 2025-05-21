@extends('layouts.subcontractor')
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
                        @include('subcontractor.massage.contact-list', [
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
                            <!-- Assuming you are using Bootstrap icons or Font Awesome -->
                            <i class="fas fa-trash delete-chat-btn" title="Delete All Messages"
                                style="cursor: pointer;"></i>

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
                <div class="no-messages d-flex flex-column justify-content-center align-items-center text-center h-100">
                    <p>Select user for chat</p>
                </div>
            </div>
        </div>



    </section>
@endsection
@section('scripts')
    
    </script>
@endsection
