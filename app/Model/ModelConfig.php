<?php


namespace App\Model;


trait ModelConfig
{
    public static $time = 'createTime';


    //二维数组去除重复指定字段的数值

    /**
     * @param array $array
     * @param string $key
     * @return array
     */
    public static function unique_multidim_array(array $array,string $key): array
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    public static function status($data, $msg = '操作成功',$err = '操作失败'):array
    {
        if ($data)
        {
            $res = ['status' => 1, 'msg' => $msg];
        }else{
            $res = ['status' => 2, 'msg' => $err];
        }

        return $res;
    }
}
