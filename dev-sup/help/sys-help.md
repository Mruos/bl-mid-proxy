## bl-mid-proxy，中间件代理端

目前本中间件，主要实现`mysql连接池`、`redis连接池`、`crontab任务定时器`三大功能。

本中间件实质为一个代理服务端，通过http请求进行通信，**任何编程语言都可以对接**。

提供简单的SDK（e、python、php、java）。

### 优势：

1. 应用服务端不需要再引入和编写比如数据库连接管理类代码，降低工作量。易于初学者上手，比如对于通常使用的数据库增删改查，你只需要知道sql语句怎么写即可；
2. 便于对接，任何编程语言皆可，只要实现了http请求到本中间件，即可得到结果；
3. 小巧，相较其他解释型编程语言实现本系列功能，本独立中间件效率更高、系统资源占用小，受环境依赖基本无。

### 劣势：

1. 因为本中间件通过http通信，而这必然有一个网络传输的过程。如果应用服务端与本中间件在本地同一IP下（同一电脑上）那么这个带来的时间损害极低（建议在一起）。如果是分布式分布，不在同一局域网中，便存在网络的影响，速度受网络条件影响。

2. 可能存在技术盲区。比如数据库执行查询的sql语句存在字节集字段的，因为sql查询返回的是json数据，无法包含字节集数据，所以字节集字段无法使用（可考虑修改源码，对字节集进行base64成文本添加到返回json中或者以字节集文件形式等）。

3. 大型应用请自行测试本中间件是否够用，本中间件定为小型应用快速成型开发。

   

### 权限验证：

整个中间件程序仅有一个白名单，未有其他验证。所以，终端用户直接与本中间件进行http通讯，将会使比如mysql等面临风险。（当前发行版要求必须有白名单，自行修改源代码取消白名单请注意风险！）

所以强烈建议，白名单仅限本机内网或指定IP进行连接。



### 主界面说明：

![](http://images.burnlord.com/s/app/blmidproxy/20201231161137.png)



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
```



### 感谢：

- 服务端组件：HPsocket     [官网](https://www.oschina.net/p/hp-socket)

- redis：使用的是E2EE的redis同步客户端。   [官网](http://e2ee.jimstone.com.cn/)

- crontab：使用的为`vSpear`所写定时器。     [主页](https://blog.52nyg.com/)



### 关于：

本程序遵从BSD开源协议，谢谢使用与参与改进，丰富功能。

Github：[https://github.com/Mruos/bl-mid-proxy](https://github.com/Mruos/bl-mid-proxy)

Gitee：[https://gitee.com/burnlord/bl-mid-proxy](https://gitee.com/burnlord/bl-mid-proxy)

by：Mruos

QQ/wechat：[812465371](tencent://message/?uin=812465371)

web：[burnlord.com](http://burnlord.com)

软件、插件、APP、小程序、网站……，可联系~

