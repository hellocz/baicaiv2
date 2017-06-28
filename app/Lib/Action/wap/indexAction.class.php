<?php
class indexAction extends frontendAction {

	 public function index() {
		$type = $this->_get('type','trim');
		$dss = $this->_get('dss','trim');
        //热门
		$mod=M("item");
		if($type==""||$type=='isnice'){
			$where=" and isnice=1 ";
			$order =" add_time desc";
			$tab = "isnice";
		}else{
			$where=" and isbao=1 ";
			$order =" add_time desc";
			$tab = "isbao";
		}	
		$time=time();		
		$pagesize=18;
		$count = 500; //$mod->where("status=1 and add_time<$time ".$where)->count();
		$pager = $this->_pager($count,$pagesize);
		$list = $mod->where("status=1 and add_time<$time ".$where)->limit($pager->firstRow.",".$pager->listRows)->order($order)->select();
		foreach($list as $key=>$val){
			$list[$key]['orig_name']=getly($val['orig_id']);
			$list[$key]['zan'] = $list[$key]['zan']   +intval($list[$key]['hits'] /10);
		}
		/*
        foreach ($list as $key=>$val) {
			if($val["sh_time"]>$val["ds_time"]){
				$list[$key]['add_time']=$val["sh_time"];
			}else{
				$list[$key]['add_time']=$val["ds_time"];
			} 
        }	
		*/
		/*echo "<pre>";
		var_dump($list);*/
		$this->assign('item_list',$list);
		$this->assign('pagebar',$pager->fshow());
		$p = $this->_get("p",'intval');
		if($p<1){$p=1;}
		$this->assign('p',$p);
		//每天排名
		$time_s = strtotime(date('Y-m-d'),time());
		$time_e =$time_s+24*60*60;		
		$pm1 = M()->query("select distinct uid,uname,sum(score) as num from try_score_log where add_time>$time_s and add_time<$time_e group by uname order by num desc,uid asc limit 4");
		//全部排名
		$pma = M("user")->order("score desc,id asc")->limit(4)->select();		
		//查询是否关注
		if($this->visitor->is_login){
			$user = $this->visitor->get();
			$follow_list = M("user_follow")->where("uid=$user[id]")->select();
			foreach($pm1 as $key=>$val){
				foreach($follow_list as $k=>$v){
					if($val['uid']==$v['follow_uid']){
						$pm1[$key]['follow']=1;
					}
				}
			}
			foreach($pma as $key=>$val){
				foreach($follow_list as $k=>$v){
					if($val['id']==$v['follow_uid']){
						$pma[$key]['follow']=1;
					}
				}
			}
		}
		$this->assign('pm1',$pm1);
		$this->assign('pma',$pma);
		//表现形式

        $dss =$this->_get("dss","trim");
		$dss = ($dss=="")?$_SESSION['dss']:$dss;
		$dss = ($dss=="")?"lb":$dss;
		$_SESSION['dss']=$dss;
		$this->assign("dss",$dss);
		$this->assign("tab",$tab);
		$this->assign("lb_url",U('index/index',array('type'=>$type,'tab'=>$tab,'dss'=>'lb')));
		$this->assign("cc_url",U('index/index',array('type'=>$type,'tab'=>$tab,'dss'=>'cc')));
        $this->_config_seo();
		$this->assign("bcid",0);
		//热门活动
		$hd = M("hd")->limit(8)->order("order_s asc,id desc")->select();
		$thd = M("item")->where('istop = 1')->limit(8)->order("id desc")->select();
		$this->assign('hd',$hd);
		$this->assign('thd',$thd);


        $this->display();
    }

    
    public function index1() {
		$type = $this->_get('type','trim');
		$dss = $this->_get('dss','trim');
        //热门
		$mod=M("item");
		if($type==""||$type=='isnice'){
			$where=" and isnice=1 ";
			$order =" isnice desc,";
			$tab = "isnice";
		}else{
			$where=" and isbao=1 ";
			$order =" isbao desc,";
			$tab = "isbao";
		}	
		$time=time();		
		$pagesize=18;
		$count = $mod->where("status=1 and add_time<$time ".$where)->count();
		$pager = $this->_pager($count,$pagesize);
		$list = $mod->where("status=1 and add_time<$time  ".$where)->limit($pager->firstRow.",".$pager->listRows)->order($order.'id desc')->select();
		foreach($list as $key=>$val){
			$list[$key]['orig_name']=getly($val['orig_id']);
		}
		$this->assign('item_list',$list);
		$this->assign('pagebar',$pager->fshow());
		$p = $this->_get("p",'intval');
		if($p<1){$p=1;}
		$this->assign('p',$p);
		//每天排名
		$time_s = strtotime(date('Y-m-d'),time());
		$time_e =$time_s+24*60*60;		
		$pm1 = M()->query("select distinct uid,uname,sum(score) as num from try_score_log where add_time>$time_s and add_time<$time_e group by uname order by num desc,uid asc limit 4");
		//全部排名
		$pma = M("user")->order("score desc,id asc")->limit(4)->select();		
		//查询是否关注
		if($this->visitor->is_login){
			$user = $this->visitor->get();
			$follow_list = M("user_follow")->where("uid=$user[id]")->select();
			foreach($pm1 as $key=>$val){
				foreach($follow_list as $k=>$v){
					if($val['uid']==$v['follow_uid']){
						$pm1[$key]['follow']=1;
					}
				}
			}
			foreach($pma as $key=>$val){
				foreach($follow_list as $k=>$v){
					if($val['id']==$v['follow_uid']){
						$pma[$key]['follow']=1;
					}
				}
			}
		}
		$this->assign('pm1',$pm1);
		$this->assign('pma',$pma);
		//表现形式
		$user = $this->_get("dss","trim");
        $dss =$this->_get("dss","trim");
		$dss = ($dss=="")?$_SESSION['dss']:$dss;
		$dss = ($dss=="")?"cc":$dss;
		$_SESSION['dss']=$dss;
		$this->assign("dss",$dss);
		$this->assign("tab",$tab);
		$this->assign("lb_url",U('index/index',array('type'=>$type,'tab'=>$tab,'dss'=>'lb')));
		$this->assign("cc_url",U('index/index',array('type'=>$type,'tab'=>$tab,'dss'=>'cc')));
        $this->_config_seo();
		$this->assign("bcid",0);
		//热门活动
		$hd = M("hd")->limit(8)->order("id desc")->select();
		foreach($hd as $key=>$val){
			if($val['istop']==1){
				$thd[]=$val;
			}
		}
		$this->assign('hd',$hd);
		$this->assign('thd',$thd);
        $this->display();
    }
}