<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $settings->get('room_name') }} - BoxChat 聊天室</title>
    <meta name="keywords" content="{{ $settings->get('site_keyword') }}">
    <meta name="description" content="{{ $settings->get('site_description') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
          crossorigin="anonymous">
    <link type="text/css" href="https://weixin.sb/style.min.css" rel="stylesheet" />
    <link type="text/css" href="/css/room.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script>
        let room_setting = @json($settings);
    </script>
</head>
<body style="background-color: beige;">
<div class="container h-100" style="overflow-y: hidden;">
    <div class="room-header">
        <div class="container" style="padding:0px">
            <div class="row" >
                <div class="col-md-12">
                    <div  style="display: flex;background-color: lightsteelblue;;padding:8px;width:100%">
                        <div style="color: #fff;width: 100%;text-align: center;" >{{ $settings->get('room_name') }}</div>
                        <div  style="text-align: center">
                            <div  style="width: 48px;    color: #fff;" data-toggle="dropdown">
                                <svg class="bi bi-three-dots-vertical" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                </svg>
                            </div>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button" onclick="$('#about-room-profile-modal').modal('show')">查看资料</button>
                                <button class="dropdown-item" type="button" onclick="$('#about-me-profile-modal').modal('show')">关于我</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="room-body" style="position:fixed;top: 42px;bottom: 64px;left: 0px;width: 100%;" dstyle="margin-top: 42px;margin-bottom: 64px;">
        <div class="room-content container h-100" style="padding:0px;overflow-y: scroll;">
            <div class="lite-chatbox" id="rom">

{{--            @include("layouts/test-chat")--}}

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
                        <div  style="align-self: flex-end;padding: 8px;" onclick="open_file_to_upload()">
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

    <div class="modal fade fill-profile" id="perfect-profile-modal" tabindex="-1" role="dialog" aria-labelledby="perfect-profile-label" aria-hidden="true" data-backdrop="false" keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="perfect-profile-label">我的资料</h5>
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
                    <button type="button" class="btn btn-primary" onclick="session_save_name()">保存</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="upload-photo-preview-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false" keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">上传图片</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <figure class="figure" style="margin-bottom: 0px;">
                        <div style="overflow-y: auto;max-height: 500px;">
                            <div class="preview-flex-photos">
{{--                                <div class="photos-box"><img src="/img/1.jpg" class="figure-img img-fluid rounded"  id="upload-photo-preview-img"></div>--}}
{{--                                <div class="photos-box"><img src="/img/2.jpg" class="figure-img img-fluid rounded"  id="upload-photo-preview-img"></div>--}}
{{--                                <div class="photos-box"><img src="/img/3.jpg" class="figure-img img-fluid rounded"  id="upload-photo-preview-img"></div>--}}
{{--                                <div class="photos-box"><img src="/img/4.jpg" class="figure-img img-fluid rounded"  id="upload-photo-preview-img"></div>--}}
{{--                                <div class="photos-box"><img src="/img/5.jpg" class="figure-img img-fluid rounded"  id="upload-photo-preview-img"></div>--}}
                            </div>
                        </div>
                        <figcaption class="figure-caption">
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" id="upload-photo-preview-progress" role="progressbar" style="width: 0%;" >0%</div>
                            </div>
                            <label for="upload-photo-preview-caption" class="col-form-label">caption:</label>
                            <textarea class="form-control" id="upload-photo-preview-caption"></textarea>
                        </figcaption>
                    </figure>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" onclick="send_photo_event()">发送消息</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="about-room-profile-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false" keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">聊天室信息</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <figure class="figure" style="margin-bottom: 0px;display: flex">
                        <img src="/avatar/default.jpg" id="about-room-profile-avatar" class="figure-img img-fluid rounded" style="width: 50px;border-radius: 50% !important;">
                        <figcaption class="figure-caption" style="margin-left: 20px">
                            <label id="about-room-profile-name"></label>
                            <p id="about-room-profile-desc"></p>
                        </figcaption>
                    </figure>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="about-me-profile-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false" keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">我的资料</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <figure class="figure" style="margin-bottom: 0px;display: flex">
                        <img src="/avatar/default.jpg" id="about-me-profile-avatar" class="figure-img img-fluid rounded" style="width: 50px;border-radius: 50% !important;">
                        <figcaption class="figure-caption" style="margin-left: 20px">
                            <label id="about-me-profile-name"></label>
                            <p id="about-me-profile-desc"></p>
                        </figcaption>
                    </figure>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
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
<script id="tpl-photos" type="text/html">
    {{if photos.length > 1}}
    <div class="preview-flex-photos" style="width:{{show_width}}px">
        {{each photos}}
        <div class="photos-box" style="width:{{position[$index].width}}px;height:{{position[$index].height * 320}}px"><img src="{{$value.img}}" class="figure-img img-fluid"></div>
        {{/each}}
    </div>
    {{else}}
    <div class="preview-flex-photos">
        {{each photos}}
        <div class="photos-box" ><img src="{{$value.img}}" class="figure-img img-fluid"></div>
        {{/each}}
    </div>
    {{/if}}
