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
use function PHPSTORM_META\type;


class ActiveRepository
{
    public function __construct()
    {
    }

    /**
     * @param $data array
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function save(array $data=[]):array
    {
            $data = Storage::disk('local')->get('data.txt');


            $arr = json_decode(base64_decode($data),true);

            $ult = ModelConfig::unique_multidim_array($arr,'category');

            $res = $this->batchInsert($ult);

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
        $category_id = [];//保存分类名与对应的id
        //首先获取数据

        //从数据库获取所有的分类
        $all_category = MaCategory::all()->toArray();

        if (empty($all_category))
        {
            $active_arr = $this->assignArray($array,$category_already,$category_id);
        }else{
            $array_result = $this->categoryAssemble($all_category);
            $category_already = $array_result['category_already'];
            $category_id =  $array_result['category_id'];
            $active_arr = $this->assignArray($array,$category_already,$category_id);
        }

        try{
            MaActive::insert($active_arr);

            $result = ['status'=> 'success', 'msg'=> 'ok'];

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

    //返回拼装好了分类
    public function categoryAssemble($all_category)
    {
        $category_already = [];$category_id=[];
        $collect = collect($all_category);
        foreach ($all_category as $k => $v)
        {
            $path = substr_count($v['path'],'-');
            if ($path>=1)
            {
                $path_id = explode('-',$v['path']);
                $temp_name = '';
                foreach ($path_id as $item)
                {
                    $title = $collect->where('id',$item)->first();

                    if (empty($temp_name))
                    {
                        $temp_name = $title['title'];
                    }else{
                        $temp_name .= '>'. $title['title'];
                    }
                }
                $category_already[] = $temp_name;
                $category_id[$temp_name] = $v['id'];
            }else{
                $category_already[] = $v['title'];
                $category_id[$v['title']] = $v['id'];
            }
        }

        return ['category_already'=>$category_already, 'category_id'=>$category_id];
    }

    //重新组装数组数据
    public function assignArray($array,$category_already,$category_id)
    {
        $active_arr = [];

        foreach ($array as $k => $item) {

            $cid = 0;

            $path = '';

            $category_name = null;//保存上一次的类名

            $use_greater_than = '>';//使用拼接符号

            if (strpos($item['category'],'>') !== false)
            {
                //组合已经有>符号
                $already = explode('>', $item['category']);

                foreach ($already as $cate)
                {

                    if (!is_null($category_name))
                    {
                        $category_name .= $use_greater_than.$cate;
                    }else{
                        $category_name = $cate;
                    }

                    if (!in_array($category_name,$category_already))
                    {
                        $category_already[] = $category_name;
                    }else{
                        $cid = $category_id[$category_name];
                        $path = empty($path) ? $cid : $path.'-'.$cid;
                        continue;
                    }

                    $cate_arr = ['title'=>$cate, ModelConfig::$time => $item[ModelConfig::$time]];
                    $selfClass = MaCategory::create($cate_arr);
                    if ($cid<1)
                    {
                        $path = $selfClass->path = $selfClass->id;
                    }else{
                        $path =  $selfClass->path = $path . '-' .$selfClass->id;
                        $selfClass->pid = $cid;
                    }

                    $cid = $selfClass->id;

                    $category_id[$category_name] = $cid;

                    $selfClass->save();
                }
                $item['cid'] = $cid;
                $item['category_name'] = end($already);
                $active_arr[] = $item;
                $cid =0;
                $path = '';
            }else{

                if (!in_array($item['category'],$category_already))
                {
                    $category_already[] = $item['category'];
                }else{
                    continue;
                }

                $arr = ['title'=>$item['category'],ModelConfig::$time=>$item[ModelConfig::$time]];
                $cateCreate = MaCategory::create($arr);
                $category_id[$item['category']] = $cateCreate->id;
                $item['cid'] = $cateCreate->id;
                $item['category_name'] = $item['category'];
                $active_arr[] = $item;
            }

        }

        return $active_arr;
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
