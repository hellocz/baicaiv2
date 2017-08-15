<?php
class itemAction extends backendAction {
    public function _initialize() {
        parent::_initialize();
        $this->_mod = D('item');
        $this->_cate_mod = D('item_cate');
    }

    public function _before_index() {
        //显示模式
        $sm = $this->_get('sm', 'trim');
        $this->assign('sm', $sm);
        //分类信息
        $res = $this->_cate_mod->field('id,name')->select();
        $cate_list = array();
        foreach ($res as $val) {
            $cate_list[$val['id']] = $val['name'];
        }
		
        $this->assign('cate_list', $cate_list);

        //默认排序
        $this->sort = 'ordid ASC,';
        $this->order ='add_time DESC';
    }

    public function delete(){
        $id = $this->_get('id', 'intval');
        !$id && $this->_404();
        //donothing;
        $data['status'] = 4;
        $data['add_time'] = 0;
        if (false !==   $this->_mod->where(array('id'=>$id))->save($data)) {
                IS_AJAX && $this->ajaxReturn(1, L('operation_success'));
                $this->success(L('operation_success'));
            }else {
                IS_AJAX && $this->ajaxReturn(0, L('operation_failure'));
                $this->error(L('operation_failure'));
            }
    }

    protected function _search() {
        $map = array();
        //'status'=>1
        ($time_start = $this->_request('time_start', 'trim')) && $map['add_time'][] = array('egt', strtotime($time_start));
        ($time_end = $this->_request('time_end', 'trim')) && $map['add_time'][] = array('elt', strtotime($time_end)+(24*60*60-1));
        ($price_min = $this->_request('price_min', 'trim')) && $map['price'][] = array('egt', $price_min);
        ($price_max = $this->_request('price_max', 'trim')) && $map['price'][] = array('elt', $price_max);
        ($rates_min = $this->_request('rates_min', 'trim')) && $map['rates'][] = array('egt', $rates_min);
        ($rates_max = $this->_request('rates_max', 'trim')) && $map['rates'][] = array('egt', $rates_max); 
		if($source = $this->_request('source',    'trim')==NULL){
			($source = $this->_request('source',    'trim')) && $map['source'][]= array('eq', $source);
		}else if($source = $this->_request('source',  'trim')==0){
			 $map['source'][]= array('eq', 0);
			
		}else{
			($source = $this->_request('source',    'trim')) && $map['source'][]= array('eq', $source);	
		}
		
		
        ($uname = $this->_request('uname', 'trim')) && $map['uname'] = array('like', '%'.$uname.'%');
        ($item_type = $this->_request('item_type', 'trim')) && $map[$item_type][] = array('eq', 1);   //商品属性
        $cate_id = $this->_request('cate_id', 'intval');
        if ($cate_id) {
            $id_arr = $this->_cate_mod->get_child_ids($cate_id, true);
            $map['cate_id'] = array('IN', $id_arr);
            $spid = $this->_cate_mod->where(array('id'=>$cate_id))->getField('spid');
            if( $spid==0 ){
                $spid = $cate_id;
            }else{
                $spid .= $cate_id;
            }
        }
        if( $_GET['status']==null ){
            $status = -1;
        }else{
            $status = intval($_GET['status']);
        }
        $status>=0 && $map['status'] = array('eq',$status);
        if($status == 2){
            $this->order ='id DESC';
        }
        else{
            $this->order ='add_time DESC';
        }
        $keyword = $this->_request('keyword', 'trim');
        $array = explode(" ", $keyword);
      foreach($array as $k=>$v){
          $array[$k] =  '%'.$array[$k].'%';
       }
        $where['title'] = array('like',$array,'AND');
        $where['content'] = array('like',$array,'AND');
        $where['_logic'] = 'or';
        $map['_complex'] = $where;
        $this->assign('search', array(
            'time_start' => $time_start,
            'time_end' => $time_end,
            'price_min' => $price_min,
            'price_max' => $price_max,
            'rates_min' => $rates_min,
            'rates_max' => $rates_max,
            'uname' => $uname,
            'status' =>$status,
            'selected_ids' => $spid,
            'cate_id' => $cate_id,
            'keyword' => $keyword,
            'item_type'=>$item_type,
        ));
		
	/*	echo $source;
		var_dump($map);*/
        return $map;
    }

