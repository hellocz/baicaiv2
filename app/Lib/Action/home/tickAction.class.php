﻿<?php
class tickAction extends frontendAction {

	public function index() {
		//国内or国外
		$ismy = $this->_get('ismy','trim');
		if(!in_array($ismy, array('0', '1'))){
			$ismy = '';
		}
		//活动or领券
		$t = $this->_get('t','trim');
		if(!in_array($t, array('1', '2'))){
			$t = '';
		}
		//最新or最热
		$sortby = $this->_get('sortby', 'trim');
		if($sortby == 'hottest'){
			$order_by = "yl desc";
		}else{
			$order_by = "start_time desc";
		}

		$orig = $this->_get('orig', 'intval');
		if($orig){
			$orig_info = D("item_orig")->get_info($orig);
			!$orig_info && $orig = '';
		}

		$mod_orig=M("item_orig");
		$mod = M('tick');
		$db_pre = C('DB_PREFIX');

		// //获取所有有优惠券的购物平台
		$tick_orig_ids = D('tick')->get_orig_ids();
		$activity_orig_ids = D('activity')->get_orig_ids();
		$orig_list = D("item_orig")->get_orig_by_ids(array_merge($tick_orig_ids, $activity_orig_ids));
		$this->assign('orig_list',$orig_list);		

		//获取所有的优惠券
		$subwhere = '';
		if($orig){
			$subwhere = "orig_id={$orig} ";
		}
		$field_tick = "1 as t,id,name,orig_id,start_time,end_time,intro,status,yl,sy,je,dhjf,ljdz,xl";		
		$field_activity = "2 as t,id,name,orig_id,start_time,end_time,intro,status,'' AS yl,'' AS sy,je,'' AS dhjf,ljdz,'' AS xl";

		$subQuery_tick = D('tick')->tick_sql('valid', $subwhere, $field_tick);
		$subQuery_activity = D('activity')->activity_sql('valid', $subwhere, $field_activity);

		if($t == 1){
			//只看优惠券
			$subQuery = $subQuery_tick;
		}else if($t == 2){
			//只看活动
			$subQuery = $subQuery_activity;
		}else{
			//全部
			$subQuery = "({$subQuery_tick} union all {$subQuery_activity})";
		}

		//总数
		if($ismy != ''){
			$where = "o.ismy={$ismy} ";
			$count = $mod->table($subQuery.' t')->join("join ".$db_pre."item_orig o on t.orig_id=o.id")->where($where)->count();
		}else{
			$count = $mod->table($subQuery.' t')->count();
		}
		
		$pagesize=5;
		$pager = $this->_pager($count,$pagesize);

		if($ismy != ''){
			$list = $mod->table($subQuery.' t')->join("join ".$db_pre."item_orig o on t.orig_id=o.id")->where($where)->order($order_by)->limit($pager->firstRow.",".$pager->listRows)->select();
		}else{
			$list = $mod->table($subQuery.' t')->order($order_by)->limit($pager->firstRow.",".$pager->listRows)->select();
		}

		foreach($list as $key=>$val){
			$list[$key]['days']=round(abs(strtotime($val['end_time'])-time())/3600/24);
			$list[$key]['img']=$orig_list[$val['orig_id']]['img_url'];
			$list[$key]['end_time']=date("Y.m.d", strtotime($val['end_time']));
		}

		$param = array();
		if($orig){
			$param['orig'] = $orig;
		}
		$url['newest'] = U('tick/index',array_merge(array('t'=>$t,'ismy'=>$ismy,'soryby'=>'newest'),$param));
		$url['hottest'] = U('tick/index',array_merge(array('t'=>$t,'ismy'=>$ismy,'soryby'=>'hottest'),$param));
		$url['ismy_0'] = U('tick/index',array_merge(array('t'=>$t,'ismy'=>0,'soryby'=>$soryby),$param));
		$url['ismy_1'] = U('tick/index',array_merge(array('t'=>$t,'ismy'=>1,'soryby'=>$soryby),$param));
		$url['ismy'] = U('tick/index',array_merge(array('t'=>$t,'soryby'=>$soryby),$param));
		$url['t_1'] = U('tick/index',array_merge(array('t'=>1,'ismy'=>$ismy,'soryby'=>$soryby),$param));
		$url['t_2'] = U('tick/index',array_merge(array('t'=>2,'ismy'=>$ismy,'soryby'=>$soryby),$param));
		$url['t'] = U('tick/index',array_merge(array('ismy'=>$ismy,'soryby'=>$soryby),$param));
		// print_r($url);exit;

		$this->assign('list',$list);
		$this->assign('pagebar',$pager->newfshow());
		$this->_config_seo();
		$this->assign('t',$t);
		$this->assign('ismy',$ismy);
		$this->assign('sortby',$sortby);
		if($orig){
			$this->assign('orig',$orig);
			$this->assign('orig_info',$orig_info);
		}
		$this->assign("url", $url);
		$this->display();
	}

