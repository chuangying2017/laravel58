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
use Illuminate\Support\Facades\Lang;

class Member
{
    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function save($data):array
    {

        $user = request()->user();

        if ($user->nowCustomerNum >= $user->customerNum)
        {
            return ['status' => 2, 'msg' => Lang::get('defineError.customer_num_too_many')];
        }

        $data['password'] = base64_encode($data['password']);
        $cus = $this->customer->fill($data);
        $bool = $cus->save();
        $cus->number = 'KF000' . random_int(000,999) . $cus -> id;
        $cus->manger_id = $user->id;
        $cus->save();
        $user->nowCustomerNum += 1;
        $user->save();
        return $bool ? ['status'=>1,'msg'=>'操作成功'] : ['status'=>2, 'msg'=>'操作失败001'];
    }

    public function select($manger_id = 0)
    {
        $customer = $this->customer;

        if ($manger_id)
        {
            $customer = $customer->where('manger_id', '=', $manger_id);
        }

        return $customer->paginate(20);
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
       if (is_array($id))
       {
            $find = $this->customer::get($id);

            foreach ($find as $k => $v)
            {
                $v->user()->decrement('nowCustomerNum');
                $v->delete();
            }
            $res = true;
       }else{
           $find = $this->customer::find($id);

           $find->user()->decrement('nowCustomerNum');

           $res = $find->delete();
       }

        return ModelConfig::status($res);
    }

    public function chat_get($condition = null)
    {
        $query = SessionRecord::query();

        $query = call_select($query,$condition);

        return $query->whereHas('customer.user', function($query){
            $query->where('id',request()->user()->id);
        })->with('customer:id,username,number')->orderBy('created_at','desc')->paginate(20);
    }

    public function array_each($data)
    {
        foreach ($data as $k => &$v)
        {
                $customer = $v['customer'];
                $v['customer_number'] = $customer['number'];
                $v['customer_username'] = $customer['username'];

                if ($v['type'] == 'msg')
                {
                    $v['content'] = substr($v['content'],0,100);
                    $v['type'] = '信息';
                }else{
                    $v['type'] = '图片';
                    $v['content'] = substr($v['content'],0,50);
                }

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