    public function add() {
        /*if (IS_POST) {
            //获取数据
            if (false === $data = $this->_mod->create()) {
                $this->ajaxReturn(0,$this->_mod->getError());

            }
            if( !$data['cate_id']||!trim($data['cate_id']) ){
                $this->ajaxReturn(0,'请选择商品分类');

            }
            //必须上传图片
            if (empty($_FILES['img']['name']) && empty($_POST['img_usb'])) {
                $this->ajaxReturn(0,'请上传商品图片');

            }
			$time=time();
            $data['uid'] ="0";
            $data['uname'] =$_SESSION['admin']['username'];
			$data['isnice'] ="1";
			$data['sh_time']=$time;
			$data['ds_time']=strtotime($_POST['ds_time']);
            //上传图片
            $date_dir = date('ym/d/'); //上传目录
            $item_imgs = array(); //相册
            if($_POST['img_usb']){
                $data['img'] =$_POST['img_usb'];
            }else{
                $result = $this->_upload($_FILES['img'], 'item/'.$date_dir);
                if ($result['error']) {
                    $this->error($result['info']);
                } else {
                    $data['img'] = get_rout_img($date_dir . $result['info'][0]['savename'],'item');
                }
            }

            //保存一份到相册
            $item_imgs[] = array(
                'url'     => $data['img'],
            );
            //上传相册
            $file_imgs = array();
            foreach( $_FILES['imgs']['name'] as $key=>$val ){
                if( $val ){
                    $file_imgs['name'][] = $val;
                    $file_imgs['type'][] = $_FILES['imgs']['type'][$key];
                    $file_imgs['tmp_name'][] = $_FILES['imgs']['tmp_name'][$key];
                    $file_imgs['error'][] = $_FILES['imgs']['error'][$key];
                    $file_imgs['size'][] = $_FILES['imgs']['size'][$key];
                }
            }
            if( $file_imgs ){
                $result = $this->_upload($file_imgs, 'item/'.$date_dir);
                if ($result['error']) {
                    $this->error($result['info']);
                } else {
                    foreach( $result['info'] as $key=>$val ){
                        $item_imgs[] = array(
                            'url'    => get_rout_img($date_dir . $val['savename'],'item'),
                            'order'  => $key + 1,
                        );
                    }
                }
            }

            if($_POST['img_usbs']){
                $a = count($item_imgs);
                foreach( $_POST['img_usbs'] as $key=>$val ) {

                    $a=$a+1;
                    $item_imgs[] = array(
                        'url' => $val,
                        'order' => $a,
                    );
                }
                }
			foreach($_POST['link_type'] as $key=>$val){
				if($_POST['link_url'][$key]!=''){
					$arr[$key]=array('name'=>$val,'link'=>$_POST['link_url'][$key]);
				}
			}
			$data['url']=$arr[0]['link'];
			$data['go_link']=serialize($arr);
            $data['imgs'] = $item_imgs;
            $item_id = $this->_mod->publish($data);
            !$item_id && $this->error(L('operation_failure'));

            //附加属性
            $attr = $this->_post('attr', ',');
            if( $attr ){
                foreach( $attr['name'] as $key=>$val ){
                    if( $val&&$attr['value'][$key] ){
                        $atr['item_id'] = $item_id;
                        $atr['attr_name'] = $val;
                        $atr['attr_value'] = $attr['value'][$key];
                        M('item_attr')->add($atr);
                    }
                }
            }
            $this->ajaxReturn(1,L('operation_success'));
        }*/
    if(IS_AJAX){
        $title = $_GET['title'];
        $item_id  =$_GET['id'];
        if($title){
            if($item_id){
                $id = d('item')->where(array('id'=>$item_id))->save(array('title'=>$title,'status'=>2,'uid'=>$_SESSION['admin']['id'],'uname'=>$_SESSION['admin']['username']));
            }else{
                $item_id= $id = d('item')->add(array('title'=>$title,'status'=>2,'uid'=>$_SESSION['admin']['id'],'uname'=>$_SESSION['admin']['username']));
            }

            if($id){
                $this->ajaxReturn(1,$item_id);
            }else{
                $this->ajaxReturn(0);
            }
        }

    }
    else {
            //来源
            // $orig_list = M()->query('SELECT *,fristPinyin(name) as t FROM `try_item_orig` WHERE 1 order by t');
            $orig_list = M("item_orig")->order("name asc")->field("id,name")->select();
            
           
            $settlesRes = array(); 
            foreach ($orig_list as $set) {
                $settlesRes[iconv('UTF-8', 'GBK', $set['name'])] = $set;
            }
            ksort($settlesRes);

		
            $this->assign('orig_list',$settlesRes);
            //采集马甲

            //$auto_user = M('auto_user')->select();
            //$this->assign('auto_user', $auto_user);
            $this->display();
        }
    }

    public function refresh_tag(){
        $begin = $this->_get('begin', 'intval');
        $length  = 500;
        echo "begin is " . $begin . " length is " .$length . "<br>"; 

        $items = M("item")->field("id,tag_cache") ->limit($begin,$length)->select();

        !$items && $this->success(L('operation_success'));
        foreach ($items as $item) {
            $tag_list = unserialize($item['tag_cache']);
                if ($tag_list) {
                $item_tag_arr = $tag_cache = array();
                $tag_mod = M('tag');
                foreach ($tag_list as $_tag_name) {
                    $tag_id = $tag_mod->where(array('name'=>$_tag_name))->getField('id');
                    !$tag_id && $tag_id = $tag_mod->add(array('name' => $_tag_name)); //标签入库
                    $item_tag_arr[] = array('item_id'=>$item['id'], 'tag_id'=>$tag_id);
                    $tag_cache[$tag_id] = $_tag_name;
                }
                if ($item_tag_arr) {
                    $item_tag = M('item_tag');
                    //清除关系
                    $item_tag->where(array('item_id'=>$item['id']))->delete();
                    //商品标签关联
                    $item_tag->addAll($item_tag_arr);
                    $data['tag_cache'] = serialize($tag_cache);
                    M("item")->where(array('id'=>$item['id']))->save($data);
                }
            }
        }
        $begin = $begin+$length;
        $this->assign("begin",$begin);
        $this->assign("length",$length);
        $this->display();
   //    $this->redirect("item/refresh_tag",$arrayName = array('begin' =>$begin ,'length'=>$length));

    }

