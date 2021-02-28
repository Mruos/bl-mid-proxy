## logging，多色日志输出

应用通过向本中间件发送http请求，中间件来输出各种日志消息。



## 配置说明：

`\mod\logging\config.ini`

```ini
[sys]
on=1

;日志post地址（接收）
api_url=/api/logging

;输入命令后回调地址（将会以post形式UTF8编码发送输入命令到指定url地址），命令不可以“sys ”开头。
api_url_input_recall=

;目前自带包含8种消息类型配色，如果需要其他配色可以通过调用自定义配色的接口进行自定义显示（为了方便可以在sdk中封装成一个函数），也可以修改主程序源文件
;配色格式由5部分组成，英文逗号分隔：
;1、字体
;2、效果：1=粗体  2=斜体  4=下划线  8=删除线  16=禁止更改   可以相加为新值（3=粗体+斜体）
;3、字号
;4、纵向偏移，>0 上标   <0 下标
;5、颜色，双击命令输入区打开输入辅助提示，选择或调试颜色选择器，即可在界面显示当前颜色的颜色值

[style]
info=宋体,0,13,0,16777215
error=宋体,0,13,0,255
debug=宋体,0,13,0,8421504
warning=宋体,0,13,0,8409343
important=宋体,0,13,0,128
system=宋体,0,13,0,65535
input=宋体,0,13,0,65280
output=宋体,0,13,0,16711824

```



## API接口：

日志接口api不会收到任何数据返回（空数据返回）。

**url：** `/api/logging`     （默认，修改后以修改为准）

**method：** POST

**data：**

普通已定义日志颜色风格输出。

```json
{
	"level":"info",                      // 可选择：info、error、debug、warning、important、system、input、ouput
    "type":"sys",                        // 自定义日志类型
    "content":"this is info message."    // 自定义日志内容
}
```

自定义颜色日志风格输出。

```json
{
	"level":"custom",                    // 自定义输出的内容格式
    "type":"sys",                        // 自定义日志类型
    "content":"this is info message.",   // 自定义日志内容
    "style":{
        "fontName":"宋体",        // 字体名称           
        "fontSize":13,           // 字体大小
        "fontShow":0,            // 字体效果，1=粗体  2=斜体  4=下划线  8=删除线  16=禁止更改   可以相加为新值（3=粗体+斜体）
        "y":0,                   // 纵向偏移，>0 上标   <0 下标
        "color":16777215         // 颜色，打开输入辅助提示，可进行颜色数值调试
    }
}
```