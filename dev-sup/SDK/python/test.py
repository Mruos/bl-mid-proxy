import MidProxySDK

if __name__ == '__main__':
    mysql = MidProxySDK.MidMysql('http://192.168.1.2:9606/api/mysql')

    res = mysql.sql("select * from userinfo")

    print(res)

    redis = MidProxySDK.MidRedis('http://192.168.1.2:9606/api/redis')

    res = redis.order("set 小明 14岁")

    print(res)

    res=redis.set("小若","18岁")

    print(res)

    res=redis.get("小若")

    print(res)


    logging = MidProxySDK.MidLogging('http://192.168.1.2:9606/api/logging')

    logging.info('test','this is info message.')