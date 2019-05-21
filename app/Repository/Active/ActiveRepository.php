<?php


namespace App\Repository\Active;



use App\Model\Active\MaActive;
use App\Model\Active\MaCategory;
use App\Model\ModelConfig;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


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
           $res = ['status'=>2 ,'msg' => 'fail'];
           $data['data'] = Storage::disk('local')->get('data.txt');
           $arr = json_decode(base64_decode($data['data']),true);
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
        //首先获取数据

        //从数据库获取所有的分类
        $all_category = MaCategory::all()->toArray();

        if (empty($all_category))
        {

        }


    }


    public function select()
    {
        $fetchCurrent = MaCategory::with('active')->whereDate(ModelConfig::$time,'<=',Carbon::now()->toDateTimeString())->get();

        return $fetchCurrent;
    }
}
