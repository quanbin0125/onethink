<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/4/26
 * Time: 12:32
 */

namespace Admin\Controller;


use Admin\Model\RepairModel;
use Think\Page;

class RepairController extends AdminController
{
    //首页
    public function index(){
        $list = M('Repair')->order('id asc')->page(I('p',0),5)->select();
        $repair=new RepairModel();
        $count=$repair->count();// 查询满足要求的总记录数
        $page=new Page($count,5);
        $show=$page->show();
        int_to_string($list,array('status'=>array(1=>'已维修',0=>'未维修')));
        $this->assign('list', $list);
        $this->assign('page',$show);// 赋值分页输出
        $this->meta_title = '报修管理';
        $this->display();
    }

    //添加报修
    public function add(){
        if(IS_POST){
            $Repair = D('Repair');
            $data = $Repair->create();
            if($data){
                $id = $Repair->add();
                if($id){
                    $this->success('新增成功', U('index'));
                    //记录行为
                    action_log('update_repair', 'repair', $id, UID);
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($Repair->getError());
            }
        } else {
            $pid = i('get.pid', 0);
            //获取父导航
            if(!empty($pid)){
                $parent = M('Repair')->where(array('id'=>$pid))->field('name')->find();
                $this->assign('parent', $parent);
            }

            $this->assign('pid', $pid);
            $this->assign('info',null);
            $this->meta_title = '新增报修';
            $this->display('add');
        }
    }

    //编辑报修
    public function edit($id = 0){
        if(IS_POST){
            $Repair = D('Repair');
            $data = $Repair->create();
            if($data){
                if($Repair->save()){
                    //记录行为
                    action_log('update_repair', 'repair', $data['id'], UID);
                    $this->success('编辑成功', U('index'));
                } else {
                    $this->error('编辑失败');
                }

            } else {
                $this->error($Repair->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = M('Repair')->find($id);

            $this->assign('info', $info);
            $this->meta_title = '编辑报修';
            $this->display('edit');
        }
    }

    //删除报修
    public function del(){
        $id = array_unique((array)I('id',0));

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id) );
        if(M('Repair')->where($map)->delete()){
            //记录行为
            action_log('update_repair', 'repair', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }


}