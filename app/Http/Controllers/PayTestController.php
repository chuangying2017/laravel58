<?php

namespace App\Http\Controllers;


use App\Repository\Config\BusinessChannel;
use App\Repository\Config\CommonPayConfig;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PayTestController extends Controller
{

    /**
     * #测试信息
     * 测试地址：https://test_tran.verajft.com/fusionPosp/
     * MD5密钥: 1ADFHQPBYTHDM8HC
     * AES密钥: 5VN86HV2UCDH3AK5
     * 机构号: YMD001
     * 2001
     */

    protected $commonConfig;

    public function __construct(BusinessChannel $businessChannel)
    {
        $this->commonConfig = $businessChannel;
    }

    /**
     * 测试支付接口
     */
    public function pay_test()
    {
       $arr = [
           'verCode' => '1001', //接口版本号
           'chMerCode' => 'C030019121938004', //通道商户编号
           'orderCode' => uniqid('fn_'), //交易订单号
           'orderTime' => date('YmdHis'), //订单时间
           'orderAmount' => 1.00, //订单金额
           'settleType'=> '1', //结算方式
           'busCode'=>2001, //业务编码
           'realName'=>'张志伟', //真实姓名
           'idCard'=>'441381199212242916', //身份证号
           'accNo'=>'6212262008011769990', //支付卡号
           'mobile'=>'13059551109', //手机号
       ];

       $url = CommonPayConfig::$url . 'interface/quickPay';

       $res = $this->commonConfig->verifyData($url, $arr);

       dump($res);
    }
}
