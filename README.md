# bl-mid-proxy，中间件代理端

目前本中间件，主要实现`mysql连接池`、`redis连接池`、`crontab任务定时器`、`logging多色日志输出`，四大功能。

本中间件实质为一个服务端，通过http请求进行通信，**任何编程语言都可以对接**。

提供简单的SDK（e、python、php、java），其他语言可自行组装http请求进行通讯。

![](https://gitee.com/burnlord/bl-mid-proxy/raw/master/dev-sup/help/1.png)



# 目录：

- 目的

- 优势

- 权限

- 帮助

- SDK

  

## 目的：

**本中间件主要解决以下问题：**

1. mysql数据库的增删改查，基本是后端编程的核心代码，占据很大的代码工作量，无论什么使用什么编程语言，都大概需要了解这些：

   - 所用语言需要使用什么的mysql支持库、包、模块，要安装引用它；

   - 掌握所用mysql模块的类、函数等方法，需要自己去掌握什么是连接句柄、游标、记录集等；

   - 如果所用语言框架还有sql的集成函数语法，如php的tp框架等，依然需要学习（当然熟练后使用这些更方便）；

   - 如果sql调用多，开发者还需要使用连接池或者自行把mysql模块的类、方法等封装成可靠的mysql连接池来提高sql的执行速度；

     

2. redis缓存数据库同样的道理，依然需要掌握和mysql类似的那些知识点；

   

3. 定时器，程序总免不了存在定时执行、周期执行的任务，这需要我们：

   - 掌握所学语言的多线程技术，因为周期、定时任务我们一般都在独立线程中等待触发或循环执行；

   - 对于一些语言（尤其解释型语言）来说，不当的方式可能代码逻辑上难处理，系统资源占用还高；

     

4. 日志，各语言都有很多成熟的日志模块，且自行设计日志系统也并不复杂，但设计具有可交互界面的尤其带色彩的日志界面就不容易了，对于主流语言，如java、python、php等，他们都是作为后端使用，并不擅长做UI组件界面设计，界面是比较影响程序效率、稳定性的，尤其在多线程的后端程序中；



  **本中间件就是针对上述四大问题，进行的功能封装，独立exe运行，具体来说就是：**

- 中间件内部集成mysql数据库连接池，mysql数据库一切连接、增删改查等都由本中间件处理，开发者程序只需要把要执行的sql语句作为参数，发送一个post请求到本中间件即可执行并获得json数据结果，方便各语言直接转成适用本语言的对象使用。开发者程序中无需去管其他任何与数据库相关的代码，只需要知道日常使用的增删改查的sql语句即可；

  

  **以python为例：**

  

  执行sql（原生请求）：

  ```python
  import requests
  import json
  
  # 测试访问中间件执行sql
  def test_midmysql():
      data = {
          "sql": "select * from test_userinfo limit 0,2"
      }
  
      try:
          log = requests.post('http://192.168.1.2:9606/api/mysql', json=data).text
          
          # 结果为json的文本字符串
          print(log)
          #输出：{"errcode":200,"errmsg":"success","data":[{"id":1,"name":"小明","age":10},{"id":2,"name":"小李","age":14}]}
          
          # 转成python对象类型（字典、列表），以备使用
          tmp = json.loads(log)    
          print(tmp)
     
          #输出：{'errcode': 200, 'errmsg': 'success', 'data': [{'id': 1, 'name': '小明', 'age': 10}, {'id': 2, 'name': '小李', 'age': 14}]}
          
      except:
          print('error')
          
  ```

  

  执行sql（使用sdk）：

  ```python
  import MidProxySDK
  
  mysql=MidProxySDK.MidMysql('http://192.168.1.2:9606/api/mysql')
  
  # 测试调用中间件的SDK执行sql
  def test_midmysql():
  
      res=mysql.sql('select * from test_userinfo limit 0,2')
  
      print(res)
      
      # 输出：{"errcode":200,"errmsg":"success","data":[{"id":1,"name":"小明","age":10},{"id":2,"name":"小李","age":14}]}
  
  ```

  

  **success：**

  ```json
  {
  	"errcode":200,
  	"errmsg":"success",
  	"data":[                 //  查询语句，将包含data数据结果，支持大部分数据类型，且自动转成json的数值、浮点数、逻辑型、文本型
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
  	"errmsg":"1146：Table 'test_db.userinf' doesn't exist"    // 具体的错误原因
  }
  ```

  ```json
  {
  	"errcode":501,             // 中间件因为繁忙未能受理
  	"errmsg":"server busy."
  }
  ```

  

- redis连接池原理同mysql；

  

- 本中间件提供类似Linux的crontab功能，通过创建crontab定时表达式任务，来回调任务功能。支持任务类型：发送http、运行指定程序、执行sql语句。

  

  如在python的flask框架中，当需要定时执行某个功能时：

  ```python
  import MidProxySDK
  
  @app.route('/api/task/clear')      # 把需要执行的任务功能放到一个接口函数中，无需添加触发时间相关代码线程
  def clear_outtime_log():
      mysql=MidProxySDK.MidMysql('http://192.168.1.2:9606/api/mysql')
      mysql.sql("delete from testaa where time_creat>1421023000")
      
  ```

  在中间件创建一个任务：

  `\mod\crontab\tasks\clear_outtime_log.ini`

  ```ini
  [sys]
  ; 每日0时0分1秒执行
  time=1 0 0 * * * *
  
  [info]
  on=1
  type=http
  url=http://192.168.1.2:9606/api/task/clear
  method=get
  ```

  

  如此，当每日0时0分1秒时，中间件会触发任务，发送一个http请求到flask后端，flask后端执行定时任务，开发者不需要管如何利用线程去定时执行任务，只需要写任务的详细逻辑功能即可。

  

- logging，提供多色日志输出，自动创建日志文件以及类似cmd的多色日志输出显示；

  

  本中间件提供8种默认配色日志输出，分别为：`info`、`important`、`warning`、`error`、`input`、`output`、`debug`、`system`，配色配置可直接在配置文件修改，另提供`custom`自定义配色日志输出，您可以把想要的配色日志通过在SDK新建个方法，方法调用custom即可进行增删配色；

  
  
  **python-sdk-demo：**
  
  ```python
  import MidProxySDK
  
  logging=MidProxySDK.MidLogging('http://192.168.1.2:9606/api/logging'，debug=True)
  
  def test_midlogging():
      logging.info('info','this is info msg.')
      logging.important('important', 'this is important msg.')
      logging.warning('warning', 'this is warning msg.')
      logging.error('error', 'this is error msg.')
      logging.input('input', 'this is input msg.')
      logging.output('output', 'this is output msg.')
      logging.system('system', 'this is system msg.')
      logging.debug_('debug_', 'this is debug_ msg.')      # 仅当，MidLogging(debug=True)，时才会实际发送
      logging.custom('custom', 'this is custom msg.',fontSize=16,fontColor=16745623)
      
  ```
  
  ![](http://images.burnlord.com/s/app/blmidproxy/20210227113326.png)
  
  
  
  
  
  **输入命令提交：**
  
  
  
  中间件输入的命令将会通过post提交到设置的url地址。
  
  
  
  **注意：**命令不要以`sys` 、`mysql` 、`redis `、`logging `、`crontab `起始。
  
  ```python
  # python为例
  from flask import Flask, request
  import MidProxySDK
  import json
  
  app = Flask(__name__)
  
  @app.route('/api/logging/input', methods=['POST'])   # 创建一个路由接口，接受中间件的命令
  def test_logging_input():
  
      input = str(request.get_data(), 'utf-8')
      input=json.loads(input)['input']                 # 获取输入的命令
  
      logging = MidProxySDK.MidLogging('http://192.168.1.2:9606/api/logging')   # 输出到中间件的日志
      logging.info('flask', 'had do：' + input)
  
      return ''
  
  ```
  
  ![](http://images.burnlord.com/s/app/blmidproxy/20210227144549.png)



## 优势：

1. 应用服务端代码不需要再引入和编写比如数据库连接管理类代码，降低工作量。易于初学者上手，比如对于通常使用的数据库增删改查，你只需要知道sql语句怎么写即可；

2. 分离连接池、日志、任务线程等到独立的exe，利于主程序的稳定性；

3. 便于对接，任何编程语言皆可，只要实现了http请求到本中间件，即可得到结果；

4. 小巧，相较其他解释型编程语言实现本系列功能，本独立中间件效率更高、系统资源占用小，受环境依赖基本无（windows系统运行即可，无需任何依赖）；

   

## 权限验证：

中间件程序有一个IP白名单。

终端用户直接与本中间件进行http通讯，将会使比如mysql等面临风险（若要解除此限制，请自行修改主程序源代码）。

强烈建议，白名单仅限本机内网或指定IP进行连接。



## 使用帮助：

- 日志区右键，可打开辅助功能菜单；

  ![](http://images.burnlord.com/s/app/blmidproxy/20210227163903.png)

  

  - 双击命令输入区，即可打开快捷输入辅助；

    ![](http://images.burnlord.com/s/app/blmidproxy/20210227163940.png)

    

- crontab任务管理与热加载；

  ![](http://images.burnlord.com/s/app/blmidproxy/20210227164048.png)

  

  - 系统帮助

    ![](http://images.burnlord.com/s/app/blmidproxy/20210227164637.png)

    



## 推荐：

不知如何安装mysql、redis等，可通过[phpstudy](https://www.xp.cn/)，一键安装启动。

phpstudy：[https://www.xp.cn/](https://www.xp.cn/)



## SDK：

提供e、python、php、java的SDK，内容较为简单，仅是封装了请求。其他语言自行参考help的请求方式发送post对接。

1. e语言


![](http://images.burnlord.com/s/app/blmidproxy/20210227184926.png)

2. python

![](http://images.burnlord.com/s/app/blmidproxy/20210227162620.png)

3. php

![](http://images.burnlord.com/s/app/blmidproxy/20210227163407.png)

4. java

![](http://images.burnlord.com/s/app/blmidproxy/20210227211953.png)



## 感谢：

- 服务端组件：HPsocket     [官网](https://www.oschina.net/p/hp-socket)

- redis：使用的是E2EE的redis同步客户端。   [官网](http://e2ee.jimstone.com.cn/)

  


## 关于：

本程序遵从BSD开源协议，谢谢使用与参与改进，丰富功能。有问题欢迎留言，期望大佬们有使用到的不断完善与分享~

Github：[https://github.com/Mruos/bl-mid-proxy](https://github.com/Mruos/bl-mid-proxy)

Gitee：[https://gitee.com/burnlord/bl-mid-proxy](https://gitee.com/burnlord/bl-mid-proxy)

by：Mruos

QQ/wechat：[812465371](tencent://message/?uin=812465371)

web：[burnlord.com](http://burnlord.com)

软件、插件、APP、小程序、网站……，可联系~

