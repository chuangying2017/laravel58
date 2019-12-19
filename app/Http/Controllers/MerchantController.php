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

    protected $businessChannel;


    public function __construct(BusinessChannel $businessChannel)
    {

        $this->businessChannel = $businessChannel;
    }

    /**
     * 注册商户号
     */
    public function register()
    {
        $url = CommonPayConfig::$url . $this->path;

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

        $res = $this->businessChannel->verifyData($url, $arr);

        dump($res);
    }

    /**
     * 4.1.2商户业务开通接口
     */
    public function businessLiberal()
    {
        $path = 'interface/memberBus';

        $url = CommonPayConfig::$url . $path;

        $arr = [
            "drawFee" => 0.5,
            "tradeRate" => 0.006,
            "verCode" => 1001,
            "chMerCode" => 'C030019121938004',
            "busCode" => 2001
        ];

        $res = $this->businessChannel->verifyData($url, $arr);
        Log::info($res);
        dump($res);
    }
}
