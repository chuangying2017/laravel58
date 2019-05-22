<?php


namespace App\Repository\Active;



use App\Model\Active\MaActive;
use App\Model\Active\MaCategory;
use App\Model\ModelConfig;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use mysql_xdevapi\Exception;


class ActiveRepository
{
    public function __construct()
    {
    }

    /**
     * @param $data array
     * @return array
     */
    public function save(array $data=[])
    {

           $res = ['status'=>2 ,'msg' => 'successfully'];
            $data = Storage::disk('local')->get('data.txt');
            $arr = json_decode(base64_decode($data),true);
 /*           foreach ($arr as $value)
           {
              // $res = $this->batchInsert($value);
           }
           $string = $data['data'];*/
           $res = $this->batchInsert($arr);

           return $res;
    }

    /**
     * @param array $arr
     * @return array
     */
    public function logic(array $arr): array
    {
        $res = false;

        $stringAriseNum = '>';

        $category = $arr['category'];

        $ariseNum = substr_count($category,$stringAriseNum);

        $createTime = $arr[ModelConfig::$time];

        $arr['createTime'] = date('Y-m-d H:i:s',$createTime);

        if ($ariseNum > 0)
        {
            $arrayRes = explode('>', $category);
        }else{
            $arrayRes = $category;
        }

        if (is_array($arrayRes))
        {
            $count = count($arrayRes);
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
                    if ($count == $k + 1) return ['status'=>2 ,'msg' => 'operationFail'];
                    continue;
                }else{

                    if ($lastVisit)
                    {
                        $res = MaCategory::create(['title' => $v, ModelConfig::$time => $arr[ModelConfig::$time],'pid' => $lastVisit->id]);
                        $res->path = $lastVisit->path . '-' . $res->id;
                        $res->save();
                        $lastVisit = $res;
                    }else{
                        if (isset($res) && is_object($res))
                        {
                            $res = MaCategory::create(['title' => $v, ModelConfig::$time => $arr[ModelConfig::$time], 'pid' => $res->id, 'path'=> $res->path]);
                            $res->path = $res->path.'-'.$res->id;
                            $res->save();
                        }else{
                            $res = MaCategory::create(['title' => $v, ModelConfig::$time => $arr[ModelConfig::$time]]);
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
                'created_at' => $arr[ModelConfig::$time]
            ]);

            $res->path = $res->id;$res->save();

        }

        try{
            $res->active()->create($arr);

            $result = ['status'=>1 ,'msg' => 'successfully'];
        }catch (\Exception $exception)
        {
            $result = ['status'=>2, 'msg' => $exception->getMessage()];

            Log::error($exception->getMessage());
        }

        return $result;
    }

    /**
     * 批量插入数据 逻辑操作
     * @param array $array
     * @return array
     */
    public function batchInsert(array $array): array
    {
        $active_arr = [];//拼装好所有文章的数据放这里
        $category_data = [];//拼装所有的分类 包括分层级关系
        $category_already = [];//保存已经存在的分类
        //首先获取数据

        //从数据库获取所有的分类
        $all_category = MaCategory::all()->toArray();
        $dare = date('H:i:s');
        if (empty($all_category))
        {
            $array = ModelConfig::unique_multidim_array($array,'category');

            foreach ($array as $k => $item) {

               if (strpos($item['category'],'>') !== false)
               {
                    //组合已经有>符号
                   $already = explode('>', $item['category']);

                   $cid = 0;

                   foreach ($already as $cate)
                   {
                        $cate_arr = ['title'=>$cate,ModelConfig::$time => $item[ModelConfig::$time]];
                        $selfClass = MaCategory::create($cate_arr);
                        if (!in_array($cate,$category_already))
                        {
                            $category_already[] = $cate;
                        }
                        if ($cid<1)
                        {
                            $selfClass->path = $selfClass->id;
                        }else{
                            $selfClass->path = $cid . '-' .$selfClass->id;
                            $selfClass->pid = $cid;
                        }

                        $cid = $selfClass->id;

                        $selfClass->save();
                   }
                   $item['cid'] = $cid;
                   $active_arr[] = $item;

               }else{

               }

            }

        }else{

        }
        $active_arr[] = ['start_date' => $dare, 'end_date'=> date('H:i:s')];
        dd($active_arr);
        try{
            MaActive::insert($active_arr);

            $result = ['status'=> 'success'];

        }catch (Exception $exception)
        {
            $result = ['status'=>'fail', 'msg' => $exception->getMessage()];
        }

        return $result;
    }


    public function select()
    {
        $fetchCurrent = MaCategory::with('active')->whereDate(ModelConfig::$time,'<=',Carbon::now()->toDateTimeString())->get();

        return $fetchCurrent;
    }

    public function array_only(array $arr)
    {
        return Arr::only($arr, [
            'title',
            ModelConfig::$time,
            'category',
            'content',
            'description'
        ]);
    }
}
