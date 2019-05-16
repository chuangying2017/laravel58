<?php


namespace App\Repository\Active;


use App\Model\Active\MaActive;
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

        $arr['create_at'] = $createTime;

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
            ])->active()->sync($arr);
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
