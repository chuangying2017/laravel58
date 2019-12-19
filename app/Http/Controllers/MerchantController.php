<?php

namespace App\Http\Controllers;

use App\Repository\Config\BusinessChannel;
use App\Repository\Config\CommonPayConfig;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MerchantController extends Controller
{

    protected $path = 'interface/memberReg';

    protected $url;

    protected $businessChannel;


    public function __construct(BusinessChannel $businessChannel)
    {
        $this->url = CommonPayConfig::$url . $this->path;

        $this->businessChannel = $businessChannel;
    }

    /**
     * 注册商户号
     */
    public function register()
    {
        $arr = [
            "verCode" => '1001',
            "merCode" => date('YmdHis') . strtoupper(substr(uniqid(),6,2)),
            "merName" => '橙汁星',
            "realName" => '张志伟',
            "merAddress" => '广东省广州市白云区齐富路1-10号',
            "idCard" => '441381199212242916',
            "mobile" => '13059551109',
            "accountName" => '张志伟',
            "accountNo" => '6212262008011769990',
            "reservedMobile" => '13059551109',
            "subBankCode" => '105581021041',
            "settleAccType" => '1'
        ];

        $sign = $this->businessChannel->sign($arr, CommonPayConfig::$md5);

        $encryptData = $this->businessChannel->encrypt($arr,'base64', CommonPayConfig::$aes);

        $reqData = array(
            'orgCode'       =>  CommonPayConfig::$orgCode,
            'encryptData'   =>  $encryptData,
            'signData'      =>  $sign,
        );

        Log::info('保存注册商户信息',$arr);

        $response = $this->businessChannel->curl_post($this->url, $reqData);

        $result = json_decode($response, true);

        $resData = $this->businessChannel->decrypt($result['encryptData'], CommonPayConfig::$aes);

        $resDataJson = json_decode($resData,true);

        Log::info($resDataJson);
        //验签
        $this->businessChannel->checkSign($result['signData'],$resDataJson, CommonPayConfig::$md5);

        dump($resDataJson);
    }
}
