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
		$pager = $this->_new_pager($count,$pagesize);
		
		$mod=D("item");
		$queryArr = array();
		$queryArr['where']=" and isnice=1 and hits>600";//测试条件
		$queryArr['order'] =" add_time desc";
		if($p==1){
			//置顶区 
			$front_list = $mod->front_list();

			//小时排行榜
			$hour_list = $mod->item_hour_cache();
			$hour_list = array_slice($hour_list, 0, 4);
		}

		//计算首页推荐的时间范围		
		$date_list = array();
		$time = time();
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


		//分类数据
		$cate_list = D('item_cate')->cate_data_cache();

		//首页推荐
		$item_list = $mod->item_list("status=1 and add_time between $time_homepage_s and $time_homepage_e".$queryArr['where'], '');
		
		$homepage_list = array();
		if(count($item_list)>=1){
			foreach($item_list as $key=>$val){
				//商品一级分类
				$cate_id = $item_list[$key]['cate_id'];
				$cate_name = '';
				if(isset($cate_list[$cate_id]) && $cate_list[$cate_id]['pid']==0){
					$cate_name = $cate_list[$cate_id]['name'];
				}else if(isset($cate_list[$cate_id])){
					list($p1,$p2) = explode('|', $cate_list[$cate_id]['spid']."||");
					if(isset($cate_list[$p1])){
						$cate_name = $cate_list[$p1]['name'];
					}
				}
				$item_list[$key]['cate_name'] = $cate_name;

				$d = date("Y.m.d", $item_list[$key]['add_time']);
				$homepage_list[$d][] = $item_list[$key];
			}
		}

		$article_list = D("article")->article_list("add_time > $time_homepage_s and add_time < $time_homepage_e and status=4", '');

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
			$homepage_list_0 = isset($homepage_list[$date_list['0']]) ? $homepage_list[$date_list['0']] : array();
		}
		if(isset($date_list['1'])){
			$homepage_list_1 = isset($homepage_list[$date_list['1']]) ? $homepage_list[$date_list['1']] : array();
		}
		if(isset($date_list['2'])){
			$homepage_list_2 = isset($homepage_list[$date_list['2']]) ? $homepage_list[$date_list['2']] : array();
		}

		// echo "<pre>";print_r($date_list);print_r($homepage_list);echo "</pre>";exit;

		//最新原创
		$article_list = D("article")->newest_list(4);

		//热门活动 活动公告
		$hd_list = M("hd")->limit(3)->order("order_s asc,id desc")->select();

		//热门圈子
		$hot_article_list = D("article")->hot_list(5);


		//油菜排行，用户排名
		$user_list['offer'] = D("user")->top_user_list('offer', '', 5); //贡献
		$user_list['exp'] = D("user")->top_user_list('exp', '', 5); //等级
		$user_list['comm'] = D("user")->top_user_list('comm', '', 5); //评论
		$user_list['shares'] = D("user")->top_user_list('shares', '', 5); //爆料

		if($this->visitor->is_login){

			$user = $this->visitor->get();

			//我的关注
			$tag_count = D("notify_tag")->user_follow_count($this->visitor->info['id']);
			
			$this->assign('user',array('tag_count' => $tag_count, 'grade' => $user['grade'], 'score' => $user['score']));
		}

		//商城列表
		$origs = D("item_orig")->orig_cache();

		$this->assign('origs',$origs);
		$this->assign('front_list',$front_list);
		$this->assign('item_list_homepage_0',$homepage_list_0);
		$this->assign('item_list_homepage_1',$homepage_list_1);
		$this->assign('item_list_homepage_2',$homepage_list_2);
		$this->assign('date_list',$date_list);
		$this->assign('hour_list',$hour_list);
		$this->assign('article_list',$article_list);
		$this->assign('hot_article_list',$hot_article_list);
		$this->assign('hd_list',$hd_list);
		$this->assign('user_list_offer',$user_list['offer']);
		$this->assign('user_list_exp',$user_list['exp']);
		$this->assign('user_list_comm',$user_list['comm']);
		$this->assign('user_list_shares',$user_list['shares'] );

		$this->assign('p',$p);
		$this->assign('pagebar',$pager->newshow());

		$this->assign("dss",$dss);

		$this->_config_seo();

		$this->display();
    }

    /**
     * 前台分页统一
     */
    protected function _new_pager($count, $pagesize) {
        $pager = new Page($count, $pagesize);
        $pager->rollPage = 5;
        $pager->setConfig('prev', '<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>');
        $pager->setConfig('next', '<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>');
        // $pager->setConfig('theme', '%upPage% %first% %linkPage% %end% %downPage%');
        $pager->setConfig('theme', '%upPage% %first% %linkPage% %downPage%');
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
