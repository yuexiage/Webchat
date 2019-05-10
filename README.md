## Webchat 模拟web微信登录，获取用户好友列表功能
### 环境依赖
- php v5 以上
- CURL 扩展
### 部署步骤
- 本程序需放到webServer中的项目目录中，能够访问到本程序的index.php文件即可
### 操作流程
- [x] 正常访问本程序的index.php文件，页面将出现一个二维码。需要用户手动微信扫描二维码，并且同意登录。
- [x] 授权完毕，点击“确认扫描后点击此处”连接，可获得返回的好友信息。
- [x] 本程序只提供一个思路，具体需要用到自己业务流程中的方法，还需要自己修改。
### 目录
 ├── Readme.md                   // help
 ├── index.php                   // 入库文件
 ├── lib                         // 方法
 │   ├── curlRequest.php         // curl模拟请求方法
 │   ├── wxgetcontact.php        // 获取好友实现方法
