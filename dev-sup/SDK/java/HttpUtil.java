
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.PrintStream;
import java.net.HttpURLConnection;
import java.net.URL;

/**
 * @author hexiangxiang
 * @date 2020/12/25 8:37
 **/
public class HttpUtil {
    public static String doPost(String url, String params) throws Exception {
        // 编码请求参数
        URL restURL = new URL(url);
        int t = 0;// 调用接口出错次数
        while (t < 3) {
            try {
                /*
                 * 此处的urlConnection对象实际上是根据URL的请求协议(此处是http)生成的URLConnection类
                 * 的子类HttpURLConnection
                 */
                HttpURLConnection conn = (HttpURLConnection) restURL.openConnection();
                // conn.setConnectTimeout(5000);
                // conn.setReadTimeout(5000);
                // 请求方式
                conn.setRequestMethod("POST");
                // 设置是否从httpUrlConnection读入，默认情况下是true; httpUrlConnection.setDoInput(true);
                conn.setDoOutput(true);
                // allowUserInteraction 如果为 true，则在允许用户交互（例如弹出一个验证对话框）的上下文中对此 URL 进行检查。
                conn.setAllowUserInteraction(false);

                PrintStream ps = new PrintStream(conn.getOutputStream());
                ps.print(params);

                ps.close();

                BufferedReader bReader = new BufferedReader(new InputStreamReader(conn.getInputStream(), "UTF-8"));

                String line, resultStr = "";

                while (null != (line = bReader.readLine())) {
                    resultStr += line;
                }
               
                bReader.close();

                return resultStr;
            } catch (Exception e) {
                t++;
                e.printStackTrace();
            }
        }

        throw new Exception("网络异常,请稍后再试");

    }

}
