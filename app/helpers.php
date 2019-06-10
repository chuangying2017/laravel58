<?php
/**
 * Created by PhpStorm.
 * User: 张伟
 * Date: 2019/6/7
 * Time: 2:04
 */
function getSystemInfo() {
    $systemInfo = array();

    // 系统
    $systemInfo['os'] = PHP_OS;

    // PHP版本
    $systemInfo['phpversion'] = PHP_VERSION;

    // Apache版本
    // $systemInfo['apacheversion'] = apache_get_version();
    // ZEND版本
    $systemInfo['zendversion'] = zend_version();

    // GD相关
    if (function_exists('gd_info')) {
        $gdInfo = gd_info();
        $systemInfo['gdsupport'] = true;
        $systemInfo['gdversion'] = $gdInfo['GD Version'];
    } else {
        $systemInfo['gdsupport'] = false;
        $systemInfo['gdversion'] = '';
    }
    //现在的时间
    $systemInfo['nowtime'] = date('Y-m-d H:i:s', time());
    //客户端ip
    $systemInfo['remote_addr'] = getenv('REMOTE_ADDR');
    //服务器端
    $systemInfo['server_name'] = gethostbyname($_SERVER["SERVER_NAME"]);
    // 安全模式
    $systemInfo['safemode'] = ini_get('safe_mode');

    // 注册全局变量
    $systemInfo['registerglobals'] = ini_get('register_globals');

    // 开启魔术引用
    $systemInfo['magicquotes'] = (function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc());

    // 最大上传文件大小
    $systemInfo['maxuploadfile'] = ini_get('upload_max_filesize');

    // 脚本运行占用最大内存
    $systemInfo['memorylimit'] = get_cfg_var("memory_limit") ? get_cfg_var("memory_limit") : '-';

    return $systemInfo;
}

if (!function_exists('call_select'))
{
    function call_select(\Illuminate\Database\Eloquent\Builder $query,$data)
    {

        $searchDate = 'created_at';
        if (isset($data['search_starttime']) && isset($data['search_endtime']))
        {
            $query->whereBetween($searchDate,[$data['search_starttime'] .' 00:00:00',$data['search_endtime']. ' 23:59:59']);
        }elseif (isset($data['search_starttime']))
        {
            $query->whereDate($searchDate,'>=',$data['search_starttime'].' 00:00:00');
        }elseif (isset($data['search_endtime']))
        {
            $query->whereDate($searchDate,'<=',$data['search_endtime']. ' 23:59:59');
        }

        if (isset($data['search_username']))
        {
            $query->where('content','like',"%{$data['search_username']}%")->OrWhere('client_number','like',$data['search_username']);
        }

        return $query;
    }
}