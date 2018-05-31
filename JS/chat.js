
var chat = {}

chat.getMessages = function() {

    // send message time stamp to includes/chat.inc.js through ajax
    $.ajax({
        url: 'includes/chat.inc.php',
        type: 'post',
        dataType: 'json',
        data: {method: 'getMessages', timestamp: chat.lastMsgTimestamp},
        success: function(data){
            // getting a response from includes/chat.inc.js
            // if success, append message
            if (data.statusCode == 0){
                $('#msg-content').prepend(data.msg);
                console.log(data.msg);
            }
            
        }
    });

    
}

chat.lastMsgTimestamp = -1;

// update message display per 3 seconds
chat.interval = setInterval(chat.getMessages, 3000);
chat.getMessages();