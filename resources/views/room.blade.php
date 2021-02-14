<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>微信，是一个生活垃圾</title>
    <meta name="keywords" content="微信,weixin,wechat,微信是一个生活垃圾,微信网页版">
    <meta name="description" content="一款坑坏全人类的通讯工具。支持单人、多人参与。通过手机网络发送语音、图片、视频和文字最终因'被举报'无法'查看">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
          crossorigin="anonymous">
    <link type="text/css" href="https://weixin.sb/style.min.css" rel="stylesheet" />
    <link type="text/css" href="/css/room.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body style="background-color: beige;">
<div class="container h-100" style="overflow-y: scroll;">
    <div class="room-header">
        <div class="container" style="padding:0px">
            <div class="row" >
                <div class="col-md-12">
                    <div  style="display: flex;background-color: lightsteelblue;;padding:8px;width:100%">
                        <div style="color: #fff;width: 100%;text-align: center;" >Eller的聊天室</div>
                        <div  style="text-align: center">
                            <div  style="width: 48px;    color: #fff;" data-toggle="dropdown">
                                <svg class="bi bi-three-dots-vertical" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                </svg>
                            </div>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button">查看资料</button>
                                <button class="dropdown-item" type="button">分享链接</button>
                                <button class="dropdown-item" type="button">关于我</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="room-body row h-100" style="margin-top: 42px;margin-bottom: 64px;overflow-y: scroll;">
        <div class="lite-chatbox" id="rom" >
            <div class="tips">
                <span>2021/02/01</span>
            </div>
            <div class="cright cmsg">
                <img class="headIcon radius" ondragstart="return false;"  oncontextmenu="return false;"  src="https://eller.tech/avatar" />
                <span class="name">Eller</span>
                <span class="content">在吗？</span>
            </div>
            <div class="cleft cmsg">
                <img class="headIcon radius" ondragstart="return false;"  oncontextmenu="return false;"  src="/avatar/default.jpg" />
                <span class="name">琳</span>
                <span class="content" style="max-width: max-content;">怎么了？</span>
            </div>
            <div class="cright cmsg">
                <img class="headIcon radius" ondragstart="return false;"  oncontextmenu="return false;"  src="https://eller.tech/avatar" />
                <span class="name">Eller</span>
                <span class="content">发几张图片</span>
            </div>
            <div class="cleft cmsg">
                <img class="headIcon radius" ondragstart="return false;"  oncontextmenu="return false;"  src="/avatar/default.jpg" />
                <span class="name">琳</span>
                <span class="content"style="max-width: 1123px;">
                    <div style="--aspect-ratio:1123/749;">
                          <img src="/img/1.png?1" />
                    </div>
                    嗯
                </span>
            </div>
            <div class="cleft cmsg">
                <img class="headIcon radius" ondragstart="return false;"  oncontextmenu="return false;"  src="/avatar/default.jpg" />
                <span class="name">琳</span>
                <span class="content"style="max-width: 1123px;">

                    <ul class="flex-photos" style="display: flex;flex-wrap: wrap;">
                          <div style="width:<?php echo 1280*200/720 ?>px;flex-grow:<?php echo 1280*200/720 ?>"><i style="padding-bottom:<?php echo 720/1280*100 ?>%"></i> <img src="/img/1.jpg" alt="A Toyota Previa covered in graffiti" loading="lazy" style=";background-color: cadetblue;"></div>
                          <div style="width:<?php echo 957*200/1280 ?>px;flex-grow:<?php echo 957*200/1280 ?>"><i style="padding-bottom:<?php echo 1280/957*100 ?>%"></i> <img src="/img/2.jpg" alt="A Toyota Previa covered in graffiti" loading="lazy" style="background-color: antiquewhite"></div>
                      <div style="width:<?php echo 1067*200/1280 ?>px;flex-grow:<?php echo 1067*200/1280 ?>"><i style="padding-bottom:<?php echo 1280/1067*100 ?>%"></i> <img src="/img/3.jpg" alt="A Toyota Previa covered in graffiti" loading="lazy" style="background-color: coral"></div>
                        <div style="width:<?php echo 814*200/1280 ?>px;flex-grow:<?php echo 814*200/1280 ?>"> <i style="padding-bottom:<?php echo 1280/814*100 ?>%"></i><img src="/img/4.jpg" alt="A Toyota Previa covered in graffiti" loading="lazy" style="background-color: darkseagreen"></div>
                          <div style="width:<?php echo 1280*200/1061 ?>px;flex-grow:<?php echo 1280*200/1061 ?>"><i style="padding-bottom:<?php echo 1061/1280*100 ?>%"></i><img src="/img/5.jpg" alt="A Toyota Previa covered in graffiti" loading="lazy" style="background-color: deepskyblue"></div>


                  </ul>

                </span>
            </div>
        </div>
    </div>

    <div class=" input-container">
        <div class="container" style="padding:0px">
            <div class="row">
                <div class="col-md-12">
                    <div class="" style="display: flex;background-color: #fff;padding:8px">
                        <div  class="composer_rich_textarea form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2"
                              contenteditable="true"
                        ></div>
                        <div  style="align-self: flex-end;padding: 8px;" onclick="openFileToUpload()">
                            <svg  class="bi bi-file-earmark-plus" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 1H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h5v-1H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h5v2.5A1.5 1.5 0 0 0 10.5 6H13v2h1V6L9 1z"/>
                                <path fill-rule="evenodd" d="M13.5 10a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                                <path fill-rule="evenodd" d="M13 12.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/>
                            </svg>
                        </div>
                        <input type="file" id="file" style="display: none;">
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade fill-profile" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">我的资料</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="profile-your-name" class="col-form-label">名字:</label>
                            <input type="text" class="form-control" id="profile-your-name" placeholder="你的名字">
                            <small class="form-text text-muted">在这里输入你的名字，让我了解你是谁</small>
                        </div>
                        <div class="form-group">
                            <label for="profile-remark-text" class="col-form-label">备注内容:</label>
                            <textarea class="form-control" id="profile-remark-text" placeholder="如果你想备注更多信息可以填在这里"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="saveName()">保存</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="upload-photo-preview-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">上传图片</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <figure class="figure">
                        <img  src="/img/1.jpg" class="figure-img img-fluid rounded"  id="upload-photo-preview-img">
                        <figcaption class="figure-caption">
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" id="upload-photo-preview-progress" role="progressbar" style="width: 25%;" >25%</div>
                            </div>
                        </figcaption>
                    </figure>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js" crossorigin="anonymous"></script>
