# bl-mid-proxy，SDK

import requests, json

class MidMysql:
    api_url = ""

    def __init__(self, apiUrl):
        self.api_url = apiUrl

        return

    def sql(self, sql):
        '''
        :param sql:
        :return:
        '''
        data = {
            "sql": sql
        }

        return sendHttp(self.api_url, data)


class MidRedis:
    api_url = ""

    def __init__(self, apiUrl):
        self.api_url = apiUrl

        return

    def order(self, order, db=0):
        '''
        :param db: redis数据库编号，默认：0
        :param order: redis命令
        :return:
        '''
        data = {
            "db": db,
            "order": order
        }

        return sendHttp(self.api_url + "/order", data)

    def set(self, key, value, outtime=0, db=0):
        '''
        :param key:
        :param value:
        :param outtime: 默认：0，不超时
        :param db: redis数据库编号，默认：0
        :return:
        '''
        data = {
            "db": db,
            "key": key,
            "value": value,
            "outtime": outtime
        }

        return sendHttp(self.api_url + "/set", data)

    def get(self, key, db=0):
        '''
        :param key:
        :param db: redis数据库编号，默认：0
        :return:
        '''
        data = {
            "db": db,
            "key": key
        }

        return sendHttp(self.api_url + "/get", data)


def sendHttp(url, data):
    '''
    发送SDK请求
    :param data:
    :return:
    '''

    data = json.dumps(data, ensure_ascii=False).encode('utf-8')

    try:
        res = requests.post(url, data)

    except Exception as error:
        print('error request：' + str(error))

    return res.text