</script>
<script id="tpl-message-group-photo"  type="text/html">
    <span class="content" style="display:inline-block !important; ">
          <div class="message-group-photos" style="width:{{$data.show_width}}px;">
             {{each $data.album message index}}
                <div class="message-group-box" style="width: {{$data.position[index].width}}px;height: {{$data.position[index].height * $data.show_width}}px">
                      <img src="{{message.media}}" />
                </div>
             {{/each}}
             <div class="clearfix"></div>
         </div>
    {{@ $data.message_text}}
        {{ if $data.id == 0 }}
             <div class="message-sending spinner-border spinner-border-sm text-danger" role="status" id="_msg_id_{{$data._msg_id}}">
                <span class="sr-only">Loading...</span>
              </div>
        {{/if}}
    </span>
</script>
<script id="tpl-message2" type="text/html">
    {{each list}}

    {{ if $value.to_user_id != 0 }}
    <div class="cleft cmsg">
        <img class="headIcon radius" ondragstart="return false;" oncontextmenu="return false;" src="{{ setting('room_avatar', '/avatar/default.jpg') }}">
        <span class="name">{{$value.from_name}}</span>
        {{if $value.media_type == 1}}
        {{if $value.album}}
             <% include( 'tpl-message-group-photo', $value) %>
        {{else}}
        <span class="content"  style="max-width: {{$value.media_width}}px;">

								{{if mobile_check()}}
								<div style="--aspect-ratio:{{$value.media_width}}/{{$value.media_height}};">
								  <img src="{{$value.media}}" />
								</div>
								{{else}}
								<div style="--aspect-ratio:{{$value.media_width}}/{{$value.media_height}};">
								  <img src="{{$value.media}}" />
								</div>
								{{/if}}

            {{@ $value.message_text}}
						</span>
        {{/if}}

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

								{{if mobile_check()}}
								<div style="--aspect-ratio:{{$value.media_width}}/{{$value.media_height}};">
								  <img src="{{$value.media}}" />
								</div>
								{{else}}
								<div style="--aspect-ratio:{{$value.media_width}}/{{$value.media_height}};">
								  <img src="{{$value.media}}" />
								</div>
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
        <img class="headIcon radius" ondragstart="return false;" oncontextmenu="return false;" src="{{ get_user('avatar', '/avatar/default.jpg') }}">
        <span class="name">{{$value.from_name}}</span>
        {{if $value.media_type == 1}}
        {{if $value.album}}
        <% include( 'tpl-message-group-photo', $value) %>
        {{else}}
            <span class="content"  style="max-width: {{$value.media_width}}px;">

                {{if mobile_check()}}
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
                {{ if $value.id == 0 }}
                    <div class="message-sending spinner-border spinner-border-sm text-danger" role="status" id="_msg_id_{{$value._msg_id}}">
                        <span class="sr-only">Loading...</span>
                    </div>
                {{/if}}
            </span>
        {{/if}}

        {{else if $value.media_type == 2}}
        <span class="content"  style="max-width: {{$value.video_width}}px;">
							<div  style="--aspect-ratio:{{$value.video_width}}/{{$value.video_height}};" >
								<video width="{{$value.video_width}}" height="{{$value.video_height}}" controls="" autoplay="" muted="" loop="">
								  <source src="{{$value.media}}" type="video/mp4">
								</video>
							</div>


						{{@ $value.message_text}}
            {{ if $value.id == 0 }}
             <div class="message-sending spinner-border spinner-border-sm text-danger" role="status" id="_msg_id_{{$value._msg_id}}">
                    <span class="sr-only">Loading...</span>
                </div>
            {{/if}}
						</span>
        {{else if $value.media_type == 3}}
             <span class="content"  style="max-width: {{$value.media_width}}px;">

                                    {{if mobile_check()}}
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
            {{ if $value.id == 0 }}
                    <div class="message-sending spinner-border spinner-border-sm text-danger" role="status" id="_msg_id_{{$value._msg_id}}">
                        <span class="sr-only">Loading...</span>
                    </div>
                {{/if}}
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

