
public class MidLogging {
    private String url ;
    private Boolean debug=false;

    public MidLogging(String url,Boolean debug) {
        this.url = url;
        this.debug=debug;
    }

    public MidLogging() {
    }

    public String info(String type,String content) throws Exception {
   
        return send_default("info", type, content);
    }

    public String important(String type,String content) throws Exception {
   
        return send_default("important", type, content);
    }

    public String warning(String type,String content) throws Exception {
   
        return send_default("warning", type, content);
    }

    public String error(String type,String content) throws Exception {
   
        return send_default("error", type, content);
    }

    public String input(String type,String content) throws Exception {
   
        return send_default("input", type, content);
    }

    public String output(String type,String content) throws Exception {
   
        return send_default("output", type, content);
    }

    public String system(String type,String content) throws Exception {
   
        return send_default("system", type, content);
    }

    public String debug(String type,String content) throws Exception {

        if(this.debug==true){
            return send_default("debug", type, content);

        }else{
            return "";
        }
        
    }

    public String custom(String type,String content,String fontName,int fontSize,int fontShow,int fontY,int fontColor) throws Exception{

        /*
        :param type:自定义日志类型
        :param content:自定义日志内容
        :param fontName:字体名称
        :param fontSize:字体大小
        :param fontShow:字体效果，1=粗体  2=斜体  4=下划线  8=删除线  16=禁止更改   可以相加为新值（3=粗体+斜体）
        :param fontY:纵向偏移，>0 上标   <0 下标
        :param fontColor:颜色，打开中间件的输入辅助提示，可进行颜色数值调试
        :return:
        */

        String json="{\"level\":\"custom\",\"type\":\""+type+"\",\"content\":\""+content+"\",\"style\":{\"fontName\":\""+fontName+"\",\"fontSize\":"+fontSize+",\"fontShow\":"+fontShow+",\"y\":"+fontY+",\"color\":"+fontColor+"}}";

        return HttpUtil.doPost(url,json);

    }


    private String send_default(String level,String type,String content) throws Exception{

        String json="{\"level\":\""+level+"\",\"type\":\""+type+"\""+",\"content\":\""+content+"\"}";

        return HttpUtil.doPost(url,json);

    }

}

