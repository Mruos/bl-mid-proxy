
public class Test {
    public static void main(String[] args) throws Exception {

        MidMysql mysql=new MidMysql("http://192.168.1.2:9606/api/mysql");
        System.out.println(mysql.sql("select * from test_userinfo"));

        MidRedis redis=new MidRedis("http://192.168.1.2:9606/api/redis");
        System.out.println(redis.order("SET name 小明"));
        System.out.println(redis.set("test", "test", 100000000L));
        System.out.println(redis.get("name"));

        MidLogging logging=new MidLogging("http://192.168.1.2:9606/api/logging",true);

        logging.info("info", "this is info msg");
        logging.important("important", "this is important msg");
        logging.warning("warning", "this is warning msg");
        logging.error("error", "this is error msg");
        logging.input("input", "this is input msg");
        logging.output("output", "this is output msg");
        logging.system("system", "this is system msg");
        logging.debug("debug", "this is debug msg");
        logging.custom("custom", "this is custom msg","宋体",16,0,0,1664325);


    }
}
