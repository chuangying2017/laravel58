<?php


namespace App\Repository\Active;



use App\Model\Active\MaCategory;


class ActiveRepository
{
    public function __construct()
    {
    }

    /**
     * @param $data array
     * @return array
     */
    public function save(array $data): array
    {

    }

    /**
     * @param array $arr
     * @return array
     */
    public function logic(array $arr): array
    {
        $stringAriseNum = '>';

        $category = $arr['category'];

        $ariseNum = substr_count($category,$stringAriseNum);

        $createTime = $arr['createTime'];

        unset($arr['createTime']);

        $arr['created_at'] = date('Y-m-d H:i:s',$createTime);

        if ($ariseNum > 0)
        {
            $arrayRes = explode('>', $category);
        }else{
            $arrayRes = $category;
        }

        if (is_array($arrayRes))
        {
            $lastVisit = null;
            foreach($arrayRes as $k => $v)
            {

                if ($k>=1 && $lastVisit == null)
                {
                    $categoryModel = false;
                }else{
                    $categoryModel = MaCategory::where('title',$v)->first();
                }

                if ($categoryModel)
                {
                    $lastVisit = $categoryModel;
                    continue;
                }else{

                    if ($lastVisit)
                    {
                        $v = $lastVisit->title . $stringAriseNum . $v;
                        $res = MaCategory::create(['title' => $v,'created_at' => $arr['created_at'],'pid' => $lastVisit->id]);
                        $res->path = $lastVisit->path . '-' . $res->id;
                        $res->save();
                        $lastVisit = $res;
                    }else{
                        if (isset($res) && is_object($res))
                        {
                            $res = MaCategory::create(['title' => $v,'created_at' => $arr['created_at'], 'pid' => $res->id, 'path'=> $res->path]);
                            $res->path = $res->path.'-'.$res->id;
                            $res->save();
                        }else{
                            $res = MaCategory::create(['title' => $v,'created_at' => $arr['created_at']]);
                            $res->path = $res->id;
                            $res->save();
                        }

                    }

                }
            }
        }else{
            $categoryModel = MaCategory::where('title',$arrayRes)->first();

            if ($categoryModel)
            {
                return ['status'=>2,'msg'=>'此分类已存在'];
            }

            $res = MaCategory::create([
                'title' => $category,
                'created_at' => $arr['created_at']
            ]);

            $res->path = $res->id;$res->save();

            $res->active()->create($arr);
        }

        if ($res)
        {
            $result = ['status'=>1 ,'msg' => 'successfully'];
        }else{
            $result = ['status'=>2 ,'msg' => 'operationFail'];
        }

        return $result;
    }
}
