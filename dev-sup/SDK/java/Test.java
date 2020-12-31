package cn.sdk.controller;

/**
 * @author hexiangxiang
 * @date 2020/12/24 13:16
 **/
public class Test {
    public static void main(String[] args) throws Exception {

        MidMysql midMysql=new MidMysql("http://192.168.1.2:9606/api/mysql");
        System.out.println(midMysql.sql("select * from userinfo"));

        MidRedis midRedis=new MidRedis("http://192.168.1.2:9606/api/redis");
        System.out.println(midRedis.order("SET name 小明"));
        System.out.println(midRedis.set("test", "test", 100000000L));
        System.out.println(midRedis.get("name"));

    }
}
