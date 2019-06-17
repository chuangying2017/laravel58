<?php


namespace App\Repository\Role;


use App\Model\Auth\RoleModel;
use App\Repository\InterfaceRepository\CurdInterface;
use Illuminate\Support\Facades\DB;

class RoleRepository implements CurdInterface
{

    public function create(array $array): array
    {
       //创建角色
        $arr = collect($array)->except('roleName','description');

        $res =  $arr->values()->toArray();
        $find = RoleModel::query()->where('name',$array['roleName'])->first();
        if (!empty($find))
        {
            return ['status' => 2,'msg' => '角色名不能重复!'];
        }
        try{
            DB::beginTransaction();

            $roleModel= RoleModel::create(['name' => $array['roleName'], 'description' => $array['description']]);

            if ($roleModel)
            {
                $roleModel->permission()->attach($res);
                DB::commit();
                $result = true;
            }else{
                throw new \Exception('添加出错001');
            }
        }catch (\Exception $exception)
        {
                DB::rollBack();
                $result = false;
        }
            return status($result);
    }

    public function delete($id): bool
    {
        if (strpos($id,',') !== false)
        {
            $id = explode(',',$id);

            $find = RoleModel::query()->whereIn('id',$id)->get();

            foreach ($find as $k => $v)
            {
                $v->permission()->detach();

                $v->user()->detach();

                $v->delete();
            }

        }else{
            $find = RoleModel::find($id);
            $find->permission()->detach();
            $find->user()->detach();
            $find->delete();
        }

        return true;
    }

    public function update($id, $data): bool
    {
        // TODO: Implement update() method.
    }

    public function select($with = true)
    {
       //关联用户列表 权限列表

        $query = RoleModel::query();

        if ($with)
        {
            $query->with(['permission','user']);
        }

        return $query->get();
    }

    public function find(int $id)
    {
        // TODO: Implement find() method.
    }
}
