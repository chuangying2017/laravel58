<?php


namespace App\Repository\Config;


class BusinessChannel
{
    const iv = "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";
    public function curl_post($url, $reqData)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($reqData));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $ret = curl_exec($ch);
        curl_error($ch);
        curl_errno($ch);
        return $ret;
    }

    /**
     * 生成签名
     * @param $data
     * @return bool|string
     */
    public function sign($data, $md5Key) {
        $ret = false;
        if(empty($data) || !$data) return false;

        $str = $this->_ascii($data);
        $str .= '&md5key=' . $md5Key;
//        \Jsrv\Logger::info("sign_str",$str,'2');
        if(!empty($str)){
            $ret = strtoupper(utf8_encode(md5($str)));
//            $ret = $str;
        }
        return $ret;
    }

    /**
     * 自定义ascii排序
     */
    public function _ascii($params = array()) {
        if(!empty($params)){
            $p =  ksort($params,SORT_NATURAL | SORT_FLAG_CASE);
            if($p){
                $str = '';
                foreach ($params as $k=>$val){
                    if ($val != null)
                    {
                        $str .= $k .'=' . $val . '&';
                    }
                }
                $strs = rtrim($str, '&');
                return $strs;
            }
        }
        return false;
    }

    /**
     * 自定义arr2url排序
     */
    public function _arr2url($params = array()) {
        if(!empty($params)){
            $str = '';
            foreach ($params as $k=>$val){
                isset($val) && $str .= $k .'=' . urlencode($val) . '&';
            }
            $strs = rtrim($str, '&');
            return $strs;
        }
        return false;
    }

    //加密
    public function encrypt($data, $code = 'base64', $password)
    {
        $json = utf8_encode(json_encode($data, true));
        $ret = false;

        $encrypt = $this->pkcs5Pad($json, '16');
        if ($data) {
            $openssl =  openssl_encrypt($encrypt, 'AES-128-CBC', $password, OPENSSL_RAW_DATA, self::iv);

            $ret = $this->_encode($openssl, $code);
        }
        return $ret;
    }

    //pkcs5加密
    public function pkcs5Pad($text,$blocksize){

        $pad = $blocksize-(strlen($text)%$blocksize);
        $return = $text.str_repeat(chr($pad),$pad);

        return $return;
    }

    private function _encode($data, $code)
    {
        switch (strtolower($code)) {
            case 'base64':
                $data = base64_encode('' . $data);
                break;
            case 'hex':
                $data = bin2hex($data);
                break;
            case 'bin':
            default:
        }
        return $data;
    }

    //解密
    public function decrypt($str, $password)
    {
        $str =  base64_decode($str);
        $data = openssl_decrypt($str, 'AES-128-CBC', $password, OPENSSL_RAW_DATA, self::iv);

        $ret = $this->pkcs5Unpad($data);
        return $ret;
    }

    //pcks5解密
    public function pkcs5Unpad($text) {
        // 经测试, 服务器没有使用padding
        return $text;

//         $pad = ord($text{strlen($text)-1});
//         if ($pad>strlen($text))
//             return false;
//         if (strspn($text,chr($pad),strlen($text)-$pad)!=$pad)
//             return false;
//         return substr($text,0,-1*$pad);
    }

    //公钥验签
    public function checkSign($signedData, $encryptData, $md5Key){

        $reSign = $this->sign($encryptData, $md5Key);
        if($reSign == $signedData){
            return true;
        }else{
            return false;
        }
    }
}