    public function edit() {	
        if (IS_POST) {	
            //获取数据
            if (false === $data = $this->_mod->create()) {
                $this->error($this->_mod->getError());
            }
            if( !$data['cate_id']||!trim($data['cate_id']) ){
                IS_AJAX && $this->ajaxReturn(0,'请选择商品分类');
                $this->error('请选择商品分类');
            }
            $item_img=M("item")->where("id=$data[id]")->getField("img");
            if(!$item_img){
                if (empty($_FILES['img']['name']) && empty($_POST['img']) && empty($_POST['img_usb']) && empty($_FILES['J_img']['name']) ) {
                    IS_AJAX &&  $this->ajaxReturn(0,'请上传商品图片');
                    $this->error('请上传商品图片');
                }
            }
			//如果是管理员发表的则直接通过
			
			if($_POST['ds_time']){
				$data['ds_time']=strtotime($_POST['ds_time']);
			}else{
				$data['ds_time']=strtotime($_POST['add_time']);
			}
			
			
			
            if($_POST['add_time']) $data['add_time']=strtotime($_POST['add_time']);
			$data['orig_id']=$_POST['orig_id'];
            //$data['orig_id']=M('item_orig')->where("name='".$data['orig_id']."'")->getField('id');//肖
			
			if($_POST['statusA']=='1' || $_POST['statusA']=='2'){
                                                $data['status']=$_POST['statusA'];
                                            }else{
                                                $data['status']=$this->_post('status','intval');     
                                            }
                                            if($data['status'] == '1' && (!isset($data['add_time']) || $data['add_time'] ==0 || $data['add_time'] =="")){
                                                                                                 $data['add_time']=time();
                                                                                            }
		
			
			if($_POST['ishot']){
				$data['ishot']=1;
			}else{
				$data['ishot']=0;
			}
			
			if($_POST['isbest']){
				$data['isbest']=1;
			}else{
				$data['isbest']=0;
			}
			
			if($_POST['istop']){
				$data['istop']=1;
			}else{
				$data['istop']=0;
			}

                                        if($_POST['isoriginal']){
                                            $data['isoriginal']=1;
                                        }else{
                                            $data['isoriginal']=0;
                                        }
			
			if($_POST['ispost']){
				$data['ispost']=1;
			}else{
				$data['ispost']=0;
			}
                                        if($_POST['isnice']){
                                            $data['isnice']=1;
                                        }else{
                                                if(!$_POST['isbao']){
                                             $data['isnice']=1;
                                                }
                                                    else
                                            $data['isnice']=0;
                                        }
			
			
			/*if($_POST['isbest'])$data['isbest']=$this->_post('isbest','intval');
			if($_POST['ishot'])$data['ishot']=$this->_post('ishot','intval');
			if($_POST['istop'])$data['istop']=$this->_post('istop','intval');

			*/
			
			
			
            $item_uid=M("item")->where("id=$data[id]")->getField("uid");
            if($_SESSION['admin']['zhubian'] ==1 &&  $data['status'] !=3){
                //$data['status']=$_POST['status'];
				//echo $data['status'];
                $data['sh_time']=time();
                
         if($datas['add_time']  > $datas['sh_time'] ){
            $datas['sh_time']  = $datas['add_time'];
        }
        	
            }
            if($data['status'] == 3){
                $user = M("user")->where("id=$item_uid")->find();
                if($user){
                $xc = array();
                $xc['ftid']=$user['id'];
                $xc['to_id']=$user['id'];
                $xc['to_name']=$user['username'];
                $xc['from_id']=0;
                $xc['from_name']='tryine';
                $xc['add_time']=time();
                $xc['info'] ="您的爆料>> <a href='".U('home/item/edit',array('id'=>$data['id']))."'>".$_POST['title']."</a> 被退回，退回理由：".$_POST['remark'];
                M('message')->add($xc);
                }
            }
            $item_id = $data['id'];
            $date_dir = date('ym/d/'); //上传目录
            $item_imgs = array(); //相册
            //修改图片
            if($_POST['img_usb']){
                $data['img'] =$_POST['img_usb'];
            }
            if (!empty($_FILES['img']['name'])) {
                $result = $this->_upload($_FILES['img'], 'item/'.$date_dir);
                if ($result['error']) {
                    $this->error($result['info']);
                } else {
                    $data['img'] = get_rout_img($date_dir . $result['info'][0]['savename'],'item');
                    //保存一份到相册
                    $item_imgs[] = array(
                        'item_id' => $item_id,
                        'url'     => $data['img'],
                    );
                }
            }

            //上传相册
            $file_imgs = array();
            foreach( $_FILES['imgs']['name'] as $key=>$val ){
                if( $val ){
                    $file_imgs['name'][] = $val;
                    $file_imgs['type'][] = $_FILES['imgs']['type'][$key];
                    $file_imgs['tmp_name'][] = $_FILES['imgs']['tmp_name'][$key];
                    $file_imgs['error'][] = $_FILES['imgs']['error'][$key];
                    $file_imgs['size'][] = $_FILES['imgs']['size'][$key];
                }
            }
            if( $file_imgs ){
                $result = $this->_upload($file_imgs, 'item/'.$date_dir);
                if ($result['error']) {
                    $this->error($result['info']);
                } else {
                    foreach( $result['info'] as $key=>$val ){
                        $item_imgs[] = array(
                            'item_id' => $item_id,
                            'url'    => get_rout_img($date_dir . $val['savename'],'item'),
                            'order'   => $key + 1,
                        );
                    }
                }
            }
            if($_POST['img_usbs']){
                $a = count($item_imgs);
                foreach( $_POST['img_usbs'] as $key=>$val ) {
                    $a=$a+1;
                    $item_imgs[] = array(
                        'url' => $val,
                        'order' => $a,
                    );
                }
            }
            //标签
            $tags = $this->_post('tags', 'trim');
            if (!isset($tags) || empty($tags)) {
                $tag_list = D('tag')->get_tags_by_title($data['intro']);
            } else {
                if(strpos($tags, "、") !== false){
                    $tag_list = explode('、', $tags);
                }
                else{
                    $tag_list = explode(',', $tags);
                }
            }
            if ($tag_list) {
                $item_tag_arr = $tag_cache = array();
                $tag_mod = M('tag');
                foreach ($tag_list as $_tag_name) {
                    $tag_id = $tag_mod->where(array('name'=>$_tag_name))->getField('id');
                    !$tag_id && $tag_id = $tag_mod->add(array('name' => $_tag_name)); //标签入库
                    $item_tag_arr[] = array('item_id'=>$item_id, 'tag_id'=>$tag_id);
                    $tag_cache[$tag_id] = $_tag_name;
                }
                if ($item_tag_arr) {
                    $item_tag = M('item_tag');
                    //清除关系
                    $item_tag->where(array('item_id'=>$item_id))->delete();
                    //商品标签关联
                    $item_tag->addAll($item_tag_arr);
                    $data['tag_cache'] = serialize($tag_cache);
                }
            }
			foreach($_POST['link_type'] as $key=>$val){
				if($_POST['link_url'][$key]!=''){
					$arr[$key]=array('name'=>$val,'link'=>$_POST['link_url'][$key]);
				}
			}
			$data['url']=$arr[0]['link'];
			$data['go_link']=serialize($arr);
            //更新商品
            //$file_name='log.txt';
            if(empty($data['img'])){
                $data['img'] = $item_img;
            }
          //  file_put_contents($file_name, 'img123'.$data['img'].'img123', FILE_APPEND);
            $this->_mod->where(array('id'=>$item_id))->save($data);
             if($_POST['article_list']){
                $vote = M("vote")->where(array('item_id'=>$item_id))->find();
                if($vote){
                    $vote['article_list'] = $_POST['article_list'];
                    M("vote")->where(array('item_id'=>$item_id))->save($vote);
                }
                else{
                        M('vote')->add(array('item_id'=>$item_id,"xid"=>3,"article_list"=>$_POST['article_list']));
                }
             }
             else{
                $vote = M("vote")->where(array('item_id'=>$item_id))->find();
                if($vote){
                   $vote['article_list'] = $_POST['article_list'];
                    M("vote")->where(array('item_id'=>$item_id))->save($vote);
                }
             }
             if($_POST['isbao']){
            $item = $this->_mod->where(array('id'=>$item_id))->find();
            $diu_item['diu_id']= $item['id'];
            $diu_item['orig_id'] = $item['orig_id'];
            $diu_item['cate_id'] = $item['cate_id'];
            $diu_item['uid'] = $item['uid'];
            $diu_item['uname'] = $item['uname'];
            $diu_item['status'] = $item['status'];
            $diu_item['isbao'] = $item['isbao'];
            $diu_item['zan'] = rand(0,5);
            if($data['add_time']==0){
                  $diu_item['add_time'] = time();
            }
            else{
                $diu_item['add_time'] = $item['add_time'];
            }
            
            $diu_item['url'] = $item['url'];
            $diu_item['go_link'] = $item['go_link'];
            $diu_item['img'] = $item['img'];
            $diu_item['title'] = $item['title'];
            $diu_item['content'] = $item['content'];
            $diu_item['intro'] = $item['intro'];
            M("item_diu")->add($diu_item);
        }
             if($data['status'] == '1' ){
    //              $oauth = new oauth('sina');
    //              $status = substr(strip_tags($data['content']),0,300) . $data['price'] ."http://www.baicaio.com/item/".$data['id']. ".html";
     //             $url = $data['img'];
      //            $oauth->uploaddocument($status,$url);
             }

            //更新图片和相册
            $item_imgs && M('item_img')->addAll($item_imgs);

            //附加属性
            $attr = $this->_post('attr', ',');
            if( $attr ){
                foreach( $attr['name'] as $key=>$val ){
                    if( $val&&$attr['value'][$key] ){
                        $atr['item_id'] = $item_id;
                        $atr['attr_name'] = $val;
                        $atr['attr_value'] = $attr['value'][$key];
                        M('item_attr')->add($atr);
                    }
                }
            }
            if($_POST['statusA']=='5' || $_POST['status']=='5' ){
                $this->redirect('home-item/index', array('id' => $item_id), 1, '页面预览中...');
            }

            IS_AJAX &&  $this->ajaxReturn(1,'添加成功');
            $this->success(L('operation_success'),U('item/index'));
        } else {
            $id = $this->_get('id','intval');
            $item = $this->_mod->where(array('id'=>$id))->find();
            $vote =M("vote")->where(array('item_id'=>$id))->find();
            $this->assign('article_list', $vote['article_list']);
           // print_r($item);exit;
            //分类
            $spid = $this->_cate_mod->where(array('id'=>$item['cate_id']))->getField('spid');
            if( $spid==0 ){
                $spid = $item['cate_id'];
            }else{
                $spid .= $item['cate_id'];
            }
            $this->assign('selected_ids',$spid); //分类选中
            $tag_cache = unserialize($item['tag_cache']);

            $item['tags'] = implode('、', $tag_cache);
			if($item['ds_time']==0){
				$item['ds_time']=time();
			}
            $this->assign('info', $item);
            //来源
      /*    $orig_name=M('item_orig')->where("id='".$item['orig_id']."'")->getField('name');
            $this->assign('orig_name', $orig_name);
            $orig_list = M('item_orig')->select();
            $this->assign('orig_list', $orig_list);*/
			
			 $orig_list = M("item_orig")->order("name asc")->field("id,name")->select();
            $settlesRes = array(); 
            foreach ($orig_list as $set) {
                $settlesRes[iconv('UTF-8', 'GBK', $set['name'])] = $set;
            }
            ksort($settlesRes);

		
            $this->assign('orig_list',$settlesRes);
            //相册
            $img_list = M('item_img')->where(array('item_id'=>$id))->select();
            $this->assign('img_list', $img_list);
            //属性
            $attr_list = M('item_attr')->where(array('item_id'=>$id))->select();
            $this->assign('attr_list', $attr_list);
		
            $this->display();
        }
    }
    function nine(){
        $this->display();
    }
    function  nine_instal(){
        ini_set('max_execution_time', 0);
        $filename = $this->uploadCsv();
        if($filename){
            echo "上传成功，正在导入，请勿关闭页面";
            $rs = import_item($filename);
            if($rs){
                echo "导入成功";
            }else{
                echo "导入失败";
            }
        }else{
            echo "上传失败";
        }
    }
    public function uploadCsv()
    {

        if (!isset($_FILES['file']['tmp_name'])) {
            return false;
        }

        $temp_file = $_FILES['file']['tmp_name'];
        $path = './upload/Csv/';
        if (!is_dir($path)) {
            chmod($path, 511);
            mkdir($path);
        }
        $this->_flushDir($path);
        $target_file = $path . date('Y-m-d_H-i-s') . '.xlsx';
        $res = @move_uploaded_file($temp_file, $target_file);
        print_r($res);
        if (!$res) {
            return false;
        }
        return $target_file;
    }
    protected function _flushDir($dir_path)
    {
        $dh = opendir($dir_path);

        while ($file = readdir($dh)) {
            if (($file == '.') || ($file == '..')) {
                continue;
            }

            if (is_dir($dir_path . $file)) {
                $this->_flushDir($dir_path . $file . '/');
                rmdir($dir_path . $file);
            }

            unlink($dir_path . $file);
        }

        closedir($dh);
    }

