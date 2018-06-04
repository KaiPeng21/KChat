
// SUPPORTING FUNCTIONS

/*  Create an message block HTML:
    SAMPLE 1:

                        <li class="other">
                            <span class="msg-name">First Last</span><br>
                            <span>A message From other people!</span><br>
                            <span class="msg-time">2018/06/01 09:12 pm</span>
                        </li>
    SAMPLE 2:
                        <li class="self">
                            <span>A message From User</span><br>
                            <span class="msg-time">2018/06/01 09:13 pm</span>
                        </li>
*/
function createMessageBlock(content='', type='other', name='', date='', time=''){
    var msg = '<li class="' + type + '">';

    if (name != ''){
        msg += '<span class="msg-name">' + name + '</span><br>';
    }
    msg += '<span>' + content + '</span><br>';
    
    if (date != '' || time != ''){
        msg += '<span class="msg-time">' + date + ' ' + time + '/span>';
    }
    msg += '</li>';  
    return msg;
}

// Chat Object
var chat = {};

// when the send button is pressed, push message content to database
$('#msg-send-btn').click(function(event){

    // reference to the message content textarea
    chat.messageContent = $('#message-content').val();
    
    // send timestamp and message content to includes/chat.inc.php for updating the message database
    $.ajax({
        url: 'includes/chat.inc.php',
        type: 'post',
        dataType: 'json',
        data: {method: 'pushMessage', timestamp: chat.lastMsgTimestamp, message: chat.messageContent},
        success: function(data){
            // getting a response from includes/chat.inc.php
            // if success, trigger getMessages immediately
            /*
            $('#message-form').reset();
            if (data.statusCode == 0){
                chat.getMessages();
            }*/
        }
    });
});

//  getting message slot
chat.getMessages = function() {


    // send message timestamp to includes/chat.inc.php through ajax
    $.ajax({
        url: 'includes/chat.inc.php',
        type: 'post',
        dataType: 'json',
        data: {method: 'getMessages', timestamp: chat.lastMsgTimestamp},
        success: function(data){
            // getting a response from includes/chat.inc.php
            // if success, append message

            console.log("DEBUGGING data: " + data.msgContent);

            if (data.statusCode == 0){
                // var msgBlk = createMessageBlock(data.msg, 'self', '', '', '');
                console.log(data.msgContent);
                // $('#message-block').append(data.msgContent);
            }
            
        }
    });   
}

// when a page is reloaded, fetch all messages from database, and thus set timestamp to 1
chat.lastMsgTimestamp = '-1';

// update message display per 3 seconds
chat.interval = setInterval(chat.getMessages, 3000);
chat.getMessages();