## bl-mid-proxy，中间件代理端

目前本中间件，主要实现`mysql连接池`、`redis连接池`、`crontab任务定时器`、`logging多色日志输出`，四大功能。

本中间件实质为一个服务端，通过http请求进行通信，**任何编程语言都可以对接**。

提供简单的SDK（e、python、php、java），其他语言可自行组装http请求进行通讯。



### 优势：

1. 应用服务端代码不需要再引入和编写比如数据库连接管理类代码，降低工作量。易于初学者上手，比如对于通常使用的数据库增删改查，你只需要知道sql语句怎么写即可；

2. 分离连接池、日志、任务线程等到独立的exe，利于主程序的稳定性；

3. 便于对接，任何编程语言皆可，只要实现了http请求到本中间件，即可得到结果；

4. 小巧，相较其他解释型编程语言实现本系列功能，本独立中间件效率更高、系统资源占用小，受环境依赖基本无（windows系统运行即可，无需任何依赖）；

   

### 权限验证：

中间件程序仅有一个IP白名单。

终端用户直接与本中间件进行http通讯，将会使比如mysql等面临风险（若要解除此限制，请自行修改源代码）。

强烈建议，白名单仅限本机内网或指定IP进行连接。



### 主界面说明：

![](http://images.burnlord.com/s/app/blmidproxy/20210226162231.png)



## 使用帮助：

- 日志区右键，可打开辅助功能菜单；

  ![](http://images.burnlord.com/s/app/blmidproxy/20210227163903.png)

  

  - 双击命令输入区，即可打开快捷输入辅助；

    ![](http://images.burnlord.com/s/app/blmidproxy/20210227163940.png)

    

- crontab任务管理与热加载；

  ![](http://images.burnlord.com/s/app/blmidproxy/20210227164048.png)

  

### 推荐：

不知如何安装mysql、redis等，可通过[phpstudy](https://www.xp.cn/)，一键安装启动。

phpstudy：[https://www.xp.cn/](https://www.xp.cn/)

![](http://images.burnlord.com/s/iedkp/20201224094440.png)

![](http://images.burnlord.com/s/iedkp/20201224094513.png)



## 程序结构

```php
/mod                   // 各功能模块及配置目录
/log                   // 日志文件夹
/ssl-cert              // HPsocket，SSL配置，一般不需要开启SSL
/HPsocket4C.dll
/libmySQL.dll
/config.ini            // 主配置文件
/help.html             // 帮助文件
```



## 配置文件（config.ini）

```ini
[sys]
;标题
title=bl-mid-proxy
;图标，要在文件夹（ico）里面，只需填写图标名，无需带后缀
ico=18
;自动运行，固定自启（启动程序后自动启动服务端，非开机自启）
autoRun=1

;是否开启debug模式，开启后日志文件将会输出更多的信息
onDebug=1

;端口为空，则不开启
port_http=9606
port_https=

;心跳地址，可以通过访问（GET）此地址来确认本中间件是否在运行
api_heart_url=/api/heart

;白名单，仅限填写IP地址（本地可为：localhost），必须设置。
;多个以英文逗号分隔，如：localhost,192.168.1.8,12.36.21.12
whitelist=localhost

[log]
;日志文件名格式，默认：[start-time]-[end-time]，可自定义组合包含此2变量
;注意：日志文件会先以时间命名，仅当结束后重置为设置的名称
fileName=[start-time]-[end-time]

;日志文件记录样式，默认：[num]丨[time]丨[type]丨[content]
;支持变量：[num]、[time]、[type]、[content]
fileContentFormat=[num]丨[time]丨[type]丨[content]

;前台显示格式，默认：[num].[[type]] [content]    --< [time]
uiContentFormat=[num].[[type]] [content]      --< [time]

```



### 感谢：

- 服务端组件：HPsocket     [官网](https://www.oschina.net/p/hp-socket)

- redis：使用的是E2EE的redis同步客户端。   [官网](http://e2ee.jimstone.com.cn/)




### 关于：

本程序遵从BSD开源协议，谢谢使用与参与改进，丰富功能。

Github：[https://github.com/Mruos/bl-mid-proxy](https://github.com/Mruos/bl-mid-proxy)

Gitee：[https://gitee.com/burnlord/bl-mid-proxy](https://gitee.com/burnlord/bl-mid-proxy)

by：Mruos

QQ/wechat：[812465371](tencent://message/?uin=812465371)

web：[burnlord.com](http://burnlord.com)

软件、插件、APP、小程序、网站……，可联系~

