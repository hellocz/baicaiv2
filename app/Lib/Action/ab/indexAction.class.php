<?php
class indexAction extends frontendAction {
    
    public function index() {
		function is_mobile(){
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			$mobile_agents = Array("240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi","android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio","au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu","cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ","fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi","htc","huawei","hutchison","inno","ipad","ipaq","ipod","jbrowser","kddi","kgt","kwc","lenovo","lg ","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo","mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-","moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia","nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-","playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo","samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank","sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit","tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin","vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce","wireless","xda","xde","zte");
			$is_mobile = false;
			foreach ($mobile_agents as $device) {
				if (stristr($user_agent, $device)) {
					$is_mobile = true;
					break;
				}
			}
			return $is_mobile;
		}
		
		if(is_mobile()){ //跳转至wap分组
			header("Location: //m.baicaio.com");
		}
		
		$p = $this->_get('p', 'intval', 1);
		$type = $this->_get('type','trim');
		$dss = $this->_get('dss','trim');
		$dss = ($dss=="") ? $_COOKIE['dss'] : $dss;
		// $dss = ($dss=="")?"lb":$dss;
		if($p<1){$p=1;}

		$time=time();		
		$pagesize=2;
		$count = 200; //$mod->where("status=1 and add_time<$time ".$where)->count();
		$pager = $this->_pager($count,$pagesize);

		
		$mod=M("item");
		$queryArr = array();
		$queryArr['where']=" and isnice=1 ";
		$queryArr['order'] =" add_time desc";
		if($p==1){
			//置顶区
			// $front_list = $mod->where("status=1 and isfront=1 and add_time<$time ".$queryArr['where'])->order($queryArr['order'])->select();
			//置顶区 for test
			$front_list = $mod->where("status=1 and add_time<$time ".$queryArr['where'])->limit(13)->order($queryArr['order'])->select();

			foreach($front_list as $key=>$val){
				$front_list[$key]['zan'] = $front_list[$key]['zan']   +intval($front_list[$key]['hits'] /10);
			}

			//小时排行榜
			$time_hour_s = strtotime(date("Y-m-d H:00:00", $time)) - 3600 - 24*60*60*365;
			// $time_hour_s = strtotime(date("Y-m-d H:00:00", $time)) - 3600;
			$time_hour_e = strtotime(date("Y-m-d H:00:00", $time)) - 1;
			$hour = date("H", $time_hour_s);
			//删除上一天当前小时的缓存文件
			$hour_cur = date("H", $time);
			$filename = DATA_PATH . 'hour_list_' . $hour_cur . '.php';
			is_file($filename) && unlink($filename);
			if (false === $hour_list = F('hour_list_' . $hour)) {
				$cate_data = array();
				$hour_list=$mod->query("SELECT * from try_item  WHERE status=1 and add_time between $time_hour_s and $time_hour_e ORDER BY hits desc, add_time desc LIMIT 4");
				F('hour_list_' . $hour, $hour_list);
			}
		}

		//计算首页推荐的时间范围		
		$date_list = array();
		$time = strtotime('2017-02-08 20:00:00');
		$time_homepage_s = strtotime("-" . ($p*2) . " day", strtotime(date("Y-m-d 00:00:00", $time)));
		$time_homepage_e = strtotime("-" . ($p*2 - 2) . " day", strtotime(date("Y-m-d 00:00:00", $time))) - 1;
		$date_list['2'] = date("Y.m.d", $time_homepage_s);
		$date_list['1'] = date("Y.m.d", $time_homepage_e);
		if($p==1){			
			$time_homepage_e = $time;
			$date_list['0'] = date("Y.m.d", $time);
		}
		// echo "start time: " . date("Y-m-d H:i:s", $time_homepage_s) . "<br>";
		// echo "end time: " . date("Y-m-d H:i:s", $time_homepage_e) . "<br>";

		//首页推荐
		$list = $mod->where("status=1 and add_time between $time_homepage_s and $time_homepage_e".$queryArr['where'])->order($queryArr['order'])->select();
		
		$homepage_list = array();
		if(count($list)>=1){
			foreach($list as $key=>$val){
				$list[$key]['zan'] = $list[$key]['zan']   +intval($list[$key]['hits'] /10);
				$d = date("Y.m.d", $list[$key]['add_time']);
				$homepage_list[$d][] = $list[$key];
			}
		}

		$article_list = M("article")->where("add_time > $time_homepage_s and add_time < $time_homepage_e and status=4")->select();

		if(count($article_list)>=1){
			foreach($article_list as $key=>$val){
				$d = date("Y.m.d", $article_list[$key]['add_time']);
				$homepage_list[$d][] = $article_list[$key];
			}
		}

		if(count($homepage_list)>=1){
			$i = 0;
			foreach($homepage_list as $d=>$val){
				usort($homepage_list[$d], 'sortByAddTime');
				$i++;
			}
		}

		if(isset($date_list['0'])){
			$homepage_0_list = isset($homepage_list[$date_list['0']]) ? $homepage_list[$date_list['0']] : array();
		}
		if(isset($date_list['1'])){
			$homepage_1_list = isset($homepage_list[$date_list['1']]) ? $homepage_list[$date_list['1']] : array();
		}
		if(isset($date_list['2'])){
			$homepage_2_list = isset($homepage_list[$date_list['2']]) ? $homepage_list[$date_list['2']] : array();
		}

		// echo "<pre>";print_r($date_list);print_r($homepage_list);echo "</pre>";exit;

		//最新原创
		$queryArr = array();
		$queryArr['where']=" and isoriginal=1 ";
		$queryArr['order'] =" add_time desc";
		$original_list = $mod->where("status=1 and add_time<$time ".$queryArr['where'])->limit(4)->order($queryArr['order'])->select();

		// //小时榜和24小时榜
		// $time_hour = $time - 3600;
		// $time_day = $time - 86400;
		// $hour_list=$mod->query("SELECT * from try_item  WHERE add_time between $time_hour and $time ORDER BY hits desc LIMIT 9");
		// $day_list=$mod->query("SELECT id,title,img,price from try_item  WHERE add_time between $time_day and $time ORDER BY hits desc LIMIT 9");
		

		//热门活动 活动公告
		$hd_list = M("hd")->limit(3)->order("order_s asc,id desc")->select();
		

		//我的关注
		$mod=M("item");
		$queryArr = array();
		$queryArr['where'] = '';
		$queryArr['order'] =" add_time desc";
		$notify_tag = M("notify_tag");
		$user = $this->visitor->get();
		$tags = $notify_tag->field('tag')->where(array('userid' => $user['id'],'f_sign'=> 1 ))->select();
		$this->assign('tags',$tags);

		$this->assign('front_list',$front_list);
		$this->assign('item_homepage_0_list',$homepage_0_list);
		$this->assign('item_homepage_1_list',$homepage_1_list);
		$this->assign('item_homepage_2_list',$homepage_2_list);
		$this->assign('date_list',$date_list);
		$this->assign('hour_list',$hour_list);
		$this->assign('original_list',$original_list);
		// $this->assign('hour_list',$hour_list);
		// $this->assign('day_list',$day_list);
		// $this->assign('item_myitems_list',$myitems_list);
		$this->assign('hd_list',$hd_list);

		$this->assign('p',$p);
		$this->assign('pagebar',$pager->newshow());

		// //每天排名
		// $time_s = strtotime(date('Y-m-d'),time());
		// $time_m_s = strtotime(date('Y-m-1'),time());
		// $time_m_e = time();
		// $time_e =$time_s+24*60*60;
		// $pm1 = M()->query("select distinct uid as id,uname,sum(score) as num from try_score_log where add_time>$time_s and add_time<$time_e group by uname order by num desc,uid asc limit 4");
		// $pmm = M()->query("select distinct uid as id,uname,sum(score) as num from try_score_log where add_time>$time_m_s and add_time<$time_m_e group by uname order by num desc,uid asc limit 4");
		// //全部排名
		// $pma = M("user")->field("id,username,score")->order("score desc,id asc")->limit(4)->select();		
		// //查询是否关注
		// if($this->visitor->is_login){
		// 	$user = $this->visitor->get();
		// 	$follow_list = M("user_follow")->where("uid=$user[id]")->select();
		// 	foreach($pm1 as $key=>$val){
		// 		foreach($follow_list as $k=>$v){
		// 			if($val['uid']==$v['follow_uid']){
		// 				$pm1[$key]['follow']=1;
		// 			}
		// 		}
		// 	}
		// 	foreach($pmm as $key=>$val){
		// 		foreach($follow_list as $k=>$v){
		// 			if($val['uid']==$v['follow_uid']){
		// 				$pmm[$key]['follow']=1;
		// 			}
		// 		}
		// 	}
		// 	foreach($pma as $key=>$val){
		// 		foreach($follow_list as $k=>$v){
		// 			if($val['id']==$v['follow_uid']){
		// 				$pma[$key]['follow']=1;
		// 			}
		// 		}
		// 	}
		// }
		// $this->assign('pm1',$pm1);
		// $this->assign('pmm',$pmm);
		// $this->assign('pma',$pma);
		// //表现形式

		// $dss =$this->_get("dss","trim");
		// $dss = ($dss=="")?$_SESSION['dss']:$dss;
		// $dss = ($dss=="")?"lb":$dss;
		// $_SESSION['dss']=$dss;
		$this->assign("dss",$dss);
		// $this->assign("tab",$tab);
		// $this->assign("lb_url",U('index/index',array('type'=>$type,'tab'=>$tab,'dss'=>'lb')));
		// $this->assign("cc_url",U('index/index',array('type'=>$type,'tab'=>$tab,'dss'=>'cc')));

		$this->_config_seo();
		$this->assign("bcid",0);
		
		// $thd = M("item")->where('istop = 1')->limit(8)->order("id desc")->select();
		// $this->assign('thd',$thd);

		

		$where1['cate_id']=16;
		$where1['status']=array("in","1,4");
		$article_list = M("article")->where($where1)->order("add_time desc")->limit(4)->select();
		$this->assign("zx_list",$article_list);
		$this->assign("article_hide",1);

		$this->display();
    }

    /**
     * 前台分页统一
     */
    protected function _pager($count, $pagesize) {
        $pager = new Page($count, $pagesize);
        $pager->rollPage = 5;
        $pager->setConfig('prev', '<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>');
        $pager->setConfig('next', '<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>');
        $pager->setConfig('theme', '%upPage% %first% %linkPage% %end% %downPage%');
        return $pager;
    }

    public function qrcode($url="www.baidu.com",$level=7,$size=4)
    {
              Vendor('phpqrcode.phpqrcode');
              $errorCorrectionLevel =intval($level) ;//容错级别 
              $matrixPointSize = intval($size);//生成图片大小 
             //生成二维码图片 
              $object = new \QRcode();
              $object->png($url, false, $errorCorrectionLevel, $matrixPointSize, 2);   
    }
}
