<?php 


/*bl-mid-proxy，中间件代理端

目前本中间件，主要实现mysql连接池、redis连接池、crontab任务定时器三大功能。

本中间件实质为一个代理服务端，通过http请求进行通信，任何编程语言都可以对接。

优势：

1. 应用服务端不需要再引入和编写比如数据库连接管理类代码，降低工作量。易于初学者上手，比如对于通常使用的数据库增删改查，你只需要知道sql语句怎么写即可；
2. 便于对接，任何编程语言皆可，只要实现了http请求到本中间件，即可得到结果；
3. 小巧，相较其他解释型编程语言实现本系列功能，本独立中间件效率更高、系统资源占用小，受环境依赖基本无。


本程序遵从BSD开源协议，谢谢使用与参与改进，丰富功能。

Github：https://github.com/Mruos/bl-mid-proxy

Gitee：https://gitee.com/burnlord/bl-mid-proxy

by：Mruos

QQ/wechat：812465371

web：http://burnlord.com

软件、插件、APP、小程序、网站……，可联系~*/


header("Content-Type: text/html;charset=utf-8");

/**
 * mysql中间件
 *
 * @param  string $api_url 中间件的mysql基础地址
 */

class MidMysql{

	private $api_url="";

	public function __construct($api_url){    // 构造函数
		$this->api_url=$api_url;
	}

	public function __destruct(){             // 析构函数，销毁时执行

	}

	public function sql($sql){

        $http=new Myhttp();

        $json=[];
        $json['sql']=$sql;
        $json=json_encode($json,JSON_UNESCAPED_UNICODE);

        $res=$http->post($this->api_url,$json);

        return $res;

    }

}


/**
 * redis中间件
 *
 * @param  string $api_url 中间件的redis基础地址
 */

class MidRedis{

    private $api_url="";

    public function __construct($api_url){    // 构造函数
        $this->api_url=$api_url;

    }

    public function __destruct(){             // 析构函数，销毁时执行

    }

    public function order($db,$order){

        $http=new Myhttp();

        $json=[];
        $json['db']=$db;
        $json['order']=$order;
        $json=json_encode($json,JSON_UNESCAPED_UNICODE);

        $res=$http->post($this->api_url.'/order',$json);

        return $res;

    }


    public function set($db,$key,$value,$outtime=0){

        $http=new Myhttp();

        $json=[];
        $json['db']=$db;
        $json['key']=$key;
        $json['value']=$value;
        $json['outtime']=$outtime;
        $json=json_encode($json,JSON_UNESCAPED_UNICODE);

        $res=$http->post($this->api_url.'/set',$json);

        return $res;

    }

    public function get($db,$key){

        $http=new Myhttp();

        $json=[];
        $json['db']=$db;
        $json['key']=$key;
        $json=json_encode($json,JSON_UNESCAPED_UNICODE);

        $res=$http->post($this->api_url.'/get',$json);

        return $res;

    }

}


/**
 * 执行 HTTP 请求
 *
 * @param  string $url 执行请求的url地址
 * @param  mixed  $params  表单参数
 * @param  int    $timeout 超时时间
 * @param  string $method  请求方法 post / get
 * @return array  结果数组
 */

class Myhttp{


	public function post($url, $params=[]){

		return $this->sendSGHttp($url,$params,$method="post");

	}


	public function get($url){

		return $this->sendSGHttp($url);
	}



	private function sendSGHttp($url, $params=[], $method = 'get', $timeout = 30)
	{
		if (null == $url) return null;

		$curl = curl_init();

    if ('get' == $method) {//以GET方式发送请求
    	curl_setopt($curl, CURLOPT_URL, $url);
    } else {//以POST方式发送请求
    	curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);//post提交方式
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);//设置传送的参数
    }

    curl_setopt($curl, CURLOPT_HEADER, false);//设置header
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//要求结果为字符串且输出到屏幕上
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);//设置等待时间

    $res = curl_exec($curl);//运行curl
    $err = curl_error($curl);

    if (false === $res || !empty($err)) {
    	$Errno = curl_errno($curl);
    	$Info = curl_getinfo($curl);
    	curl_close($curl);
    	
        //print_r($Info);

    	return $err. ' result: ' . $res . 'error_msg: '.$Errno;
    }
    curl_close($curl);//关闭curl
    return $res;
}
}


?>