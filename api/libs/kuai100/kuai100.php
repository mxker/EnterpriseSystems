<?php
namespace api\libs;

use Curl\Curl;

class Kuai100 {

    private static $obj = NULL; //实例对象
    private $callback ='/express-callback/callback'; //回调地址
    private $key = 'nEVYIHCg1056';
    private $schema = 'json'; //返回数据
    private $params = array();
    private $url = 'http://www.kuaidi100.com/poll';

    private function __construct($schema = 'json', $params = array()) {
        $this->schema = $schema;
        $this->params['parameters']['callbackurl'] = $_SERVER['HTTP_HOST'] . $this->callback;
        $this->params['key'] = $this->key;
    }

    private function __clone() {
        
    }

    /**
     * 实例化单例对象
     * @return type
     */
    public static function App($schema = 'json', $params = array()) {
        if (self::$obj == NULL) {
            self::$obj = new Kuai100($schema,$params);
        }
        self::$obj->params['company'] = isset($params['company']) && (!empty($params['company'])) ? $params['company'] : self::$obj->params['company'];
        self::$obj->params['number'] = isset($params['number']) && (!empty($params['number'])) ? $params['number'] : self::$obj->params['number'];
        self::$obj->params['from'] = isset($params['from']) && (!empty($params['from'])) ? $params['from'] : self::$obj->params['from'];
        self::$obj->params['to'] = isset($params['to']) && (!empty($params['to'])) ? $params['to'] : self::$obj->params['to'];
        return self::$obj;
    }

    /**
     * 向快100发送订阅请求
     */
    public function subscribe() {
        if (empty($this->schema)) {
            $ret = array('result' => FALSE, 'returnCode' => 100, 'message' => 'schema参数不能为空!');
            return $ret;
        }
        if (empty($this->key)) {
            $ret = array('result' => FALSE, 'returnCode' => 100, 'message' => '参数key不能为空!');
            return $ret;
        }
        if (!isset($this->params['company']) || empty($this->params['company'])) {
            $ret = array('result' => FALSE, 'returnCode' => 100, 'message' => 'params参数必须包含company元素!');
            return $ret;
        }
        if (!isset($this->params['number']) || empty($this->params['number'])) {
            $ret = array('result' => FALSE, 'returnCode' => 100, 'message' => 'params参数必须包含number订单号元素!');
            return $ret;
        }


        $post_data = array();
        $post_data["schema"] =  $this->schema;
        $post_data['param']=  json_encode($this->params);


        $o = "";
        foreach ($post_data as $k => $v) {
            $o.= "$k=" . urlencode($v) . "&";  //默认UTF-8编码格式
        }

        $post_data = substr($o, 0, -1);

        $curl = new Curl();
        $curl->setOpt($curl, CURLOPT_POST, 1);
        $curl->setOpt($curl, CURLOPT_HEADER, 0);
        $curl->setOpt($curl, CURLOPT_URL, $this->url);
        $curl->setOpt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $curl->setOpt($curl, CURLOPT_POSTFIELDS, $post_data);

        $ret = $curl->exec($curl);

//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_URL, $this->url);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
//        $ret = curl_exec($ch);

//        if (strpos(\Yii::$app->basePath, 'moyuntv')) {
//            file_put_contents('/moyun/www/Myshop/data/log/log.txt',var_export($ret ,TRUE).'-----'.date('Y-m-d H:i:s').PHP_EOL,FILE_APPEND);
//        }
        
        return $ret;
    }

}
