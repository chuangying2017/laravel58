<?php

namespace App\Http\Controllers;


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

    /**
     * 测试支付接口
     */
    public function pay_test()
    {
        $client = new Client();

        $post = $client->request('POST','http://192.168.2.127:8001/admin/post_test/', [
            'form_params' => [
                'verCode' => '1001', //接口版本号
                'chMerCode' => '123', //通道商户编号
                'orderCode' => uniqid('fn_'), //交易订单号
                'orderTime' => date('YmdHis'), //订单时间
                'orderAmount' => 1.00, //订单金额
                'settleType'=> 0, //结算方式
                'busCode'=>2001, //业务编码
                'realName'=>'张伟', //真实姓名
                'idCard'=>'441381199212242916', //身份证号
                'accNo'=>'6212262008011769990', //支付卡号
                'mobile'=>'13059551109', //手机号
                'city'=>'guangzhou', //城市
                'mcc', //行业
                'ProductName', //商品名称
                'ProductInfo', //商品信息
                'frontUrl', //前台通知地址
                'callBackUrl', //后台回调地址
                'deviceSN' => '', //终端设备标识
            ],
            'headers' => [
                "User-Agent" => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36'
            ]
        ]);

        dd($post);
    }
}