<script src="/js/jquery.appear.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
<script src="https://unpkg.com/art-template@4.13.2/lib/template-web.js" charset="utf-8"></script>
@verbatim
<script id="tpl-message" type="text/html">
    {{each list}}

    {{ if $value.to_user_id != 0 }}
    <div class="cleft cmsg">
        <img class="headIcon radius" ondragstart="return false;" oncontextmenu="return false;" src="/avatar/default.jpg">
        <span class="name">{{$value.from_name}}</span>
        {{if $value.media_type == 1}}
        <span class="content"  style="max-width: {{$value.media_width}}px;">

								{{if mobileCheck()}}
								<div style="--aspect-ratio:{{$value.media_width}}/{{$value.media_height}};">
								  <img src="{{$value.media}}" />
								</div>
								{{else}}
								<div style="--aspect-ratio:{{$value.media_width}}/{{$value.media_height}};">
								  <img src="{{$value.media}}" />
								</div>
            <!-- <img class="unload-img" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 {{$value.media_width}} {{$value.media_height}}'%3E%3C/svg%3E" data-src="https://weixin.sb{{$value.media}}" style="width: {{$value.media_width}}px;height: {{$value.media_height}}px;" onload="imgOnLoad(this)"><br> -->
								{{/if}}

            {{@ $value.message_text}}
						</span>
        {{else if $value.media_type == 2}}
        <span class="content"  style="max-width: {{$value.video_width}}px;">
							<div  style="--aspect-ratio:{{$value.video_width}}/{{$value.video_height}};" >
								<video width="{{$value.video_width}}" height="{{$value.video_height}}" controls="" autoplay="" muted="" loop="">
								  <source src="{{$value.media}}" type="video/mp4">
								</video>
							</div>


						{{@ $value.message_text}}
						</span>
        {{else if $value.media_type == 3}}
        <span class="content"  style="max-width: {{$value.media_width}}px;">

								{{if mobileCheck()}}
								<div style="--aspect-ratio:{{$value.media_width}}/{{$value.media_height}};">
								  <img src="{{$value.media}}" />
								</div>
								{{else}}
								<div style="--aspect-ratio:{{$value.media_width}}/{{$value.media_height}};">
								  <img src="{{$value.media}}" />
								</div>
            <!-- <img class="unload-img" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 {{$value.media_width}} {{$value.media_height}}'%3E%3C/svg%3E" data-src="https://weixin.sb{{$value.media}}" style="width: {{$value.media_width}}px;height: {{$value.media_height}}px;" onload="imgOnLoad(this)"><br> -->
								{{/if}}

            {{@ $value.message_text}}
						</span>
        {{else if $value.media_type == 4}}
             <span class="content message-media-video"  style="max-width: {{$value.media_width}}px;">
                <div  style="--aspect-ratio:{{$value.media_width}}/{{$value.media_height}};" >
                    <video width="{{$value.media_width}}" height="{{$value.media_height}}" controls="" autoplay="" muted="" loop="">
                      <source src="{{$value.media}}" type="video/mp4">
                    </video>
                </div>
            {{@ $value.message_text}}
            </span>
        {{else}}
            <span class="content" style="max-width: max-content;">
                {{@ $value.message_text}}
            </span>
        {{/if}}
    </div>

    {{ else if $value.from_user_id != 0 }}
    <div class="cright cmsg">
        <img class="headIcon radius" ondragstart="return false;" oncontextmenu="return false;" src="/avatar/default.jpg">
        <span class="name">{{$value.from_name}}</span>
        {{if $value.media_type == 1}}
        <span class="content"  style="max-width: {{$value.media_width}}px;">

								{{if mobileCheck()}}
								<div style="--aspect-ratio:{{$value.media_width}}/{{$value.media_height}};">
								  <img src="{{$value.media}}" />
								</div>
								{{else}}
								<div style="--aspect-ratio:{{$value.media_width}}/{{$value.media_height}};">
								  <img src="{{$value.media}}" />
								</div>
            <!-- <img class="unload-img" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 {{$value.media_width}} {{$value.media_height}}'%3E%3C/svg%3E" data-src="https://weixin.sb{{$value.media}}" style="width: {{$value.media_width}}px;height: {{$value.media_height}}px;" onload="imgOnLoad(this)"><br> -->
								{{/if}}

            {{@ $value.message_text}}
						</span>
        {{else if $value.media_type == 2}}
        <span class="content"  style="max-width: {{$value.video_width}}px;">
							<div  style="--aspect-ratio:{{$value.video_width}}/{{$value.video_height}};" >
								<video width="{{$value.video_width}}" height="{{$value.video_height}}" controls="" autoplay="" muted="" loop="">
								  <source src="{{$value.media}}" type="video/mp4">
								</video>
							</div>


						{{@ $value.message_text}}
						</span>
        {{else}}
        <span class="content" style="max-width: max-content;">
						{{@ $value.message_text}}
        {{ if $value.id == 0 }}
            <div class="message-sending spinner-border spinner-border-sm text-danger" role="status" id="_msg_id_{{$value._msg_id}}">
                <span class="sr-only">Loading...</span>
            </div>
        {{/if}}
        </span>

        {{/if}}
    </div>
        {{/if}}
    {{/each}}
