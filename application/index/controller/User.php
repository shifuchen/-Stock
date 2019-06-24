<?php
namespace app\index\controller;
use think\Controller;
use think\Log;
use think\Request;
use app\index\util\DateUTil;
class User extends  Common
{
    /**
     * @content 界面跳转
     * @return mixed
     */
    public  function  userManger(){
        return $this->fetch('usermanger');
    }

    /**
     * @param int $page
     * @return \think\response\Json
     * @throws \think\exception\DbException
     * @content 列表查询
     */
    public function  userlist( Request $request){
        $serachdata=$request->param();
        Log::error($serachdata['params']['page']);
        $userlist=new \app\index\model\User();
        $userdata['list']=$userlist->paginate(12,true,['page'=>$serachdata['params']['page']]);
        return json($userdata);
    }

    /**
     * @param Request $request
     * @content 新增用户数据
     */
    public function  useradd(Request $request){
        $dataUtil=new DateUTil();
        $user =new \app\index\model\User();
        $data=$request->post()['params'];
        $data['status']='正常';
        $data['createtime']=$dataUtil->getMillisecond()/1000;
        $data['updatetime']=$dataUtil->getMillisecond()/1000;
        $data['password']=md5("12345678");
        $result=$user->save($data);
        Log::error($result);
         return $result ? $this->success('添加成功'): $this->error("添加失败");
    }

    /**
     * @param $id
     * @content 删除用户数据
     */
    public function  deluser($id){
        $user=new \app\index\model\User();
        $result=$user::destroy($id);
        return $result ?$this->success('删除成功'):$this->error('删除失败');
    }

    /**
     * @param $id
     * @return \app\index\model\User|null
     * @throws \think\exception\DbException
     * @content 查询用户信息
     */
    public function getuser($id){
        $user=new \app\index\model\User();
        $result=$user::get(['id'=>$id]);
        return $result;
    }

    /**
     * @param $id
     * @param Request $request
     * @throws \think\exception\DbException
     * @content 更新用户信息
     */
    public function edituser(Request $request){
        $user=new \app\index\model\User();
        $data=$request->post()['params'];
        $dataUtil=new DateUTil();
        $id=$data['id'];
        $data['updatetime']=$dataUtil->getMillisecond()/1000;
        unset($data['id']);
        $result=$user->save($data,['id'=>$id]);
        return $result? $this->success("更新成功"):$this->error("更新失败");
    }
}