    function delete_album() {
        $album_mod = M('item_img');
        $album_id = $this->_get('album_id','intval');
        $album_img = $album_mod->where('id='.$album_id)->getField('url');
        if( $album_img ){
            $ext = array_pop(explode('.', $album_img));
            $album_min_img = C('pin_attach_path') . 'item/' . str_replace('.' . $ext, '_s.' . $ext, $album_img);
            is_file($album_min_img) && @unlink($album_min_img);
            $album_img = C('pin_attach_path') . 'item/' . $album_img;
            is_file($album_img) && @unlink($album_img);
            $album_mod->delete($album_id);
        }
        echo '1';
        exit;
    }


    function delete_attr() {
        $attr_mod = M('item_attr');
        $attr_id = $this->_get('attr_id','intval');
        $attr_mod->delete($attr_id);
        echo '1';
        exit;
    }

    /**
     * 商品审核
     */
    public function check() {
        //分类信息
        $res = $this->_cate_mod->field('id,name')->select();
        $cate_list = array();
        foreach ($res as $val) {
            $cate_list[$val['id']] = $val['name'];
        }
        $this->assign('cate_list', $cate_list);
        //商品信息
        //$map = $this->_search();
        $map=array();
        $map['status']=0;
        ($time_start = $this->_request('time_start', 'trim')) && $map['add_time'][] = array('egt', strtotime($time_start));
        ($time_end = $this->_request('time_end', 'trim')) && $map['add_time'][] = array('elt', strtotime($time_end)+(24*60*60-1));
        $cate_id = $this->_request('cate_id', 'intval');
        if ($cate_id) {
            $id_arr = $this->_cate_mod->get_child_ids($cate_id, true);
            $map['cate_id'] = array('IN', $id_arr);
            $spid = $this->_cate_mod->where(array('id'=>$cate_id))->getField('spid');
            if( $spid==0 ){
                $spid = $cate_id;
            }else{
                $spid .= $cate_id;
            }
        }
        ($keyword = $this->_request('keyword', 'trim')) && $map['title'] = array('like', '%'.$keyword.'%');
        $this->assign('search', array(
            'time_start' => $time_start,
            'time_end' => $time_end,
            'selected_ids' => $spid,
            'cate_id' => $cate_id,
            'keyword' => $keyword,
        ));
        //分页
        $count = $this->_mod->where($map)->count('id');
        $pager = new Page($count, 20);
        $select = $this->_mod->field('id,title,uid,img,tag_cache,cate_id,uid,uname')->where($map)->order('id DESC');
        $select->limit($pager->firstRow.','.$pager->listRows);
        $page = $pager->show();
        $this->assign("page", $page);
        $list = $select->select();
        foreach ($list as $key=>$val) {
            $tag_list = unserialize($val['tag_cache']);
            $val['tags'] = implode('、', $tag_list);
            $list[$key] = $val;
        }
		
		
        $this->assign('list', $list);
        $this->display();
    }
    public function check1() {
        $map=array();
        $map['status']=0;
        $count = $this->_mod->where($map)->count('id');
        $this->ajaxReturn(1,$count);
        exit;
    }
    public function check_count(){
        $map=array();
        $map['status']=0;
        $select = $this->_mod->where($map)->count();
        $this->ajaxReturn(1, '', $select);
    }
	public function set_score(){
		$id = $this->_get('id','intval');
        $time = $this->_get('add_time');
        $add_time='';
        if($time){
            $add_time= strtotime($time);
        }
		$this->assign('id',$id);
        $this->assign('add_time',$add_time);
		$this->assign('min_score',5);
		$response = $this->fetch();
		$this->ajaxReturn(1, '', $response);
	}
	public function check_done(){
		$id = $this->_post('id','intval');
		$score = $this->_post('score','intval');
		$coin = $this->_post('coin','intval');
		$exp = $this->_post('exp','intval');
		$offer = $this->_post('offer','intval');
        $add_time = $this->_post('add_time','intval');
		$score=($score)?$score:5;
		$coin=($coin)?$coin:5;
		$exp=($exp)?$exp:5;
		$offer=($offer)?$offer:5;
		$item = M('item')->where("id=$id")->find();	
		$datas['id']=$id;
        $datas['status']=1;
		$datas['sh_time']=time();
        if($add_time<time()){
            $datas['add_time']=time();
        }else{
            $datas['add_time']=$add_time;
        }

         if($datas['add_time']  > $datas['sh_time'] ){
            $datas['sh_time']  = $datas['add_time'];
        }

		if($item){
			if(false !== M("item")->save($datas)){
                                            $item = M("item")->where(array('id'=>$id))->find();
                                            if($item['isbao']==1){
                                                
                                                $diu_item['diu_id']= $item['id'];
                                                $diu_item['orig_id'] = $item['orig_id'];
                                                $diu_item['cate_id'] = $item['cate_id'];
                                                $diu_item['uid'] = $item['uid'];
                                                $diu_item['uname'] = $item['uname'];
                                                $diu_item['status'] = $item['status'];
                                                $diu_item['isbao'] = $item['isbao'];
                                                $diu_item['zan'] = rand(0,5);
                                                if($data['add_time']==0){
                                                      $diu_item['add_time'] = time();
                                                }
                                                else{
                                                    $diu_item['add_time'] = $item['add_time'];
                                                }
                                                
                                                $diu_item['url'] = $item['url'];
                                                $diu_item['go_link'] = $item['go_link'];
                                                $diu_item['img'] = $item['img'];
                                                $diu_item['title'] = $item['title'];
                                                $diu_item['content'] = $item['content'];
                                                $diu_item['intro'] = $item['intro'];
                                                M("item_diu")->add($diu_item);
                                            }

				if($item['uid']>0){
					$user = M('user')->where("id=$item[uid]")->find();
					//设置积分
					set_score($user,"$score","$coin","$offer","$exp");
					//积分日志
					set_score_log($user,'publish_item',"$score","$coin","$offer","$exp");
                    $xc = array();
                    $xc['ftid']=$user['id'];
                    $xc['to_id']=$user['id'];
                    $xc['to_name']=$user['username'];
                    $xc['from_id']=0;
                    $xc['from_name']='tryine';
                    $xc['add_time']=time();
                    $xc['info'] ='您的爆料>><a href="'.U('home/item/index',array('id'=>$item['id'])).'">'.$item['title'].'</a>通过审核，感谢您的爆料,系统给您奖励积分：'.$score.'，金币：'.$coin.'，贡献值：'.$offer.'，经验：'.$exp.'.';
                    M('message')->add($xc);
				}
				IS_AJAX && $this->ajaxReturn(1, L('operation_success'),'', 'edit');
			}else {
                IS_AJAX && $this->ajaxReturn(0, L('operation_failure'),'', 'edit');
            }			
		} else {
            IS_AJAX && $this->ajaxReturn(0, L('illegal_parameters'),'', 'edit');
        }
	}
    /**
     * 审核操作
     */
    public function do_check() {
        $mod = D($this->_name);
        $pk = $mod->getPk();
        $ids = trim($this->_request($pk), ',');
        $datas['id']=array('in',$ids);
        $datas['status']=1;
		$datas['sh_time']=time();
        if ($datas) {
            if (false !== $mod->save($datas)) {
                IS_AJAX && $this->ajaxReturn(1, L('operation_success'));
            } else {
                IS_AJAX && $this->ajaxReturn(0, L('operation_failure'));
            }
        } else {
            IS_AJAX && $this->ajaxReturn(0, L('illegal_parameters'));
        }

    }

