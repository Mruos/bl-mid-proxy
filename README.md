## bl-mid-proxy，中间件代理端

目前本中间件，主要实现`mysql连接池`、`redis连接池`、`crontab任务定时器`三大功能。

本中间件实质为一个服务端，通过http请求进行通信，**任何编程语言都可以对接**。

提供简单的SDK（e、python、php、java），其他语言可自行组装http请求进行通讯。

![](http://images.burnlord.com/s/app/blmidproxy/20201231133121.png)

### 初衷与目的：

1. mysql数据库的增删改查基本是后端编程的核心代码，占据很大的代码工作量。开发者需要去找寻合适的支持库，在代码中引用支持库，建立与管理连接、特定语言框架还有数据库模型语法等等，对于初学者难于上手；

   本中间件为独立的http服务端，其内部有数据库连接池进行mysql管理，接受http请求执行sql，并返回json数据，方便各语言直接转成适用本语言的对象使用。

   开发者只需要把要执行的sql语句作为参数，发送一个post请求到本中间件即可执行并获得json数据结果。无需去管其他任何与数据库相关的代码，只需要知道日常使用的增删改查的sql语句即可；

2.  redis缓存与mysql同样的道理，开发者只需要知道redis的命令即可，无需去管所在的语言使用什么redis库，怎么引用库，如何操作等等；

3. 定时器，程序总免不了存在定时执行、周期执行的任务。在以往的编程中，我们可能是创建一个线程来去定时 执行周期事件，或者死循环等等方式，对于一些语言（尤其解释型语言）来说，不当的方式可能代码逻辑上难处理，系统资源占用还高；

   本中间件提供类似Linux的crontab功能，可以通过http去回调周期代码、运行指定程序、执行sql语句等，完成定时执行功能；

   

### 优势：

1. 应用服务端代码不需要再引入和编写比如数据库连接管理类代码，降低工作量。易于初学者上手，比如对于通常使用的数据库增删改查，你只需要知道sql语句怎么写即可；
2. 便于对接，任何编程语言皆可，只要实现了http请求到本中间件，即可得到结果；
3. 小巧，相较其他解释型编程语言实现本系列功能，本独立中间件效率更高、系统资源占用小，受环境依赖基本无（windows系统运行即可，无需任何依赖）；

### 劣势：

1. 因为本中间件通过http通信，而这必然有一个网络传输的过程。如果应用服务端与本中间件在本地同一IP下（同一电脑上）那么这个带来的时间损害极低（建议在一起）。如果是分布式分布，不在同一局域网中，便存在网络的影响，速度受网络条件影响；

2. 可能存在技术盲区。比如数据库执行查询的sql语句存在字节集字段的，因为sql查询返回的是json数据，无法包含字节集数据，所以字节集字段无法使用（可考虑修改源码，对字节集进行base64成文本添加到返回json中或者以字节集文件形式等）；

3. 大型应用请自行测试本中间件是否够用，本中间件定为小型应用快速成型开发；

   

### 权限验证：

整个中间件程序仅有一个IP白名单。所以，终端用户直接与本中间件进行http通讯，将会使比如mysql等面临风险。（当前成品版要求必须有白名单，若自行修改源代码取消白名单限制，请注意风险！）

强烈建议，白名单仅限本机内网或指定IP进行连接。



### 推荐：

不知如何安装mysql、redis等，可通过[phpstudy](https://www.xp.cn/)，一键安装启动。

phpstudy：[https://www.xp.cn/](https://www.xp.cn/)

![](http://images.burnlord.com/s/iedkp/20201224094440.png)

![](http://images.burnlord.com/s/iedkp/20201224094513.png)



## API示例：

其他示例请参考help说明。

**url：** `/api/mysql `     （默认，修改后以修改为准）

**method：** POST

**data：**

```json
{
	"sql":"select * from userinfo limit 0,2"
}
```

**success：**

```json
{
	"errcode":200,
	"errmsg":"success",
	"data":[                          //  查询语句，将包含data数据结果
        {
            "id":1,
            "name":"小明",
            "age":10
        },
        {
            "id":2,
            "name":"小李",
            "age":14
        }
    ]
}
```

**fail：**

```json
{
	"errcode":401,             // sql语句执行错误，返回401
	"errmsg":"1146：Table 'test_db.userinf' doesn't exist"
}
```

```json
{
	"errcode":501,             // 中间件因为繁忙未能受理
	"errmsg":"server busy."
}
```



## SDK：

提供e、python、php、java的SDK，内容较为简单，仅是封装了请求。其他语言自行参考help的请求方式发送post对接。

1. e语言


![](http://images.burnlord.com/s/app/blmidproxy/20201231104527.png)

2. python

![](http://images.burnlord.com/s/app/blmidproxy/20201231123650.png)

3. php

![](http://images.burnlord.com/s/app/blmidproxy/20201231123709.png)

4. java

![](http://images.burnlord.com/s/app/blmidproxy/20201231123737.png)



### 感谢：

- 服务端组件：HPsocket     [官网](https://www.oschina.net/p/hp-socket)

- redis：使用的是E2EE的redis同步客户端。   [官网](http://e2ee.jimstone.com.cn/)

- crontab：使用的为`vSpear`所开源贡献的定时器。     [主页](https://blog.52nyg.com/)



### 关于：

本程序遵从BSD开源协议，谢谢使用与参与改进，丰富功能。有问题欢迎留言，期望大佬们有使用到的不断完善与分享~

Github：[https://github.com/Mruos/bl-mid-proxy](https://github.com/Mruos/bl-mid-proxy)

Gitee：[https://gitee.com/burnlord/bl-mid-proxy](https://gitee.com/burnlord/bl-mid-proxy)

by：Mruos

QQ/wechat：[812465371](tencent://message/?uin=812465371)

web：[burnlord.com](http://burnlord.com)

软件、插件、APP、小程序、网站……，可联系~

