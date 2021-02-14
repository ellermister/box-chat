<p align="center"><a href="https://laravel.com" target="_blank"><img src="box2.png" width="150"></a></p>

<p align="center">
<img alt="GitHub commit activity" src="https://img.shields.io/github/commit-activity/m/ellermister/box-chat">
<img alt="GitHub" src="https://img.shields.io/github/license/ellermister/box-chat">
</p>


## 箱子聊天室

箱子聊天室旨在为解决无法上外网的用户，提供一个简单的网页链接来与指定人进行私有会话聊天。来保障聊天内容不受监管、审查的安全通信服务。

当然你也可以将其用于其他业务方面，比如网页客服帮助，用户售后系统等等。

- 匿名会话聊天
- 支持 PC / 移动端设备
- 支持配置多种渠道访客
- 支持访客消息通过 Telegram 进行通知和回复
- 支持访客消息通过 Email 通知 
- 限制常见内嵌非安全浏览器运行（详见后文非安全浏览器UA）

箱子聊天室是完全开源，你可以自行修改其任何环节的功能，来更适配符合自己需求。

## 开发进度

- [x] 基础聊天功能
- [x] 媒体图文文件
- [ ] 大文件上传
- [ ] 前端传输加密
- [ ] 管理配置页面
- [x] Telegram Bot 消息通知及快捷回复
- [ ] Telegram Bot 一对多转发消息
- [ ] Email 通知未读



## 运作流程

箱子聊天室提供基础的网页版一对一私密聊天会话功能，你安装完成后，你可以将你生成的 URL 分享到一些社交软件中的个人信息页面。

需要联系你的人将点击链接与你进行实时会话。

如果你不在线。箱子聊天室还会通过EMAIL、Telegram等方式通知到你，你也可以在 Telegram 内部直接进行回复消息，整个过程安全加密可匿，访客无需提供任何个人隐私信息，原则上只要访客设备不被监听窃取是非常安全的，所有的数据都将通过你自己设立的加密方式、自己的秘钥加密并传输到自己的服务器。

### 安全至关重要

欢迎你了解一些其他相关的安全方面的隐私项目.

- **[匿名化短链接 ](https://x007.in/)**

## 安装

箱子聊天室是通过 PHP 语言编写而成的开源程序，你可以很轻松地将其部署在服务器上，甚至是虚拟主机里面。

## 屏蔽浏览器列表

主要是手机浏览器

| 浏览器      | UA关键字        |
| ----------- | --------------- |
| 微信浏览器  | MQQBrowser      |
| 腾讯浏览器  | TencentTraveler |
| 360SE浏览器 | 360SE           |
| QQ浏览器    | QQBrowser       |
| 百度浏览器  | BIDUBrowser     |
| UC浏览器    | UBrowser        |
| 猎豹浏览器  | LBBROWSER       |
| 2345浏览器  | 2345chrome      |
| 搜狗浏览器  | SE 2.X          |

## License

这个项目开源可用，允许修改和再次发布，请保留版权及分享给更多的人。
