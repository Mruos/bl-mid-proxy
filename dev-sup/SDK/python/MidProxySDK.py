# bl-mid-proxy，SDK

import requests, json


class MidMysql:
    api_url = ""

    def __init__(self, apiUrl):
        self.api_url = apiUrl

        return

    def sql(self, sql):
        """
        :param sql:
        :return:
        """
        data = {
            "sql": sql
        }

        return send_http(self.api_url, data)


class MidRedis:
    api_url = ""

    def __init__(self, apiUrl):
        self.api_url = apiUrl

        return

    def order(self, order, db=0):
        """
        :param db: redis数据库编号，默认：0
        :param order: redis命令
        :return:
        """
        data = {
            "db": db,
            "order": order
        }

        return send_http(self.api_url + "/order", data)

    def set(self, key, value, outtime=0, db=0):
        """
        :param key:
        :param value:
        :param outtime: 默认：0，不超时
        :param db: redis数据库编号，默认：0
        :return:
        """
        data = {
            "db": db,
            "key": key,
            "value": value,
            "outtime": outtime
        }

        return send_http(self.api_url + "/set", data)

    def get(self, key, db=0):
        """
        :param key:
        :param db: redis数据库编号，默认：0
        :return:
        """
        data = {
            "db": db,
            "key": key
        }

        return send_http(self.api_url + "/get", data)


class MidLogging:
    api_url = ""
    debug = False

    def __init__(self, apiUrl, debug=False):
        self.api_url = apiUrl
        self.debug = debug

        return

    def send(self, level, ctype, content):
        data = {
            "level": level,
            "type": ctype,
            "content": content
        }

        return send_http(self.api_url, data)

    def info(self, ctype, content):
        """
        发送SDK请求
        :param ctype:自定义日志类型
        :param content:自定义日志内容
        :return:
        """
        return self.send("info", ctype, content)

    def error(self, ctype, content):
        """
        发送SDK请求
        :param ctype:自定义日志类型
        :param content:自定义日志内容
        :return:
        """
        return self.send("error", ctype, content)

    def debug_(self, ctype, content):
        """
        发送SDK请求
        :param ctype:自定义日志类型
        :param content:自定义日志内容
        :return:
        """

        if not self.debug:
            return ''

        return self.send("debug", ctype, content)

    def warning(self, ctype, content):
        """
        发送SDK请求
        :param ctype:自定义日志类型
        :param content:自定义日志内容
        :return:
        """
        return self.send("warning", ctype, content)

    def important(self, ctype, content):
        """
        发送SDK请求
        :param ctype:自定义日志类型
        :param content:自定义日志内容
        :return:
        """
        return self.send("important", ctype, content)

    def system(self, ctype, content):
        """
        发送SDK请求
        :param ctype:自定义日志类型
        :param content:自定义日志内容
        :return:
        """
        return self.send("system", ctype, content)

    def input(self, ctype, content):
        """
        发送SDK请求
        :param ctype:自定义日志类型
        :param content:自定义日志内容
        :return:
        """
        return self.send("input", ctype, content)

    def output(self, ctype, content):
        """
        发送SDK请求
        :param ctype:自定义日志类型
        :param content:自定义日志内容
        :return:
        """
        return self.send("output", ctype, content)

    def custom(self, ctype, content, fontName='宋体', fontSize=13, fontShow=0, fontY=0, fontColor=16777215):
        """
        发送SDK请求
        :param ctype:自定义日志类型
        :param content:自定义日志内容
        :param fontName:字体名称，默认：宋体
        :param fontSize:字体大小，默认：13
        :param fontShow:字体效果，默认：0  1=粗体  2=斜体  4=下划线  8=删除线  16=禁止更改   可以相加为新值（3=粗体+斜体）
        :param fontY:纵向偏移，>0 上标   <0 下标
        :param fontColor:颜色，打开中间件的输入辅助提示，可进行颜色数值调试
        :return:
        """

        data = {
            "level": 'custom',
            "type": ctype,
            "content": content,
            "style": {
                "fontName": fontName,
                "fontSize": fontSize,
                "fontShow": fontShow,
                "y": fontY,
                "color": fontColor
            }
        }

        return send_http(self.api_url, data)


def send_http(url, data):
    """
    发送SDK请求
    :param url:
    :param data:
    :return:
    """

    data = json.dumps(data, ensure_ascii=False).encode('utf-8')

    try:
        res = requests.post(url, data)

    except Exception as error:
        print('error request：' + str(error))
        return ''

    return res.text