<script id="tpl-message" type="text/html">
    {{each list}}

    {{ if $value.to_user_id != 0 }}
    <div class="cleft cmsg">
        <img class="headIcon radius" ondragstart="return false;" oncontextmenu="return false;" src="{{ setting('room_avatar', '/avatar/default.jpg') }}">
        <span class="name">{{$value.from_name}}</span>
        {{if $value.media_type == 1}}
        <span class="content"  style="max-width: {{$value.media_width}}px;">

								{{if mobile_check()}}
								<div style="--aspect-ratio:{{$value.media_width}}/{{$value.media_height}};">
								  <img src="{{$value.media}}" />
								</div>
								{{else}}
								<div style="--aspect-ratio:{{$value.media_width}}/{{$value.media_height}};">
								  <img src="{{$value.media}}" />
								</div>
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

								{{if mobile_check()}}
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
        <img class="headIcon radius" ondragstart="return false;" oncontextmenu="return false;" src="{{ get_user('avatar', '/avatar/default.jpg') }}">
        <span class="name">{{$value.from_name}}</span>
        {{if $value.media_type == 1}}
        <span class="content"  style="max-width: {{$value.media_width}}px;">

								{{if mobile_check()}}
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
            {{ if $value.id == 0 }}
                <div class="message-sending spinner-border spinner-border-sm text-danger" role="status" id="_msg_id_{{$value._msg_id}}">
                    <span class="sr-only">Loading...</span>
                </div>
            {{/if}}
						</span>
        {{else if $value.media_type == 2}}
        <span class="content"  style="max-width: {{$value.video_width}}px;">
							<div  style="--aspect-ratio:{{$value.video_width}}/{{$value.video_height}};" >
								<video width="{{$value.video_width}}" height="{{$value.video_height}}" controls="" autoplay="" muted="" loop="">
								  <source src="{{$value.media}}" type="video/mp4">
								</video>
							</div>


						{{@ $value.message_text}}
            {{ if $value.id == 0 }}
             <div class="message-sending spinner-border spinner-border-sm text-danger" role="status" id="_msg_id_{{$value._msg_id}}">
                    <span class="sr-only">Loading...</span>
                </div>
            {{/if}}
						</span>
        {{else if $value.media_type == 3}}
             <span class="content">
                 <div class="message-group-photos" style="width:{{$value.media.show_width}}px;">
                 {{each $value.media.photos photo photo_index}}
                    <div class="message-group-box" style="width: {{$value.media.position[photo_index].width}}px;height: {{$value.media.position[photo_index].height * 380}}px">
                          <img src="{{photo.img}}" />
                    </div>
                 {{/each}}
                 <div class="clearfix"></div>
                 </div>
                {{@ $value.message_text}}
                {{ if $value.id == 0 }}
                     <div class="message-sending spinner-border spinner-border-sm text-danger" role="status" id="_msg_id_{{$value._msg_id}}">
                        <span class="sr-only">Loading...</span>
                      </div>
                {{/if}}
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
<script src="/js/room.js" charset="utf-8"></script>
</body>
</html>
