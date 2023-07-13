
const base_dir = window.location.pathname.split('/').slice(0,-1).join('/');

// on ready
$(function(){
    // enforce user being logged in
    const allow_anonymous_user = true;
    enforce_user_login(allow_anonymous_user);
    // SETUP MESSAGE SENDING
    setup_emoticons();
    $('#message_text').on('input', on_input);
    $('#send').click(send_message);
    // get messages
    periodically_list_messages_callback()
    setInterval(periodically_list_messages_callback, 3000);

});

function enforce_user_login (allow_anonymous_user) {
    $.get('user_logged', function(data) {
        $('#username').text(data);
        if(data=='' && !allow_anonymous_user) {
            alert('The user is logged out. Login, please.');
            location = '..';
        }
    })
    .fail(function() {
      alert( "Error! when loading: logged user info" );
    });
}


// chat scrolling
function scroll_height(){ return $(document).height()-$(window).height(); }
function is_scrolled_to_bottom(){ return (Math.abs($('html')[0].scrollTop - scroll_height())<5); }
function scroll_to_bottom(){ $('html')[0].scrollTop = scroll_height(); }

// message listing
function list_messages(scrollFlag){ $('#message_log').load(base_dir+'/chat_list', function(){ if(scrollFlag) scroll_to_bottom(); } ) }
function periodically_list_messages_callback(){ var scrollFlag = is_scrolled_to_bottom(); list_messages(scrollFlag); }

function get_input(){
    var input = ($('div#message_text'))[0];
    return input;
}

// allow message sending
function send_message(){

    // no blank message fields allowed
    var message_text = get_input();
    if(message_text==''){
         alert('fill the Message field!');
         return false;
    }

    var form_data_object = { message_text };

    // disable form on pre-submit
    $('#send_message_form *').prop('disabled', true);

    // send JSON with POST type HTTP request
    $.ajax({
        type: 'POST',
        url: base_dir+'/chat_send',
        dataType: 'text',
        data: JSON.stringify(form_data_object),
    }).done(function(){
        // empty the message field
        $('div#message_text').html('');
    })
    .fail(function(){ // error handling
        alert('Error when sending a message!');
        enforce_user_login();
    })
    .always(function(){
        // enable form on post-submit
        $('#send_message_form *').prop('disabled', false);
    });
}

function place_caret_at_the_end(el) {
    el.focus();
    if (typeof window.getSelection != "undefined"
            && typeof document.createRange != "undefined") {
        var range = document.createRange();
        range.selectNodeContents(el);
        range.collapse(false);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    } else if (typeof document.body.createTextRange != "undefined") {
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(el);
        textRange.collapse(false);
        textRange.select();
    }
}

function escape_html(text) {
    'use strict';
    return text.replace(/[\"&<>]/g, function (a) {
        return { '"': '&quot;', '&': '&amp;', '<': '&lt;', '>': '&gt;' }[a];
    });
}

function on_input(inputEvent){
    var input = get_input();
    input = replace_smileys(input);
    input = escape_html(input);
    var new_html = parse_emoticons_expressions(input);
    if(new_html!=null){
        $(this).html(new_html);
        place_caret_at_the_end($(this)[0]);
    }
}
