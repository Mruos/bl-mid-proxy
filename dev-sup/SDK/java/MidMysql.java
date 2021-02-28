
public class MidMysql {
    private String url ;

    public MidMysql(String url) {
        this.url = url;
    }

    public MidMysql() {
    }

    public String sql(String sql) throws Exception {
        String json="{\n" +
                "    \"sql\":\""+sql+"\"\n" +
                "}";

        return HttpUtil.doPost(url,json);
    }
}

