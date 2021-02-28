
public class MidRedis {
    private String url;

    public MidRedis(String url) {
        this.url = url;
    }

    public  String order(String order) throws Exception {
        String json= "{\n" +
                "    \"order\":\""+order+"\"\n" +
                "}";
        return HttpUtil.doPost(url+"/order", json);
    }

    public  String set(String key, String value, Long outtime) throws Exception {
        String json="{\n" +
                "    \"key\":\""+key+"\",\n" +
                "    \"value\":\""+value+"\",\n" +
                "    \"outtime\":"+outtime+"}";
        return HttpUtil.doPost(url+"/set", json);
    }

    public  String get(String key) throws Exception {
        String json= "{\n" +
                "    \"key\":\""+key+"\"\n" +
                "}";
        return HttpUtil.doPost(url+"/get", json);
    }

}