    /**
     * 退回操作
     */
    public function tuihui() {
        $id=$this->_get('id','intval');
        M('item')->where(array('id'=>$id))->setField('status', '3');
        $this->success(L('operation_success'),U('item/index'));
    }

    /**
     * ajax获取标签
     */
    public function ajax_gettags() {
        $title = $this->_get('title', 'trim');
        $tag_list = D('tag')->get_tags_by_title($title);
        $tags = implode('、', $tag_list);
        $this->ajaxReturn(1, L('operation_success'), $tags);
    }

    public function ajax_getfromurl() {
        $url = $this->_get('url', 'trim');
         $pattern = '/(\d{4,})/';
        $pattern_num = preg_match($pattern,$url,$pattern_result);
             if($pattern_num!=0){
                  $item_id =$pattern_result[1];
             }
             else{
                    $item_id = -1;
             }
          $items = M('item')->where("id =" . $item_id )->select();
          $result = array();
        if(count($items)==0){
            $result['status'] = -1;
             $this->ajaxReturn(0, L('getfromurl_failure'));
        }
        else{
              $result['status'] =1;
              $result['cate_id'] = (int)$items[0]['cate_id'];
              $result['title'] = $items[0]['title'];
              $result['otitle'] = $items[0]['otitle'];
              $result['intro'] = $items[0]['intro'];
              $result['img'] = $items[0]['img'];
              $go_link = unserialize($items[0]['go_link']);
              if(isset($go_link[0]['link'])){
              $result['go_link'] = $go_link[0]['link'];
              }
              elseif(isset($go_link[1]['link'])){
              $result['go_link'] = $go_link[1]['link'];
              }
              else{
                $result['go_link'] ="";
              }
              $tag_cache = unserialize($items[0]['tag_cache']);
              $result['tag_cache'] = implode('、', $tag_cache);
              $result['price'] = $items[0]['price'];
              $result['orig_id'] = $items[0]['orig_id'];
              $result['content'] = $items[0]['content'];
            $this->ajaxReturn(1, L('operation_success'), $result);
        }
      
    }

