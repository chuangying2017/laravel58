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

if (!function_exists('status')) {
    function status($data, $msg = '操作成功', $err = '操作失败'): array
    {
        if ($data) {
            $res = ['status' => 1, 'msg' => $msg];
        } else {
            $res = ['status' => 2, 'msg' => $err];
        }

        return $res;
    }
}
if (!function_exists('get_host'))
{
    function get_host():string
    {
        $scheme = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
        $url = $scheme.$_SERVER['HTTP_HOST'];
        return $url;
    }
}

if (!function_exists('character'))
{
    /**
     * 生成随机字符串 可用于生成随机密码等
     * @param int    $length   生成长度
     * @param string $alphabet 自定义生成字符集
     * @author : evalor <master@evalor.cn>
     * @return bool|string
     */
    function character($length = 6, $alphabet = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789')
    {
        /*
         * mt_srand() is to fix:
            mt_rand(0,100);
            if(pcntl_fork()){
                var_dump(mt_rand(0,100));
            }else{
                var_dump(mt_rand(0,100));
            }
         */
        mt_srand();
        // 重复字母表以防止生成长度溢出字母表长度
        if ($length >= strlen($alphabet)) {
            $rate = intval($length / strlen($alphabet)) + 1;
            $alphabet = str_repeat($alphabet, $rate);
        }

        // 打乱顺序返回
        return substr(str_shuffle($alphabet), 0, $length);
    }
}


if (!function_exists('makeGravatar'))
{
    /**
     * 生成一个Gravatar头像
     * @param string $email
     * @param int $size
     * @return string
     */
    function makeGravatar(string $email, int $size = 120)
{
    $hash = md5($email);
    return "https://www.gravatar.com/avatar/{$hash}?s={$size}&d=identicon";
}
}

