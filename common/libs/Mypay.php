<?php
namespace common\libs;

use Curl\Curl;
/**
* 陌云统一支付平台 基本类
*/
class Mypay{
    const APP_ID = '3635988';
    const SIGN_KEY = 'f1410e21a0294d7a7189899b35ea98e4';//签名key
    const BILL                  = 'bill'; //sdkpay
    const GET_AVAILABLE_BALANCE = 'getAvailableBalance'; //Busness
    const APPLY_NOPWD_REFUND    = 'applyNoPwdRefund'; //Busness
    const APPLY_REFUND          = 'applyRefund'; //Busness
    const APPLY_WITHDRAW        = 'applyWithdraw'; //Busness
    const QUERY_ORDER           = 'queryOrder'; //Busness

    // 陌云支付 接口请求地址 ---需要配置正式测试------
    //const MOYUN_PAY_URL = 'https://mypay.moyuntv.com/Busness/Dataservice';
    //const MOYUN_BUSNESS_URL = 'https://mypay.moyuntv.com/Wappay/Payment/bill';
    const MOYUN_PAY_URL = 'https://tepay.moyuntv.com/Wappay/Payment/bill';
    const MOYUN_BUSNESS_URL = 'https://tepay.moyuntv.com/Busness/Dataservice';
    // Myshop 回调主域 ---需要配置正式测试------
    const NOTIFY_URL_HOST = 'http://myshop.moyuntv.com';