	public function show() {
		$id = $this->_get("id","intval");
		!$id && $this->_404();
		$info=D("tick")->get_info($id);		
		!$info && $this->_404();		
		$info['zj']=intval($info['sy'])+intval($info['yl']);
		$info['intro'] = str_replace("\n",'<br>',$info['intro']);
		$info['end_time'] = date("Y.m.d H:i", strtotime($info['end_time']));
		$this->assign("info",$info);

		$orig_info = D("item_orig")->get_info($info['orig_id']);
		$this->assign('orig',$orig_info);

		//相关优惠精选
		$time = time();
		$where="status=1 and add_time<$time and isnice=1 and orig_id=" . $orig_info['id'];
		$item_list = D('item')->item_list($where, 8);
		$this->assign('item_list', $item_list);

		$this->_config_seo();	
		$this->display();
	}

	//兑换优惠券
	public function tkdh(){
		!$this->visitor->is_login&&$this->ajaxReturn(0,'');//未登录
		$info = $this->visitor->get();
		$id = $this->_get('id','intval');
		!$id && $this->ajaxReturn(1,'无优惠券信息');//无ID
		//查询用户积分是否足够
		$yhq = M("tick")->where("id=$id and sy>0")->find();
		!$yhq && $this->ajaxReturn(1,'该优惠券已领完');//优惠券已领完
		if(intval($info['score'])<intval($yhq['dhjf'])){
			$this->ajaxReturn(1,'您的积分不够！');//积分不够
		}
		if($yhq['xl'] > 0){
			$x=M('tk')->where("tick_id=$id and status=1 and uid=".$info['id'])->count();
			if($x>=$yhq['xl'])$this->ajaxReturn(1,'很抱歉，该优惠券每个账户仅限领取'.$x.'次哦，请让些机会给其他菜油吧！');
		}

		//兑换
		$qid = M('tk')->where("tick_id=$id and status=0")->getField('tk_id');	
		!$qid && $this->ajaxReturn(1,'无优惠券兑换码信息');//无优惠券兑换
		$data['uid']=$info['id'];
		$data['get_time']=time();
		$data['status']=1;
		M('tk')->where("tk_id=$qid")->save($data);//更新优惠券信息
		$yl = M('tk')->where("tick_id=$id and status='1'")->count();//已领
		$sy = M('tk')->where("tick_id=$id and status='0'")->count();//未领
		M("tick")->where("id=$id")->save(array('yl'=>"$yl",'sy'=>"$sy"));
		M()->query("update try_user set score=score-$yhq[dhjf] where id=$info[id] limit 1");//更新用户积分
		//积分日志
		$score_log_mod = D('score_log');
		$score_log_mod->create(array(
			'uid' => $info['id'],
			'uname' => $info['username'],
			'action' => 'exchange',
			'score' => -$yhq['dhjf'],
		));
		$score_log_mod->add();
		$xc = array();
		$xc['ftid']=$info['id'];
		$xc['to_id']=$info['id'];
		$xc['to_name']=$info['username'];
		$xc['from_id']=0;
		$xc['from_name']='tryine';
		$xc['add_time']=time();
		$xc['info'] ='领取优惠券：'. M('tick')->where("id=$id")->getField('name');

		M('message')->add($xc);
		D('message')->set_unread_message_num($info['id']);
		$this->ajaxReturn(2,'兑换成功!快去个人中心-我的优惠卷看看吧！');
	}

	//商城优惠券
	public function orig(){
		$id = $this->_get('id','intval');
		!$id&&$this->_404();
		$mod_orig=M("item_orig");
		$mod=M('tick');
		$info = $mod_orig->where("id=$id")->find();
		$this->assign('info',$info);
		!info && $this->_404();
		$pagesize=8;
		$count = $mod->where("orig_id=$id and DATEDIFF(now() ,start_time)>0 and DATEDIFF(end_time,now())>0")->count();
		$pager=$this->_pager($count,$pagesize);
		$list = $mod->where("orig_id=$id and DATEDIFF(now() ,start_time)>0 and DATEDIFF(end_time,now())>0")->limit($pager->firstRow.",".$pager->listRows)->select();
		foreach($list as $key=>$val){
			$list[$key]['days']=round(abs(strtotime($val['end_time'])-time())/3600/24);
		}
		$this->assign('pagebar',$pager->fshow());
		$this->assign('list',$list);
		$this->_config_seo();
		$this->display();
	}

	

	//显示券号
	public function gettk(){
		$tk_id=$this->_get('tk_id','intval');
		$tk_code = M("tk")->where("tk_id=$tk_id")->getField("tk_code");
		$this->ajaxReturn(1,'',$tk_code);
	}
}