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

        }else{
            $categoryModel = MaCategory::where('title',$arrayRes)->first();

            if ($categoryModel)
            {
                return ['status'=>2,'msg'=>'此分类已存在'];
            }

            $res = MaCategory::create([
                'title' => $category
            ]);
            $arr['category_id'] = $res->id;
            $res = $res ->active()->create($arr);
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