</script>
@endverbatim
<script>
    let message_request_ids = [];
    let is_first = true;


    $(document.body).on('appear', '.message-media-video', function(e, $affected) {
        $(e.currentTarget).find('video')[0].currentTime = 0
        $(e.currentTarget).find('video')[0].play()
        console.log($(e.currentTarget).find('video')[0],'播放')
    });
    $(document.body).on('disappear', '.message-media-video', function(e, $affected) {
        $(e.currentTarget).find('video')[0].pause()
        $(e.currentTarget).find('video')[0].currentTime = 0
        console.log($(e.currentTarget).find('video')[0],'停止')
    });
    $('.room-body').scroll(function(){
        $.force_appear();
    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function imgOnLoad(img)
    {
        if($(img).hasClass('unload-img')){
            $(img).removeClass('unload-img');
            $(img).attr('src',$(img).data('src'));
            img.removeEventListener('onload', imgOnLoad);
            img.onload = function(){};
        }
    }
    function mobileCheck() {
        let check = false;
        (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
        return check;
    };
    function buildImg()
    {

    }



    // $(function() {
    //     let last_id = false;
    //     $.ajax({
    //         url: '/api/news',
    //         dataType: "json",
    //         success: function(ret) {
    //             let html = template('tpl-message', {
    //                 list: ret,
    //                 mobileCheck:mobileCheck
    //             });
    //             if(ret.length>0){
    //                 last_id = ret[0].id;
    //             }
    //             $('#rom').prepend(html);
    //             if (is_first) {
    //                 is_first = false;
    //                 $(document).scrollTop($(document).height());
    //             }
    //         }
    //     })
    //     let is_lock = false;
    //     $(window).scroll(function(event) {
    //         if($(document).scrollTop() < 800 && !is_first){
    //             if(is_lock){return false;}
    //             is_lock = true;
    //             $.ajax({
    //                 url: '/api/news?id='+last_id,
    //                 dataType: "json",
    //                 success: function(ret) {
    //                     console.log(ret);
    //                     let html = template('tpl-message', {
    //                         list: ret,
    //                         mobileCheck:mobileCheck
    //                     });
    //                     if(ret.length>0){
    //                         last_id = ret[0].id;
    //                     }
    //                     $('#rom').prepend(html);
    //                     if (is_first) {
    //                         is_first = false;
    //                         $(document).scrollTop($(document).height());
    //                     }
    //                 },complete:function(){
    //                     is_lock = false;
    //                 }
    //             })
    //         }
    //         // console.log($(document).offset().top)
    //     });
    // });

    function base64_safe_encode(text)
    {
        text = window.btoa(text)
        return text
    }

    function placeCaretAtEnd(el) {
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
            placeCaretAtEnd($('.composer_rich_textarea ').get(0))
            // e.preventDefault();
            //加上e.preventDefault(); shift+ enter效果会有问题，换行符号加上了，但是光标不会跑到下一行，而是回到原来行的行首
            return false;
        }



        // if(event.keyCode ==13 && !(event.shiftKey)){
        //     console.log(event.shiftKey)
        //     // 发送消息
        //     console.log($('.composer_rich_textarea ').text())
        //     return false;
        // }
        // if(event.keyCode ==13 && (event.shiftKey)){
        //     console.log(event.shiftKey)
        //
        //
        //     console.log($('.composer_rich_textarea ').html()+"<br>")
        //     $('.composer_rich_textarea ').html($('.composer_rich_textarea ').html()+"<br>");
        //     placeCaretAtEnd($('.composer_rich_textarea ').get(0))
        //     //这里填写你要做的事件
        //     //TODO
        //     return false;
        // }
    })
    function saveName(){
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
            $('#exampleModal').modal('hide')
        })

    }

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
            mobileCheck:mobileCheck
        });
        $('#rom').append(html);
        $('.room-body').scrollTop($('.lite-chatbox').height())
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
        filterElement('.message-media-video').appear();
    }

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
            mobileCheck:mobileCheck
        });
        $('#rom').append(html);
        $('.room-body').scrollTop($('.lite-chatbox').height())
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
        filterElement('.message-media-video').appear();
    }


    let last_id = 0;
    function get_messages()
    {
        console.log('xxxxxxxxxxx')
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
                mobileCheck:mobileCheck
            });
            $('#rom').append(html);
            if (is_first) {
                is_first = false;
                $('.room-body').scrollTop($('.lite-chatbox').height())
                // $('.lite-chatbox').scrollTop($('.lite-chatbox').height()+$('.lite-chatbox').offset().top);
            }

            // 这里需要过滤，否则会出现一个元素动态绑定两次的情况
            filterElement('.message-media-video').appear();
        })
    }

    let pullMessageLock = false;
    function pullMessage()
    {
        if(pullMessageLock){
            return false;
        }
        pullMessageLock = true;
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
            }

            let scrollUpdate = false;
            if($('.lite-chatbox').height()-($('.room-body').scrollTop()+$('.room-body').height()) < 10){
                scrollUpdate = true
            }
            let html = template('tpl-message', {
                list: messages,
                mobileCheck:mobileCheck
            });
            $('#rom').append(html);
            pullMessageLock = false;
            if(scrollUpdate){
                $('.room-body').scrollTop($('.lite-chatbox').height())
            }

            filterElement('.message-media-video').appear();
        })
    }


    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        // modal.find('.modal-title').text('New message to ' + recipient)
        // modal.find('.modal-body input').val(recipient)
    })
    try{
        let user = JSON.parse(localStorage.getItem('user'))
        if(!user || !user.name || user.name ==''){
            $('#exampleModal').modal({keyboard:false,backdrop:false,show:true})
        }else{
            console.log('dddddddddd')
            get_messages();
            setInterval(function(){
                pullMessage();
            },1000*2);
        }
    }catch (e) {

    }


    function filterElement(element)
    {
        let result = $(element+'[filter-event-video!=1]')
        result.each(function(){
          if(!$(this).attr('filter-event-video')){
              $(this).attr('filter-event-video', 1)
          }
        })
        return result
    }
    // 异步上传图片

    $("#file").change(function (e) {
        var file = e.target.files[0] || e.dataTransfer.files[0];
        let a = document.getElementById("file").files[0].name
        console.log(a)
        if (file) {
            $('#upload-photo-preview-modal').modal('show')
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
                    }catch (e) {
                        console.log("upload fail",e)
                        return
                    }

                    let media = {
                        media: data.data.url,
                        media_width: 0,
                        media_height: 0,
                        media_type: 1,
                    }
                    let imgObj = new Image()
                    imgObj.src = $('#upload-photo-preview-img').attr('src')
                    media.media_width = imgObj.width;
                    media.media_height = imgObj.height;
                    send_message_with_photo('',media)
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
$('#upload-photo-preview-modal').modal('show')
    function openFileToUpload()
    {
        $("#file").click()
    }
</script>
</body>
</html>
