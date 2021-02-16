// 定义基础数据类型

// 定义公共函数 下划线切割

/**
 * 获取设置的值
 *
 * @param name
 * @param defaultValue
 * @returns {*}
 */
function setting(name, defaultValue)
{
    if(room_setting.hasOwnProperty(name)){
        return room_setting[name]
    }
    return defaultValue
}

/**
 * 获取用户信息
 *
 * @param name
 * @param defaultValue
 * @returns {*}
 */
function get_user(name, defaultValue)
{
    let user = JSON.parse(localStorage.getItem('user'))
    if(user.hasOwnProperty(name)){
        return user[name];
    }
    return defaultValue;
}

/**
 * 设置用户信息
 *
 * @param user
 */
function set_user(user)
{
    localStorage.setItem('user', JSON.stringify(user))
}


let new_notify_audio = null;
function play_new_notify()
{
    new_notify_audio = new Audio('/audio/message-notice.mp3');
    new_notify_audio.play();
}

/**
 * 检测是否是手机模式
 * @returns {boolean}
 */
function mobile_check() {
    let check = false;
    (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
    return check;
};


/**
 * 安全的BASE64编码
 * @param text
 * @returns {string}
 */
function base64_safe_encode(text)
{
    text = window.btoa(text)
    return text
}


/**
 * 插入光标至末尾
 * @param el
 */
function place_caret_at_end(el) {
    el.focus();
    if (typeof window.getSelection != "undefined"
        && typeof document.createRange != "undefined") {
        var range = document.createRange();
        range.selectNodeContents(el);
        range.collapse(false);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    }
    else if (typeof document.body.createTextRange != "undefined") {
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(el);
        textRange.collapse(false);
        textRange.select();
    }
}

/**
 * 保存访客信息
 */
function session_save_name(){
    let remark_text = $("#profile-remark-text").val();
    let your_name = $("#profile-your-name").val();
    $.post('/api/room/set_user',{
        remark:remark_text,
        name:your_name,
    },function(res){
        localStorage.setItem('user',JSON.stringify({
            name:your_name,
            remark:remark_text,
            uuid:res.data.uuid
        }))
        $('#perfect-profile-modal').modal('hide')
    })

}

/**
 * 发送文本消息
 * @param text
 */
function send_message(text)
{
    let user = JSON.parse(localStorage.getItem('user'))
    let uuid = user.uuid
    let _msg_id = base64_safe_encode(Date.now()+Math.random());
    let messages = [
        {
            message_text:text,
            media_type:0,
            from_name:user.name,
            from_user_id:1,
            to_user_id:0,
            id:0,
            '_msg_id':_msg_id
        }
    ];
    let html = template('tpl-message', {
        list: messages,
        mobile_check:mobile_check,
        setting:setting,
        get_user:get_user,
    });
    $('#rom').append(html);
    $('.room-content').scrollTop($('.lite-chatbox').height())
    $('.composer_rich_textarea ').html('')

    message_request_ids.push(_msg_id);
    $.post('/api/room/message/new',{
        text:text,
        uuid:uuid,
        request_id:_msg_id
    },function(res){
        let id = res.data.id;
        last_id = id;
        document.getElementById('_msg_id_'+_msg_id).remove()
        console.log(res)
    })
    filter_element('.message-media-video').appear();
}


/**
 * 发送图文信息
 *
 * @param text
 * @param media
 */
function send_message_with_photo(text,media)
{
    let user = JSON.parse(localStorage.getItem('user'))
    let uuid = user.uuid
    let _msg_id = base64_safe_encode(Date.now()+Math.random());
    let messages = [
        {
            message_text: text,
            media: media.media,
            media_type: 1,
            media_width: media.media_width,
            media_height: media.media_height,
            from_name: user.name,
            from_user_id: 1,
            to_user_id: 0,
            id: 0,
            '_msg_id': _msg_id
        }
    ];
    console.log(messages)
    let html = template('tpl-message', {
        list: messages,
        mobile_check:mobile_check,
        setting:setting,
        get_user:get_user,
    });
    $('#rom').append(html);
    $('.room-content').scrollTop($('.lite-chatbox').height())
    $('.composer_rich_textarea ').html('')

    message_request_ids.push(_msg_id);
    $.post('/api/room/message/new',{
        text:text,
        media:media.media,
        uuid:uuid,
        request_id:_msg_id
    },function(res){
        let id = res.data.id;
        last_id = id;
        document.getElementById('_msg_id_'+_msg_id).remove()
        console.log(res)
    })
    filter_element('.message-media-video').appear();
}

let last_id = 0;

/**
 * 获取所有历史消息
 */
function get_messages()
{
    let user = JSON.parse(localStorage.getItem('user'))
    let uuid = user.uuid
    $.get('/api/room/message?uuid='+uuid, function(res){
        if(res.code != 200){
            return;
        }
        let messages = [];
        for(let i in res.data.messages){
            if(res.data.messages[i].request_id != ''){
                if(message_request_ids.indexOf(res.data.messages[i].request_id) != -1){
                    continue;
                }
            }
            messages.push(res.data.messages[i])
        }
        if(messages.length>0){
            last_id = res.data.last_id;
        }
        let html = template('tpl-message', {
            list: messages,
            mobile_check:mobile_check,
            setting:setting,
            get_user:get_user,
        });
        $('#rom').append(html);
        // if (is_first) {
        //     is_first = false;
        //     $('.room-content').scrollTop($('.lite-chatbox').height())
        //     // $('.lite-chatbox').scrollTop($('.lite-chatbox').height()+$('.lite-chatbox').offset().top);
        // }
        // $('.room-content').scrollTop($('.lite-chatbox').height())
        $('.room-content').scrollTop($('.room-content')[0].scrollHeight)

        // 这里需要过滤，否则会出现一个元素动态绑定两次的情况
        filter_element('.message-media-video').appear();
    })
}


let pull_message_lock = false;

/**
 * 拉取新消息
 * @returns {boolean}
 */
function pull_message()
{
    if(pull_message_lock){
        return false;
    }
    pull_message_lock = true;
    let user = JSON.parse(localStorage.getItem('user'))
    let uuid = user.uuid
    $.get('/api/room/message?uuid='+uuid+'&last_id='+last_id, function(res){
        if(res.code != 200){
            return;
        }
        let messages = [];
        for(let i in res.data.messages){
            if(res.data.messages[i].request_id != ''){
                if(message_request_ids.indexOf(res.data.messages[i].request_id) != -1){
                    continue;
                }
            }
            messages.push(res.data.messages[i])
        }
        if(messages.length>0){
            last_id = res.data.last_id;
            play_new_notify() // 播放消息提醒
        }

        let scrollUpdate = false;
        if($('.lite-chatbox').height()-($('.room-content').scrollTop()+$('.room-content').height()) < 10){
            scrollUpdate = true
        }
        let html = template('tpl-message', {
            list: messages,
            mobile_check:mobile_check,
            setting:setting,
            get_user:get_user,
        });
        $('#rom').append(html);
        pull_message_lock = false;
        if(scrollUpdate){
            $('.room-content').scrollTop($('.lite-chatbox').height())
        }

        filter_element('.message-media-video').appear();
    })
}

/**
 * 过滤元素
 * 每次获取只能获取未标记的元素，每次获取都将标记元素，二次获取不到
 * @param element
 * @returns {*|jQuery|HTMLElement}
 */
function filter_element(element)
{
    let result = $(element+'[filter-event-video!=1]')
    result.each(function(){
        if(!$(this).attr('filter-event-video')){
            $(this).attr('filter-event-video', 1)
        }
    })
    return result
}

// 执行初始化变量
let message_request_ids = [];
let is_first = true;

// 页面加载监听方法
$(document.body).on('appear', '.message-media-video', function(e, $affected) {
    $(e.currentTarget).find('video')[0].currentTime = 0
    $(e.currentTarget).find('video')[0].play()
    // console.log($(e.currentTarget).find('video')[0],'播放')
});
$(document.body).on('disappear', '.message-media-video', function(e, $affected) {
    $(e.currentTarget).find('video')[0].pause()
    $(e.currentTarget).find('video')[0].currentTime = 0
    // console.log($(e.currentTarget).find('video')[0],'停止')
});
$('.room-content').scroll(function(){
    $.force_appear();
})

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/**
 * 监听回车键发送消息和shift回车还行
 */
$('.composer_rich_textarea').keydown(function(e){
    if(e.keyCode == 13 && !e.shiftKey){
        //按下了enter键，发送消息
        let message = $('.composer_rich_textarea ').text()
        send_message(message)
        e.preventDefault();
        return false;
    }
    if(e.shiftKey && e.keyCode == 13){
        var content=$('.composer_rich_textarea ').html();
        $('.composer_rich_textarea ').html(content+"<div><br/></div>");
        place_caret_at_end($('.composer_rich_textarea ').get(0))
        return false;
    }
})

/**
 * 完善资料模态框被打开
 */
$('#perfect-profile-modal').on('show.bs.modal', function (event) {
    var modal = $(this)
    // modal.find('.modal-title').text('New message to ' + recipient)
    // modal.find('.modal-body input').val(recipient)
})

/**
 * 聊天室资料页模态框被打开
 */
$('#about-room-profile-modal').on('show.bs.modal', function (event) {
    var modal = $(this)
    if(setting('room_name')){
        modal.find('#about-room-profile-avatar').attr('src', setting('room_avatar','/avatar/default.jpg'))
        modal.find('#about-room-profile-name').text(setting('room_name', '未知的聊天室'))
        modal.find('#about-room-profile-desc').text(setting('room_desc', ''))
    }else{
        return false;
    }

})

/**
 * 个人资料模态框被打开
 */
$('#about-me-profile-modal').on('show.bs.modal', function (event) {
    var modal = $(this)
    let user = JSON.parse(localStorage.getItem('user'))
    if(user && user.name && user.name !=''){
        modal.find('#about-me-profile-avatar').attr('src', user.avatar ? user.avatar : '/avatar/default.jpg')
        modal.find('#about-me-profile-name').text(user.name ? user.name : '未知的名字')
        modal.find('#about-me-profile-desc').text(user.remark ? user.remark : '')
    }else{
        return false;
    }
    // modal.find('.modal-body input').val(recipient)
})

/**
 * 文件上传变更事件
 */
$("#file").change(function (e) {
    var file = e.target.files[0] || e.dataTransfer.files[0];
    let a = document.getElementById("file").files[0].name
    console.log(a)
    if (file) {
        $('#upload-photo-preview-modal').modal({
            keyboard:false,
            backdrop:false,
            show:true
        })
        var reader = new FileReader();
        reader.onload = function () {
            $('#upload-photo-preview-img').attr('src',this.result)
            // $("img").attr("src", this.result);
        }
        reader.readAsDataURL(file);

        var file = document.getElementById("file").files[0];
        var formData = new FormData();
        formData.append('file', file);
        $.ajax({
            url: "/upload/img",
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            mimeType: "multipart/form-data",
            success: function (data) {
                try{
                    data = JSON.parse(data)
                    $('#upload-photo-preview-img').data('upload-url',data.data.url);
                }catch (e) {
                    console.log("upload fail",e)
                    return
                }
            },
            error: function (data) {
                console.log(data);
            },
            xhr:function(){
                var jqXHR = null;
                if ( window.ActiveXObject )
                {
                    jqXHR = new window.ActiveXObject( "Microsoft.XMLHTTP" );
                }
                else
                {
                    jqXHR = new window.XMLHttpRequest();
                }

                //Upload progress
                jqXHR.upload.addEventListener( "progress", function ( evt )
                {
                    if ( evt.lengthComputable )
                    {
                        var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
                        //Do something with upload progress
                        $('#upload-photo-preview-progress').css('width',percentComplete+'%')
                        $('#upload-photo-preview-progress').text(percentComplete+'%')
                        console.log( 'Uploaded percent', percentComplete );
                    }
                }, false );

                //Download progress
                jqXHR.addEventListener( "progress", function ( evt )
                {
                    if ( evt.lengthComputable )
                    {
                        var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
                        //Do something with download progress
                        console.log( 'Downloaded percent', percentComplete );
                    }
                }, false );

                return jqXHR;
            }
        });
    }
});

/**
 * 打开上传文件按钮
 */
function open_file_to_upload()
{
    $("#file").click()
}

/**
 * 发送图片事件
 */
function send_photo_event()
{
    let photo_url = $('#upload-photo-preview-img').data('upload-url');
    if(!photo_url){
        console.log('未获得photo上传地址')
        return false;
    }
    let media = {
        media: photo_url,
        media_width: 0,
        media_height: 0,
        media_type: 1,
    }
    let imgObj = new Image()
    imgObj.src = $('#upload-photo-preview-img').attr('src')
    media.media_width = imgObj.width;
    media.media_height = imgObj.height;
    send_message_with_photo($('#upload-photo-preview-caption').val(),media)
    $('#upload-photo-preview-modal').modal('hide')
}

/**
 * 判断用户访客是否登记信息
 * 如果没有需要先进行完善资料
 */
try{
    let user = JSON.parse(localStorage.getItem('user'))
    if(!user || !user.name || user.name ==''){
        $('#perfect-profile-modal').modal({keyboard:false,backdrop:false,show:true})
    }else{
        get_messages();
        setInterval(function(){
            pull_message();
        },1000*2);
    }
}catch (e) {

}


// tests
// $('#about-room-profile-modal').modal('show')
// $('#upload-photo-preview-modal').modal('show')
