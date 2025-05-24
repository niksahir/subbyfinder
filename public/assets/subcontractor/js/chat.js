

if (document.getElementById('searchContacts')) {
    document.getElementById('searchContacts').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        let matchCount = 0;

        const items = document.querySelectorAll('#contactListWrapper .inner-item');

        items.forEach(function (el) {
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
}

function loadContacts() {
    $.ajax({
        url: window.routes.loadContacts,
        method: 'GET',
        success: function (response) {
            $('#contactListWrapper').html(response);

            // Only auto-click if no chat is open
            if ($('.chat-detail:visible').length === 0) {
                const firstChat = $('#contactListWrapper .user-chat-trigger').first();
                if (firstChat.length) {
                    firstChat.trigger('click');
                }
            }
        },
        error: function () {
            alert('Failed to load contacts.');
        }
    });
}


if (document.getElementById('triggerFileInput')) {
    document.getElementById('triggerFileInput').addEventListener('click', function () {
        document.getElementById('imageInput').click();
    });
}

let receiverId;
let receiverType;
let chatId;

function toggleNoMessages() {
    const hasMessages = document.querySelectorAll('.delete-message-wrapper').length > 0;
    const noMessagesEl = document.querySelector('.no-messages');

    if (noMessagesEl) {
        if (hasMessages) {
            noMessagesEl.classList.add('d-none');
            noMessagesEl.classList.remove('d-flex');
        } else {
            noMessagesEl.classList.remove('d-none');
            noMessagesEl.classList.add('d-flex');
        }
    }
}

if (document.getElementById('contactListWrapper')) {
    document.getElementById('contactListWrapper').addEventListener('click', function (e) {
        const item = e.target.closest('.user-chat-trigger');
        if (!item) return; // Click wasn't on a user-chat-trigger

        receiverId = item.dataset.id;
        receiverType = item.dataset.type;
        chatId = item.dataset.chat;
        console.log('Selected user:', receiverId, receiverType);

        document.querySelectorAll('.chat-detail').forEach(function (el) {
            el.classList.remove('d-none');
            el.classList.add('d-flex');
        });

        document.querySelector('.no-messages').classList.add('d-none');

        // Enable send button
        document.getElementById('sendMessageBtn').disabled = false;

        // Update user topbar
        document.querySelector('.chat-detail .user-topbar img').src = item.dataset.photo;
        document.querySelector('.chat-detail .user-topbar .name h6').textContent = item.dataset.name;
        // document.querySelector('.chat-detail .center-user-info h6').textContent = item.dataset.name;
        // document.querySelector('.chat-detail .center-user-info p b').textContent = item.dataset.name;
        // document.querySelector('.chat-detail .center-user-info img').src = item.dataset.photo;

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
                // const image = item.dataset.photo;
                // console.log('Messages:', res.data.messages);
                if (res.data.messages.length === 0) {
                    document.querySelector('.no-messages').classList.remove('d-none');
                    document.querySelector('.no-messages').classList.add('d-flex');
                    return;
                } else {
                    document.querySelector('.no-messages').classList.add('d-none');
                    document.querySelector('.no-messages').classList.remove('d-flex');
                    res.data.messages.forEach(msg => {
                        appendMessage(msg, msg.from_user_id == window.authUser.id ? 'outgoing' :
                            'incoming');
                    });
                }

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
                    const headerBadge = document.getElementById('header-unseen-count');

                    if (sidebarBadge && headerBadge) {
                        if (newCount > 0) {
                            sidebarBadge.textContent = newCount;
                            headerBadge.textContent = newCount;
                            headerBadge.classList.remove('d-none');
                            sidebarBadge.classList.remove('d-none');
                        } else {
                            sidebarBadge.textContent = '';
                            headerBadge.textContent = '';
                            headerBadge.classList.add('d-none');
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
}


if (document.getElementById('sendMessageBtn')) {
    document.getElementById('sendMessageBtn').addEventListener('click', function () {
        document.querySelector('.no-messages').classList.add('d-none');
        document.querySelector('.no-messages').classList.remove('d-flex');
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
            message: body,
            // chat_id: chatId
        }).then(res => {
            appendMessage(res.data.message, 'outgoing');
            messageInput.value = '';
            refreshUnseenCount();
            loadContacts();
        }).catch(error => {
            console.error('Message send failed', error);
        });
    });
}

if (document.getElementById('imageInput')) {
    document.getElementById('imageInput').addEventListener('change', function (e) {
        document.querySelector('.no-messages').classList.add('d-none');
        document.querySelector('.no-messages').classList.remove('d-flex');
        const file = e.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('image', file);
        formData.append('to_user_id', receiverId);
        formData.append('receiver_type', receiverType);
        // formData.append('chat_id', chatId);

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
}


const channel = pusher.subscribe('chat.' + window.authUser.id + '.' + window.authUser.type);
console.log('Subscribed to channel:', 'chat.' + window.authUser.id + '.' + window.authUser.type);

channel.bind_global(function (eventName, data) {
    console.log('Global event received:', eventName, data);
});

channel.bind('MessageDeleted', function (data) {
    console.log('MessageDeleted event received:', data);

    const messageEl = document.querySelector(`.message[data-id="${data.messageId}"]`);
    if (messageEl) {
        messageEl.remove();
    }

    toggleNoMessages(); // Check if no messages left after deletion
    loadContacts();
    refreshUnseenCount();
});

channel.bind('MessageSent', function (data) {
    refreshUnseenCount();
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
    // console.log(image);

    // console.log(msg.sender.profile_photo);

    // let senderName = msg.sender_name || 'User';
    // let messageTime = msg.created_at || 'Just now';

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
       <div class="d-flex align-items-start justify-content-end text-end mb-2 mt-auto delete-message-wrapper" data-msg-id="${msg.id}">
            <div class="my-message position-relative" >
                <i class="fa-solid fa-trash-can text-danger delete-message position-absolute"
                style="cursor: pointer; font-size: 20px; display: none; top: 0; left: 0;"></i>

                ${msg.body ? `<div class="text-dark p-2 rounded mb-1 outgoing">${msg.body}</div>` : ''}
                ${msg.image ? `<img src="/storage/${msg.image}" class="img-fluid rounded mt-2" style="max-width: 200px;">` : ''}
                <div class="text-muted small">${messageTime}</div>
            </div>

            <img src="${window.authUser.photo}" class="rounded-circle ms-2" alt="You" style="width: 40px; height: 40px;">
        </div>
    `;
    } else {
        // let senderImage = (msg.sender && msg.sender.profile_photo) || `{{ asset('assets/images/icons8-person-94.png') }}`;

        if (msg.sender && msg.sender.profile_photo) {
            senderImage = `/storage/${msg.sender.profile_photo}`;
        } else {
            senderImage = defaultImage;
        }

        // Incoming message
        content += `
            <div class="d-flex align-items-start mb-3 mt-auto delete-message-wrapper message">
                <img src="${senderImage}" class="rounded-circle me-2" alt="" style="width: 40px; height: 40px;">
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
            const newCount = parseInt(countRes.data.count, 10) || 0;
            const sidebarBadge = document.getElementById('sidebar-unseen-count');
            const headerBadge = document.getElementById('header-unseen-count');

            if (sidebarBadge && headerBadge) {
                if (newCount > 0) {
                    sidebarBadge.textContent = newCount;
                    headerBadge.textContent = newCount;
                    sidebarBadge.classList.remove('d-none');
                    headerBadge.classList.remove('d-none');
                } else {
                    sidebarBadge.textContent = '';
                    headerBadge.textContent = '';
                    sidebarBadge.classList.add('d-none');
                    headerBadge.classList.add('d-none'); // ✅ This line is now active
                }
            }
        })
        .catch(error => {
            console.error('Error fetching unseen count:', error);
        });
}



document.addEventListener('click', function (e) {
    if (e.target.classList.contains('delete-message')) {
        const messageEl = e.target.closest('.delete-message-wrapper');
        if (!messageEl) return;

        const messageId = messageEl.dataset.msgId;
        if (!messageId) return alert('Message ID not found');

        if (confirm('Do you want to delete this message?')) {
            axios.delete(`/delete-message/${messageId}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(() => {
                messageEl.remove();
                toggleNoMessages(); // check after delete
                loadContacts();
                refreshUnseenCount();
            }).catch(err => {
                alert('Could not delete message.');
            });
        }
    }
});

// document.querySelector('.delete-chat-btn').addEventListener('click', function () {
//     if (!receiverId || !receiverType) return;

//     if (confirm('Are you sure you want to delete all messages in this chat?')) {
//         axios.delete(`/delete-all-messages/${chatId}`, {
//             headers: {
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
//                     'content')
//             }
//         }).then(() => {
//             document.querySelector('.message-box').innerHTML = '';
//             loadContacts();
//         }).catch(err => {
//             console.error('Delete All Failed', err);
//             alert('Could not delete chat.');
//         });
//     }
// });
