<?php


namespace app\index\controller;


use app\index\util\DateUTil;
use think\Controller;
use think\Log;
use think\Request;

class Custom extends Controller
{
    public function customManger(){
        return $this->fetch("custommangger");
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\exception\DbException
     * @content 列表
     */
    public function  customlist(Request $request){
        $page=$request->param();
        $custom=new \app\index\model\Custom();
        $customData['list']=$custom->paginate(12,true,['page'=>$page['params']['page']]);
        return json($customData);
    }

    /**
     * @param Request $request
     * @content 添加客户
     */
    public function customadd(Request $request){
        $dataUtil=new DateUTil();
        $custom=new \app\index\model\Custom();
        $data=$request->post()['params'];
        $data['createtime']=$dataUtil->getMillisecond()/1000;
        $data['updatetime']=$dataUtil->getMillisecond()/1000;
        $result=$custom->save($data);
        Log::error($result);
        return $result ? $this->success('添加成功'): $this->error("添加失败");
    }

    /**
     * @param $id
     * @content 用户删除
     */
    public function delcustom($id){
        $custom=new \app\index\model\Custom();
        $result=$custom::destroy($id);
        return $result? $this->success("删除成功"):$this->error("删除失败");

    }

    /**
     * @param $id
     * @return \app\index\model\Custom|null
     * @throws \think\exception\DbException
     * @content 获取客户信息
     */
    public function  getcustom($id){
        $custom=new \app\index\model\Custom();
        $result=$custom::get(['id'=>$id]);
        return $result;
    }

    public function  editcustom(Request $request){
        $custom=new \app\index\model\Custom();
        $data=$request->post()['params'];
        $dataUtil=new DateUTil();
        $id=$data['id'];
        $data['updatetime']=$dataUtil->getMillisecond()/1000;
        unset($data['id']);
        $result=$custom->save($data,['id'=>$id]);
        return $result? $this->success("更新成功"):$this->error("更新失败");
    }

}