    public static function post($url, $fields, $timeout = NULL){

        $ch = curl_init() ;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields)); // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields); // 在HTTP中的"POST"操作。如果要传送一个文件，需要一个@开头的文件名

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // https请求 不验证hosts

        if ($timeout !== NULL) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        }

        ob_start();
        curl_exec($ch);
        $result = ob_get_contents() ;
        ob_end_clean();

        curl_close($ch) ;

        return $result;
    }

    /**
     * 生成要请求给第三方的参数数组
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组字符串
     */
    public function buildRequestParaToString($para_temp, $key) {
        //待请求参数数组
        $para = $this->buildRequestPara($para_temp, $key);

        //把参数组中所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
        $request_data = $this->myCreateLinkstringUrlencode($para);

        return $request_data;
    }

    /**
     * 生成签名结果
     * @param $para_sort 已排序要签名的数组
     * return 签名结果字符串
     */
    public function buildMysign($para_temp, $key) {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = $this->myParaFilter($para_temp);

        //对待签名参数数组排序
        $para_sort = $this->myArgSort($para_filter);

        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = $this->myCreateLinkstring($para_sort);
        $mysign = $this->myMd5Sign($prestr, $key);
        return $mysign;
    }

    /**
     * 生成要请求给陌云支付的参数数组
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组
     */
    private function buildRequestPara($para_temp, $key) {

        //生成签名结果
        $mysign = $this->buildMysign($para_temp, $key);

        //签名结果与签名方式加入请求提交参数组中
        $para_sort['sign'] = $mysign;
        $para_sort['sign_type'] = 'MD5';
        return $para_sort;
    }


    /**
     * 余额明细查询接口
     * @param array $parameter
     * @return mixed|string
     */
    public static function searchTradeDetail($parameter = array(),$app_id = null) {
        $fields = array(
            'method'    => 'searchTradeDetail',
            'appId'     => $app_id,
            'parameter' => json_encode($parameter)
        );

        return self::dataInteract($fields);
    }

    /**
     * 订单支付状态查询
     * @param array $parameter
     * @return mixed|string
     */
    public static function queryOrder($parameter = array(),$app_id = null) {
        $fields = array(
            'method'    => 'queryOrder',
            'appId'     => $app_id,
            'parameter' => json_encode($parameter)
        );

        return self::dataInteract($fields);
    }

    /**
     * 接口调用基础方法
     * @param null $parameter
     * @return mixed|string
     */
    public static function dataInteract($parameter = null) {
        $returnData = self::post(self::MOYUN_BUSNESS_URL, $parameter);
        $returnData = @json_decode($returnData, true);
        return $returnData;
    }


    public function myCreateLinkstring($para) {
        $arg = "";
        while (list ($key, $val) = each($para)) {
            $arg.=$key . "=" . $val . "&";
        }
        //去掉最后一个&字符
        $arg = substr($arg, 0, count($arg) - 2);

        //如果存在转义字符，那么去掉转义
        if (get_magic_quotes_gpc()) {
            $arg = stripslashes($arg);
        }

        return $arg;
    }

    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
     * @param $para 需要拼接的数组
     * return 拼接完成以后的字符串
     */
    public function myCreateLinkstringUrlencode($para) {
        $arg = "";
        while (list ($key, $val) = each($para)) {
            $arg.=$key . "=" . urlencode($val) . "&";
        }
        //去掉最后一个&字符
        $arg = substr($arg, 0, count($arg) - 2);

        //如果存在转义字符，那么去掉转义
        if (get_magic_quotes_gpc()) {
            $arg = stripslashes($arg);
        }

        return $arg;
    }

    /**
     * 除去数组中的空值和签名参数
     * @param $para 签名参数组
     * return 去掉空值与签名参数后的新签名参数组
     */
    public function myParaFilter($para) {
        $para_filter = array();
        while (list ($key, $val) = each($para)) {
            if ($key == "sign" || $key == "sign_type" || $val == "")
                continue;
            else
                $para_filter[$key] = $para[$key];
        }
        return $para_filter;
    }

    /**
     * 对数组排序
     * @param $para 排序前的数组
     * return 排序后的数组
     */
    public function myArgSort($para) {
        ksort($para);
        reset($para);
        return $para;
    }

    /**
     * 签名字符串
     * @param $prestr 需要签名的字符串
     * @param $key 私钥
     * return 签名结果
     */
    public function myMd5Sign($prestr, $key) {
        $prestr = $prestr . $key;
        return md5($prestr);
    }

    /**
     * 验证签名
     * @param $prestr 需要签名的字符串
     * @param $sign 签名结果
     * @param $key 私钥
     * return 签名结果
     */
    public function myMd5Verify($prestr, $sign, $key) {
        $prestr = $prestr . $key;
        $mysgin = md5($prestr);

        if ($mysgin == $sign) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 实现多种字符编码方式
     * @param $input 需要编码的字符串
     * @param $_output_charset 输出的编码格式
     * @param $_input_charset 输入的编码格式
     * return 编码后的字符串
     */
    public function myCharsetEncode($input, $_output_charset, $_input_charset) {
        $output = "";
        if (!isset($_output_charset))
            $_output_charset = $_input_charset;
        if ($_input_charset == $_output_charset || $input == null) {
            $output = $input;
        } elseif (function_exists("mb_convert_encoding")) {
            $output = mb_convert_encoding($input, $_output_charset, $_input_charset);
        } elseif (function_exists("iconv")) {
            $output = iconv($_input_charset, $_output_charset, $input);
        } else
            die("sorry, you have no libs support for charset change.");
        return $output;
    }

    /**
     * 实现多种字符解码方式
     * @param $input 需要解码的字符串
     * @param $_output_charset 输出的解码格式
     * @param $_input_charset 输入的解码格式
     * return 解码后的字符串
     */
    public function myCharsetDecode($input, $_input_charset, $_output_charset) {
        $output = "";
        if (!isset($_input_charset))
            $_input_charset = $_input_charset;
        if ($_input_charset == $_output_charset || $input == null) {
            $output = $input;
        } elseif (function_exists("mb_convert_encoding")) {
            $output = mb_convert_encoding($input, $_output_charset, $_input_charset);
        } elseif (function_exists("iconv")) {
            $output = iconv($_input_charset, $_output_charset, $input);
        } else
            die("sorry, you have no libs support for charset changes.");
        return $output;
    }
}