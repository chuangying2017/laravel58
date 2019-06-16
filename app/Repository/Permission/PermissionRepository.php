<?php


namespace App\Repository\Permission;


use App\Model\Auth\PermissionModel;
use App\Repository\InterfaceRepository\CurdInterface;
use Illuminate\Support\Arr;

class PermissionRepository implements CurdInterface
{

    public function create(array $array): array
    {
        $permission = PermissionModel::query();
        if ($array['pid'] <=0 )
        {
            $result = $permission->create($array);

            $result->path = $result->id;

        }else{
            $find = $permission->find($array['pid']);

            if (!$find)
            {
                return status(false);
            }

            $result = $permission->create($array);

            $result->path = $find['path'] . '-' . $result->id;

        }
            $result = $result->save();

        return status($result);
    }

    public function delete($id): bool
    {

       if (substr_count(',',$id) >=1 )
       {
            $id = explode(',',$id);
       }

        $result = PermissionModel::destroy($id);

       return $result ? true : false ;
    }

    public function updateLogic($data)
    {
        $updateArr = Arr::only($data, ['style','action','pid','path','name']);

        return $this->update($data['id'],$updateArr);
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     */
    public function update($id, $data): bool
    {
        $findPermission = PermissionModel::find($id);

        $findPermission->fill($data);

        return $findPermission->save();
    }

    public function select():array
    {
       //查询所有的分类信息
        $all = PermissionModel::all();

        $arr = [];//排序好的数组

        $categoryId = []; //存放大类对应的数据

        foreach ($all as $k => $v)
        {
            if ($v['pid'] <= 0)
            {
                $categoryId[$v['id']] = [];
                $categoryId[$v['id']][] = ['name' => $v['name'],'id'=>$v['id'],'pid'=>$v['pid']];
            }else{

                $count = substr_count($v['path'],'-');//统计--的数量

                $name = $v['name'];//默认为大类

                if ($count > 1)
                {
                    $str = '';
                    for ($i=0; $i < $count; $i++)
                    {
                        $str .= '☆';
                    }

                    $name = $str .$name;
                }else{
                    $name = '☆'.$v['name'];
                }
                $categoryId[$v['pid']][] = ['name' => $name,'id'=>$v['id'],'pid'=>$v['pid']];

            }
        }

        if (!empty($categoryId))
        {
            ksort($categoryId);

            foreach ($categoryId as $j => $h)
            {
                foreach ($h as $v)
                {
                    $arr[] = $v;
                }
            }
        }

        return $arr;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return PermissionModel::find($id);
    }

    public function get(array $array = [])
    {
            $permission = PermissionModel::query();

            return $permission->get();
    }
}
