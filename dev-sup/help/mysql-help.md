## Mysql，连接池中间件

应用通过向本中间件发送http请求，中间件来代理执行sql并返回json结果。

**注意：**

本中间件不适用复杂的数据库字段，如字节集字段等。目前仅限使用于普通数据类型字段（int、text、string、long…）的sql执行，基本满足于普通的增、删、改、查操作。

您可以修改源码来完善不足之处，比如对于字节集字段，进行base64编程成文本来返回。



## 配置说明：

`\mod\mysql\config.ini`

```ini
[sys]
;是否开启mysql连接池
on=1
;连接池数量
connectSum=30
adress=localhost
user=root
password=123456
database=test_db

;mysql连接池基本请求地址
api_url=/api/mysql
```



## 执行sql

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
	"errmsg":"success"
}
```

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
	"errcode":401,
	"errmsg":"1146：Table 'test_db.userinf' doesn't exist"
}
```

```json
{
	"errcode":501,
	"errmsg":"server busy."
}
```

