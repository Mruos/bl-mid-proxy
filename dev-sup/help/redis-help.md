## redis，连接池中间件

应用通过向本中间件发送http请求，中间件来代理执行redis命令并返回json结果。



## 配置说明：

`\mod\redis\config.ini`

```ini
[sys]
;是否开启redis
on=1

ip=127.0.0.1
port=6379           
password=
;基础请求地址
api_url=/api/redis

;redis各数据库的连接池数量，请不要在本配置节点添加其他配置
[dbsum]
;0=10，表示与redis的0号数据库建立10个连接，其他自定
0=10
1=10
```



## 执行redis命令

**url：** `/api/redis/order`     （基础请求地址+`/order`）

**method：** POST

**data：**

```json
{
	"order":"SET name 小明"
}
```

**success：**

```json
{
	"errcode":200,
	"errmsg":"回执的内容"
}
```

**fail：**

```json
{
	"errcode":100,
	"errmsg":"错误原因"
}
```



## 提交缓存

**url：** `/api/redis/set`     （基础请求地址+`/set`）

**method：** POST

**data：**

```json
{
	"key":"name",
    "value":"小明",
    "outtime":5000     // 超时时间，如果为13位数字则视为超时的时间戳，否则为超时的毫秒数
}
```

**success：**

```json
{
	"errcode":200,
	"errmsg":"success"
}
```

**fail：**

```json
{
	"errcode":100,
	"errmsg":"错误原因"
}
```



## 获取缓存

**url：** `/api/redis/get`     （基础请求地址+`/get`）

**method：** POST

**data：**

```json
{
	"key":"name"
}
```

**success：**

```json
{
	"errcode":200,
	"errmsg":"小明"
}
```

**fail：**

```json
{
	"errcode":100,
	"errmsg":"错误原因"
}
```

