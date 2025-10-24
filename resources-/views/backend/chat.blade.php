@extends('backend.layouts.app')
 <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }

        #messagesContainer {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .message {
            display: block;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 10px;
            max-width: 75%;
        }

        .message.user {
            background-color: #d1ecf1;
            align-self: flex-end;
            text-align: right;
        }

        .message.astro {
            background-color: #f8d7da;
            align-self: flex-start;
        }

        .message-content {
            font-size: 14px;
        }

        .message-sender {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: capitalize;
            display:contents;
        }
        .message-date {
    font-size: 12px;
    color: #6c757d;
    margin-top: 5px;
}
audio {
    display: block;
    margin-top: 8px;
    margin-bottom: 8px;
}
    </style>
<script src="https://cdn.jsdelivr.net/npm/zego-zim-web@2.18.1/index.min.js"></script>
@section('content')
    <h3 class="text-center mb-4">Chat History</h3>
    <div id="messagesContainer">
        <h4>Messages</h4>
        <div id="messageList" class="d-flex flex-column gap-2"></div>
    </div>

    <script>
    
    document.addEventListener('DOMContentLoaded', () => {
        console.log('ZIM available?', typeof ZIM !== 'undefined');

        if (ZIM) {
            const appID = 2007373594;
            const userID = '{{$userId}}'; // Replace with your user ID
            const token = '{{$finalToken}}'; // Replace with your generated token
            const userName = '{{$userName}}';
            const astroName = '{{$astroName}}';

            const zim = ZIM.create({
                appID
            });

            zim.login(userID, {
                    token,
                    userName: astroName // Replace with the desired username
                })
                .then(() => {
                    console.log('Login successful!');

                    const conversationID = '{{$astroId}}'; // Replace with the actual conversation ID
                    const conversationType = 0; // Replace with the appropriate type
                    const config = {
                        nextMessage: null,
                        count: 200,
                        reverse: true
                    };

                    zim.queryHistoryMessage(conversationID, conversationType, config)
                        .then((response) => {
                            console.log('Message history:', response.messageList);

                            // Display messages in HTML
                            const messageList = document.getElementById('messageList');
                            if (response.messageList.length === 0) {
                                console.warn('No messages found.');
                                return;
                            }

                            response.messageList.forEach((message) => {
    console.log('Processing message:', message);

    const senderType = message.senderUserID === userID ? 'user' : 'astro';

    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${senderType}`;

    const senderDiv = document.createElement('div');
    senderDiv.className = 'message-sender';
    senderDiv.textContent = senderType === 'user' ? userName : astroName;

    let contentDiv;

    if (message.fileDownloadUrl) {
        // If the message contains an audio file
        contentDiv = document.createElement('audio');
        contentDiv.controls = true; // Show play/pause controls
        contentDiv.src = message.fileDownloadUrl;
    } else {
        // If the message is a text message
        contentDiv = document.createElement('div');
        contentDiv.className = 'message-content';
        contentDiv.textContent = message.message || '(No Content)';
    }

    const timestamp = message.timestamp;
    const formattedDate = new Date(timestamp).toLocaleString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
        hour12: true
    });

    const dateDiv = document.createElement('div');
    dateDiv.className = 'message-date';
    dateDiv.textContent = formattedDate;

    messageDiv.appendChild(senderDiv);
    messageDiv.appendChild(contentDiv);
    messageDiv.appendChild(dateDiv);

    messageList.appendChild(messageDiv);
});
                        })
                        .catch(error => {
                            console.error('Error fetching messages:', error);
                        });
                })
                .catch((err) => {
                    console.error('Login failed:', err.code, err.message);
                });
        } else {
            console.error('ZIM SDK is not available!');
        }
    });
</script>

   
@endsection