    public function ajax_smid() {
        $url = $this->_get('url', 'trim');
         $result['id'] =1;
        $parsed_url = parse_url($url);
        $host = $parsed_url['host'];

        if (strcmp($host,'www.amazon.com')==0 && substr_count(strtolower($url),'&smid=')<1){

            $result['convert_url'] =$url . "&smid=ATVPDKIKX0DER";

        }
         elseif (strcmp($host,'www.amazon.cn')==0  && substr_count(strtolower($url),'&smid=')<1){
              $result['convert_url'] =$url . "&smid=A1AJ19PSB66TGU";
           
        }
        else{
              $result['convert_url'] =$url;
              $result['id'] =-1;
          }
        
        $this->ajaxReturn(1, L('operation_success'),  $result);
    }


    public function ajax_converturl() {
        $url = $this->_get('url', 'trim');
        $parsed_url = parse_url($url);
        $host = $parsed_url['host'];
         $result = array();

        if (empty($host) or substr_count(strtolower($url),'http')>=2){
              $result['convert_url'] =$url;
              $result['id'] =-1;
               $this->ajaxReturn(1, L('operation_success'),  $result);
          }
        if (strcmp($host,'www.amazon.com')==0){
            $result['id'] =493;
            $pattern = '/product\/(([a-zA-Z]|\d){10})/';
           $pattern_num = preg_match($pattern,$parsed_url['path'],$pattern_result);
             if($pattern_num!=0){
                  $result['convert_url'] = 'https://www.amazon.com/dp/' . $pattern_result[1] . '?t=' . $_SESSION['admin']['us_amazon'] . '&tag=' . $_SESSION['admin']['us_amazon'];
             }
         else{
           $pattern1 = '/dp\/(([a-zA-Z]|\d){10})/';
           $pattern_num1 = preg_match($pattern1,$parsed_url['path'],$pattern_result);
             if($pattern_num1!=0){
                 $result['convert_url'] = 'https://www.amazon.com/dp/' . $pattern_result[1] . '?t=' . $_SESSION['admin']['us_amazon'] . '&tag=' . $_SESSION['admin']['us_amazon'];
             }
             else{
                    $pattern2 = '/creativeASIN=(([a-zA-Z]|\d){10})/';
                    $pattern_num2 = preg_match($pattern2, $url,$pattern_result);

                 if($pattern_num2!=0){
                     $result['convert_url'] = 'https://www.amazon.com/dp/' . $pattern_result[1] . '?t=' . $_SESSION['admin']['us_amazon'] . '&tag=' . $_SESSION['admin']['us_amazon'];
                 }
                 else{
                    $result['convert_url'] =$url;
                 }
             }
           }
        }
         elseif (strcmp($host,'www.amazon.cn')==0){
            $result['id'] =2;
            $pattern = '/product\/(([a-zA-Z]|\d){10})/';
           $pattern_num = preg_match($pattern,$parsed_url['path'],$pattern_result);
             if($pattern_num!=0){
                  $result['convert_url'] = 'https://www.amazon.cn/dp/' . $pattern_result[1] . '?t=' . $_SESSION['admin']['ch_amazon'] . '&tag=' . $_SESSION['admin']['ch_amazon'];
             }
         else{
           $pattern1 = '/dp\/(([a-zA-Z]|\d){10})/';
           $pattern_num1 = preg_match($pattern1,$parsed_url['path'],$pattern_result);
             if($pattern_num1!=0){
                 $result['convert_url'] = 'https://www.amazon.cn/dp/' . $pattern_result[1] . '?t=' . $_SESSION['admin']['ch_amazon'] . '&tag=' . $_SESSION['admin']['ch_amazon'];
             }
             else{
                    $pattern2 = '/creativeASIN=(([a-zA-Z]|\d){10})/';
                    $pattern_num2 = preg_match($pattern2, $url,$pattern_result);

                 if($pattern_num2!=0){
                     $result['convert_url'] = 'https://www.amazon.cn/dp/' . $pattern_result[1] . '?t=' . $_SESSION['admin']['ch_amazon'] . '&tag=' . $_SESSION['admin']['ch_amazon'];
                 }
                 else{
                    $result['convert_url'] =$url;
                 }
             }
           }
           
        }
        elseif (strcmp($host,'www.amazon.co.jp')==0){
            $result['id'] =49;
            $pattern = '/product\/(([a-zA-Z]|\d){10})/';
           $pattern_num = preg_match($pattern,$parsed_url['path'],$pattern_result);
             if($pattern_num!=0){
                  $result['convert_url'] = 'http://count.chanet.com.cn/click.cgi?a=524082&d=381499&u=' . $_SESSION['admin']['sid'] . '&e=&url=https://www.amazon.co.jp/dp/'. $pattern_result[1] ;
             }
         else{
           $pattern1 = '/dp\/(([a-zA-Z]|\d){10})/';
           $pattern_num1 = preg_match($pattern1,$parsed_url['path'],$pattern_result);
             if($pattern_num1!=0){
                 $result['convert_url'] = 'http://count.chanet.com.cn/click.cgi?a=524082&d=381499&u=' . $_SESSION['admin']['sid'] . '&e=&url=https://www.amazon.co.jp/dp/'. $pattern_result[1] ;
             }
             else{
                    $pattern2 = '/creativeASIN=(([a-zA-Z]|\d){10})/';
                    $pattern_num2 = preg_match($pattern2, $url,$pattern_result);

                 if($pattern_num2!=0){
                     $result['convert_url'] = 'http://count.chanet.com.cn/click.cgi?a=524082&d=381499&u=' . $_SESSION['admin']['sid'] . '&e=&url=https://www.amazon.co.jp/dp/'. $pattern_result[1] ;
                 }
                 else{
                    $result['convert_url'] =$url;
                 }
             }
           }
           
        }elseif (strcmp($host,'uland.taobao.com')==0){
            $result['id'] =3;
            $parsed_orig_url = parse_url($url);
             parse_str($parsed_orig_url['query'],$parsed_orig_query);
             if(isset($parsed_orig_query['activityId']) &&isset($parsed_orig_query['itemId']) ){
                 $result['convert_url'] =  "https://uland.taobao.com/coupon/edetail?activityId=" . $parsed_orig_query['activityId'] . "&itemId=" . $parsed_orig_query['itemId'] . "&pid=" . $_SESSION['admin']['mm_pid']. "&dx=1";
             }
             else{
                  $result['convert_url'] =  $url;
             }
        }
         elseif (strcmp($host,'www.kaixinbao.com')==0 || strcmp($host,'u.kaixinbao.com')==0){
            $result['id'] =942;
            $pattern = '/-baoxian\/((\d){6,}).shtml/';
           $pattern_num = preg_match($pattern,$parsed_url['path'],$pattern_result);
             if($pattern_num!=0){
                  $result['convert_url'] = "http://u.kaixinbao.com/link?aid=" . $pattern_result[1] . "&cpsUserId=a105930&cpsUserSource=8_swpt";
             }
             else{
                 $result['convert_url'] = $url;
             }
        }
        else{
               $origs = M('item_orig')->where("url like '%" . $host . "%'")->Field('url ,id')->select();
                if(count($origs)!=0){
                     $result['id'] =$origs[0]['id'];
                     $orig_url = $origs[0]['url'];
                     $parsed_orig_url = parse_url($orig_url);
                      parse_str($parsed_orig_url['query'],$parsed_orig_query);
                       if(stripos($orig_url, 'sid=SS') !==false){
                             $parsed_orig_query['sid']=$_SESSION['admin']['sid'];
                        }
                        elseif(stripos($orig_url, 'sid=lh_m1nyfc__SS') !==false){
                             $parsed_orig_query['sid']='lh_m1nyfc__' . $_SESSION['admin']['sid'];
                        }
                         elseif(stripos($orig_url, 'euid=SS') !==false){
                             $parsed_orig_query['euid']=$_SESSION['admin']['sid'];
                        }
                        elseif(stripos($orig_url, 'u=SS') !==false){
                             $parsed_orig_query['u']=$_SESSION['admin']['sid'];
                        }
                         elseif(stripos($orig_url, 'e=SS') !==false){
                             $parsed_orig_query['e']=$_SESSION['admin']['sid'];
                        }
                        elseif(stripos($orig_url, 'sid/SS/') !==false){
                             $parsed_orig_url['path']=str_replace('sid/SS/','sid/' . $_SESSION['admin']['sid'] . '/',$parsed_orig_url['path']);
                        }
                        else{
                             $parsed_orig_query['tag']=$_SESSION['admin']['sid'];
                        }

                        if(isset($parsed_orig_query['url'])){
                            $parsed_orig_query['url'] = $url;
                        }
                        elseif(isset($parsed_orig_query['new'])){
                            $parsed_orig_query['new'] = $url;
                        }
                        elseif(isset($parsed_orig_query['t'])){
                            $parsed_orig_query['t'] = $url;
                        }
                        $parsed_orig_url['query'] = http_build_query($parsed_orig_query);
                        $parsed_orig_url['query']= urldecode($parsed_orig_url['query']);
                           $result['convert_url'] =   $this->http_build_url($parsed_orig_url);
                }
              
        }
        
        if( count($result)==0){
              $result['convert_url'] =$url;
              $result['id'] =-1;
          }
        
        $this->ajaxReturn(1, L('operation_success'),  $result);
    }

