<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Config;
use App\Models\Integral;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * 注册时实现分销
     * TODO： 分销还有其他实现方式，例如模型监听或者事务等，均可以实现
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Register(UserRequest $request)
    {
        $param = $request->only(['name','email','password','code']);
        $param['password'] = Hash::make($param['password']);

        // 如果没有推荐码，直接入库
        if(empty($param['code'])){
            $param['code'] = $this->GetRandStr(10);
            User::create($param);
            return response()->json(['code' => 200, 'msg' => "注册成功"], 200)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        }
        // 如果有推荐码
        // 一级推销
        $userdata = User::where('code',$param['code'])->first();
        if(empty($userdata)){
            return response()->json(['errcode' => 201, 'errmsg' => "错误的推荐码"], 201)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        }

        $param['code'] = $this->GetRandStr(10);
        $param['pid'] = $userdata->id;
        // 注册用户入库
        User::create($param);

        $arr = ['one_id' => $userdata->id];
        // 二级推销
        if($userdata->pid != 0 ){
            $arr['two_id'] = $userdata->pid;
        }

        // 配置表
        $config_data = Config::where('uid',$userdata->id)->first();
        // 配置表中有该用户的配置
        if(!empty($config_data)){
            $date = date('Y-m-d H:i:s');
            // 对应id和积分
            $integral_arr[] = [ 'uid' =>$arr['one_id'], 'integral' => $config_data->one_integral, 'created_at'=> $date, 'updated_at'=> $date ];
            if(isset($arr['two_id'])){
                $integral_arr[] = [ 'uid' =>$arr['two_id'] , 'integral' => $config_data->two_integral, 'created_at'=> $date, 'updated_at'=> $date];
            }

            Integral::insert($integral_arr);
        }

        return response()->json(['code' => 200, 'msg' => "注册成功"], 200)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    public function getUsers(Request $request)
    {
        $userdata = User::all();
        $id = $request->id ? $request->id : 0;
        if($id != 0){
            $result = $userdata->where('id',$id)->all();
            if(empty($result)){
                return response()->json(['code' => 200, 'msg' => "无效的ID"], 200)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
            }
        }
        $array = $this->getTree($userdata->toArray(),$id);
        echo '第一种展示方式:' .'<br />';
        foreach ($array as $value){
            echo str_repeat('--', $value['level']), $value['name'].'<br />';
        }
        echo  '<hr />';
        echo '第二种展示方式:';
        dump($this->getChild($userdata->toArray(),$id));
        return;
    }

    /**
     * 限极用户
     * @param $data
     * @param int $id
     * @return array
     */
    public function getChild($data, $id = 0)
    {
        $child = [];
        foreach ($data as $key => $datum) {
            if ($datum['pid'] == $id) {
                $child[$datum['id']] = $datum;
                unset($data[$key]);
                $child[$datum['id']]['child'] = $this->getChild($data, $datum['id']);
            }
        }
        return $child;
    }

    /**
     * 限极用户
     * @param $array
     * @param int $pid
     * @param int $level
     * @return array
     */
    public function getTree($array, $pid =0, $level = 0){
        static $list = [];
        foreach ($array as $key => $value){
            if ($value['pid'] == $pid){
                $value['level'] = $level;
                $list[] = $value;
                unset($array[$key]);
                $this->getTree($array, $value['id'], $level+1);

            }
        }
        return $list;
    }



    // 生成推荐码
    public function GetRandStr($length)
    {
        $randstr = Str::random(10);
        $data = User::where('code',$randstr)->first();
        if(!empty($data)){
            $this->GetRandStr($length);
        }
        return $randstr;
    }
}
