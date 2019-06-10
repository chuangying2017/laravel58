<?php
/**
 * Created by PhpStorm.
 * User: 张伟
 * Date: 2019/6/6
 * Time: 13:32
 */

namespace App\Repository\Chat;


use App\Model\Customer;
use App\Model\ModelConfig;
use App\Model\SessionRecord;
use Illuminate\Support\Arr;

class Member
{
    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function save($data):array
    {

        $data['password'] = base64_encode($data['password']);
        $cus = $this->customer->fill($data);
        $bool = $cus->save();
        $cus->number = 'KF000' . random_int(000,999) . $cus -> id;
        $cus->save();
        return $bool ? ['status'=>1,'msg'=>'操作成功'] : ['status'=>2, 'msg'=>'操作失败001'];
    }

    public function select()
    {
        return $this->customer->paginate(20);
    }

    public function edit($id,$data)
    {
        $cus = $this->customer::find($id);

        if (!$cus)
        {
            return ['status' => 2, 'msg' => '用户不存在'];
        }

        if (isset($data['newpassword']))
        {
            $data = ['password' => base64_encode($data['newpassword'])];
        }

        $cus->fill($data);

       return ModelConfig::status($cus->save());

    }

    public function delete($id):array
    {
       /* if (strpos(',',$id) !== false)
        {
            $id = explode(',',$id);
        }*/
        return ModelConfig::status($this->customer::destroy($id));
    }

    public function chat_get($condition = null)
    {
        $query = SessionRecord::query();

        $query = call_select($query,$condition);

        return $query->has('customer')->with('customer:id,username,number')->paginate(20);
    }

    public function array_each($data)
    {
        foreach ($data as $k => &$v)
        {
                $customer = $v['customer'];
                $v['customer_number'] = $customer['number'];
                $v['customer_username'] = $customer['username'];
                $v['type'] = $v['type'] == 'msg' ? '信息' : '图片';
        }

        return $data;
    }

    public function memberTest()
    {
        $res = $this->select();

        $arr = [];

        $date = date('Y-m-d H:i:s');

        foreach ($res as $v)
        {
            for ($i=0;$i<100;$i++)
            {
                $arr[] = [
                    'content' => '不违背该我外包工',
                    'customer_id' => $v['id'],
                    'client_number' => uniqid('KF'),
                    'created_at' => $date,
                    'updated_at' => $date
                ];
            }
        }

       return SessionRecord::query()->insert($arr);
    }
}