    public function http_build_url($url_arr){
        $new_url = $url_arr['scheme'] . "://".$url_arr['host'];
        if(!empty($url_arr['port']))
            $new_url = $new_url.":".$url_arr['port'];
        $new_url = $new_url . $url_arr['path'];
        if(!empty($url_arr['query']))
            $new_url = $new_url . "?" . $url_arr['query'];
        if(!empty($url_arr['fragment']))
            $new_url = $new_url . "#" . $url_arr['fragment'];
        return $new_url;
    }

    public function delete_search() {
        $items_mod = D('item');
        $items_cate_mod = D('item_cate');
        $items_likes_mod = D('item_like');
        $items_pics_mod = D('item_img');
        $items_tags_mod = D('item_tag');
        $items_comments_mod = D('item_comment');

        if (isset($_REQUEST['dosubmit'])) {
            if ($_REQUEST['isok'] == "1") {
                //搜索
                $where = '1=1';
                $keyword = trim($_POST['keyword']);
                $cate_id = trim($_POST['cate_id']);
                $cate_id = trim($_POST['cate_id']);
                $time_start = trim($_POST['time_start']);
                $time_end = trim($_POST['time_end']);
                $status = trim($_POST['status']);
                $min_price = trim($_POST['min_price']);
                $max_price = trim($_POST['max_price']);
                $min_rates = trim($_POST['min_rates']);
                $max_rates = trim($_POST['max_rates']);

                if ($keyword != '') {
                    $where .= " AND title LIKE '%" . $keyword . "%'";
                }
                if ($cate_id != ''&&$cate_id!=0) {
                    $where .= " AND cate_id=" . $cate_id;
                }
                if ($time_start != '') {
                    $time_start_int = strtotime($time_start);
                    $where .= " AND add_time>='" . $time_start_int . "'";
                }
                if ($time_end != '') {
                    $time_end_int = strtotime($time_end);
                    $where .= " AND add_time<='" . $time_end_int . "'";
                }
                if ($status != '') {
                    $where .= " AND status=" . $status;
                }
                if ($min_price != '') {
                    $where .= " AND price>=" . $min_price;
                }
                if ($max_price != '') {
                    $where .= " AND price<=" . $max_price;
                }
                if ($min_rates != '') {
                    $where .= " AND rates>=" . $min_rates;
                }
                if ($max_rates != '') {
                    $where .= " AND rates<=" . $max_rates;
                }
                $ids_list = $items_mod->where($where)->select();
                $ids = "";
                foreach ($ids_list as $val) {
                    $ids .= $val['id'] . ",";
                }
                if ($ids != "") {
                    $ids = substr($ids, 0, -1);
                    $items_likes_mod->where("item_id in(" . $ids . ")")->delete();
                    $items_pics_mod->where("item_id in(" . $ids . ")")->delete();
                    $items_tags_mod->where("item_id in(" . $ids . ")")->delete();
                    $items_comments_mod->where("item_id in(" . $ids . ")")->delete();
                    M('album_item')->where("item_id in(" . $ids . ")")->delete();
                    M('item_attr')->where("item_id in(" . $ids . ")")->delete();

                }
                $items_mod->where($where)->delete();

                //更新商品分类的数量
                $items_nums = $items_mod->field('cate_id,count(id) as items')->group('cate_id')->select();
                foreach ($items_nums as $val) {
                    $items_cate_mod->save(array('id' => $val['cate_id'], 'items' => $val['items']));
                    M('album')->save(array('cate_id' => $val['cate_id'], 'items' => $val['items']));
                }

                $this->success('删除成功', U('item/delete_search'));
            } else {
                $this->success('确认是否要删除？', U('item/delete_search'));
            }
        } else {
            $res = $this->_cate_mod->field('id,name')->select();

            $cate_list = array();
            foreach ($res as $val) {
                $cate_list[$val['id']] = $val['name'];
            }
            $this->assign('cate_list', $cate_list);
            $this->display();
        }
    }
	
	
	//导入会员表数据
	public function inser_user(){
		$user_Model=M('wp_users');
		$user=M('user');
		$users = $user_Model->where(array('id>0'))->select();
		$userCount = $user_Model->count();
		for($i=0;$i<$userCount;$i++){
			$data["uc_uid"] = 0;
			if($i%2==0){
			  $data["gender"] = 0;
			}else{
			  $data["gender"] = 1;
			}
			$data["tags"] = '';
			$data["intro"] = '';
			$data["byear"] = 0;
			$data["bmonth"] = 0;
			$data["bday"] = 0;
			$data["province"] = 0;
			$data["city"] = 0;
			$data["score"] = 0;
			$data["score_level"] = 0;
			$data["cover"] = 0;
			$data["reg_ip"] = 0;
			$data["reg_time"] = 1487143777;
			$data["last_time"] = '1487143797';
			$data["last_ip"] = '192.168.1.23';
			$data["status"] = 1;
			$data["shares"] = 0;
			$data["likes"] = 0;
			$data["follows"] = 0;
			$data["fans"] = 0;
			$data["albums"] = 0;
			$data["daren"] = 0;
			$data["zipcode"] = '';
			$data["mobile"] = 0;
			$data["sign_date"] = 0;
			$data["sign_num"] = 0;
			$data["exp"] = 0;
			$data["coin"] = 0;
			$data["offer"] = 0;
			$data["all_sign"] = 0;
			$data["is_avator"] = 0;
			$data["is_bj"] = 0;
			$data["crop"] = '';
			$data["follw"] = 1;
			
			$data["username"] = $users[$i]['user_login'];
			$data["password"] = $users[$i]['user_pass'];
			$data["email"]    = $users[$i]['user_email'];	
			$data["realname"] = $users[$i]['display_name'];
			// 写入数据
			if($lastInsId = $user->add($data)){
				echo "插入数据 id 为：$lastInsId";
			} else {
				$this->error('数据写入错误！');
			}
			
		}
		 // 写入数据
		if($lastInsId = $user_Model->add($data)){
			echo "插入数据 id 为：$lastInsId";
		} else {
			$this->error('数据写入错误！');
		}
	}
}