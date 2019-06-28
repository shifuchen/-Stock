<?php


namespace app\index\controller;
use think\console\command\make\Model;
use think\Log;
use think\Request;
use app\index\util\DateUTil;

use think\Controller;

class Product extends Common
{
    protected  $productModel=null;
    public  function _initialize()
    {
        $this->productModel=new \app\index\model\Product();
    }

    public function  index(){
        return $this->fetch("productmanger");
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function  productlist(Request $request){
        $serachdata=$request->param();
       $product=new \app\index\model\Product();
        $productdata['list']=$product->paginate(12,true,['page'=>$serachdata['params']['page']]);
        return json($productdata);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function  getproduct($id){
        $productDate=$this->productModel->get(['id'=>$id]);
        return $productDate;
    }

    /**
     * @param Request $request
     * @content 新增产品
     */
    public function  productadd(Request $request){
        $dataUtil=new DateUTil();
        $data=$request->post()['params'];
        $data['create_time']=$dataUtil->getMillisecond()/1000;
        $data['update_time']=$dataUtil->getMillisecond()/1000;
        $result=$this->productModel->save($data);
        return $result? $this->success("新增成功"):$this->error("提交失败");
    }

    /**
     * @param $id
     * @content 删除商品
     */
    public function  delproduct($id){
        $result=$this->productModel->destroy($id);
        return $result?$this->success("删除成功!"):$this->error("删除失败!");
    }

    public function editproduct(Request $request){
        $data=$request->post()['params'];
        $dataUtil=new DateUTil();
        $id=$data['id'];
        $data['update_time']=$dataUtil->getMillisecond()/1000;
        unset($data['id']);
        $result=$this->productModel->save($data,['id'=>$id]);
        return $result? $this->success("更新成功"):$this->error("更新失败");
    }

}