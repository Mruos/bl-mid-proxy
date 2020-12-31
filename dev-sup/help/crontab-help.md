## crontab，定时器

目前支持三大任务配置：

1. 定时向指定的地址发送http请求（get、post）；
2. 定时运行本地的指定程序；
3. 定时执行sql语句；

通过本定时器，可以进行一些周期事件的操作，比如：

1. php程序需要周期运行一些操作，可以写个php页面，让本定时器定期访问这个页面来调用；
2. mysql数据里需要每天清除一些历史数据，可以让本定时器定时执行相关sql语句；



## 配置说明

`\mod\crontab\config.ini`

```ini
[sys]
;是否开启定时器
on=1
;基本请求地址，暂时无效，不支持http请求来增删任务配置
api_url=/api/crontab
```



## 任务增删：

**任务目录：**`\mod\crontab\tasks`

此目录中，每一个ini文件为一个配置，文件名为任务名，可以在此新建、删除配置，中间件启动后会自动添加所有的任务配置。

如果不希望中断中间件来增删任务，可以通过中间件界面上的增删任务（edit）来进行，只需要输入任务名即可进行增删。（增加需保证配置文件存在，删除需保证任务已添加）



## 任务配置

#### http请求：

```ini
[sys]
;任务执行时间，为crontab表达式，请见下方crontab详解。此处代表每分钟的第5秒执行一次。
time=5 * * * * *
;任务最大执行次数，为空则不限制。
times_maxdo=

;以下的配置可以随时修改，修改保存文件后便会生效，无需重启。
[info]
;是否开启本任务
on=1
;任务类型，http的固定http
type=http
;http请求地址
url=http://192.168.1.2:9606/api/heart
;http请求类型，仅支持get、post
method=get
;请求参数，仅限post，get请直接添加到url中
params={"name":"test"}
```

![](http://images.burnlord.com/s/app/blmidproxy/20201231162445.png)

#### 运行程序：

```ini
[sys]
;任务执行时间，为crontab表达式，请见下方crontab详解。此处代表每分钟的第5秒执行一次。
time=5 * * * * *
;任务最大执行次数，为空则不限制。
times_maxdo=

;以下的配置可以随时修改，修改保存文件后便会生效，无需重启。
[info]
;是否开启本任务
on=1
;固定run
type=run
;程序地址，本地的绝对路径
path=F:\baiduCloudSync\baiduCloudSync\a.develop\1.code\2.frame-sdk-core\bl-mid-proxy\dev\crontab-run-demo.exe
;附加参数
params=param1 param2 param3
```

![](http://images.burnlord.com/s/app/blmidproxy/20201231162540.png)

#### 执行sql：

```ini
[sys]
;任务执行时间，为crontab表达式，请见下方crontab详解。此处代表每分钟的第5秒执行一次。
time=5 * * * * *
;任务最大执行次数，为空则不限制。
times_maxdo=

;以下的配置可以随时修改，修改保存文件后便会生效，无需重启。
[info]
;是否开启本任务
on=1
;固定sql
type=sql
;sql语句         ★★  请注意仅限通过本中间件的mysql连接池调用此sql语句
sql=insert into userinfo (name,age) values ('test-insert','188')
```

![](http://images.burnlord.com/s/app/blmidproxy/20201231162633.png)



## crontab表达式：

**教程地址：**[https://www.runoob.com/linux/linux-comm-crontab.html](https://www.runoob.com/linux/linux-comm-crontab.html)

**格式为：**`[秒] [分] [时] [日] [月] [星期几] `

参数一共分为6段。时间可以可以使用`*`来代表所有，也可以用数字指定固定的时间，注意每段之间空格分隔。

| 表达式         | 说明                                                |
| -------------------- | ------------------------------------------------------------ |
| 0 0 0 * * *          | 每天0点整执行                                                |
| 0 0,15,30,45 * * * * | 每小时的0分、15分、30分和45分执行                            |
| 0 0,30 8-21 * * * *  | 每天08点到21点之间，每隔半小时执行一次                       |
| */3 * * * * *        | 每隔3秒执行一次，只支持对应时间段内能够被整除的数。如秒为60，能被60整除的数 1、2、3、4、5、6、10、15等等 |

**时间范围：**

- [秒] 可以是从0到59之间的任何整数。
- [分] 可以是从0到59之间的任何整数。
- [时] 可以是从0到23之间的任何整数。
- [日] 表示日期，可以是从1到31之间的任何整数。
- [月] 表示月份，可以是从1到12之间的任何整数。
- [周] 表示星期几，可以是从0到6之间的任何整数，这里的0代表星期日。

