<?php
class daoAction extends frontendAction{
	public function index(){
		//导入用户表
		//$sql = "insert into try_user(id,username,password,email,reg_time,realname) select id,user_login,user_pass,user_email,user_registered,display_name from try_zzusers";
		//M()->query($sql);
		//导入主体数据
		//$sql = "select id,post_author,post_date,post_title,post_content from try_zposts where  limit 1";
		//$list = M("zzposts")->field("id,post_author,post_date,post_title,post_content")->where("post_type='post' and post_status='publish' and id=48")->limit(1)->select();
		// foreach($list as $key=>$val){
			// $data=array();
			// $data['id']=$val['id'];
			// $data['uid']=$val['post_author'];
			// $data['add_time']=strtotime($val['post_date']);
			// $data['title']=$val['post_title'];
			// $data['content']=$val['post_content'];
			// M("item")->add($data);
			// echo $data['id']."|<br>";
		// }
		$model = M();
		$user_mod = M("user");
		$item_mod = M("item");
		$go_mod = M("zzpostmeta");
		$post_mod = M("zzposts");
		$item_cate = M("item_cate");
		$orig_mod = M("item_orig");
		$map[1]=1;
		//$map['id']=143832;
		//$list = $item_mod->where($map)->select();
		//foreach($list as $key=>$val){
		//	$data=array();			
		//	$data['id']=$val['id'];
			//整合用户数据
			//$data['uname']=$user_mod->where("id=$val[uid]")->getField("username");
			//简介
			//$data['intro'] = msubstr(strip_tags($val['content']),0,100,false);
			//直达链接
			//$data['go_link'] = $go_mod->where("post_id=$val[id] and meta_key='_goumai_link'")->getField("meta_value");
			//$data['go_link'] = unserialize($data['go_link']);
			//首图
		//	preg_match('/<img.+src=\"?(.+\.(jpg|gif|bmp|bnp|png))\"?.+>/i',$val['content'],$match); 
		//	$data['img'] = $match[1];
		//	$r = $item_mod->save($data);
		//}
		//商城分类
		// $orig = M()->query("select distinct meta_value from try_zzpostmeta where meta_key='_shangcheng_link'");
		// foreach($orig as $key=>$val){
			// $data=unserialize(unserialize($val['meta_value']));
			// //查找是否存在
			// $ischeck = $orig_mod->where("name=$data[name]")->find();
			// if($data['name']!="" && empty($ischeck)){
				// $orig_mod->add($data);
			// }
		// }
		//把信息商城分类
		// $item_orig = $orig_mod->select();
		// foreach($item_orig as $key=>$val){
			// $sql = "update try_item set orig_id=$val[id] where title like '%$val[name]%' or content like '%$val[name]%' ";
			// $model->query($sql);
		// }
		//栏目归类
		//$sql = "update try_item set cate_id='1' where id in (select object_id from try_zzterm_relationships where term_taxonomy_id='2417')";//鞋服内衣
		//$sql = "update try_item set cate_id='50' where id in (select object_id from try_zzterm_relationships where term_taxonomy_id='2418')";//鞋包服饰
		//$sql = "update try_item set cate_id='102' where id in (select object_id from try_zzterm_relationships where term_taxonomy_id='2425')";//运动户外
		//$sql = "update try_item set cate_id='114' where id in (select object_id from try_zzterm_relationships where term_taxonomy_id='2426')";//珠宝手表
		//$sql = "update try_item set cate_id='115' where id in (select object_id from try_zzterm_relationships where term_taxonomy_id='2422')";//母婴玩具
		//$sql = "update try_item set cate_id='116' where id in (select object_id from try_zzterm_relationships where term_taxonomy_id='2424')";//手机数码
		//$sql = "update try_item set cate_id='333' where id in (select object_id from try_zzterm_relationships where term_taxonomy_id='2419')";//护肤用品
		//$sql = "update try_item set cate_id='334' where id in (select object_id from try_zzterm_relationships where term_taxonomy_id='2420')";//保健养生
		//$sql = "update try_item set cate_id='335' where id in (select object_id from try_zzterm_relationships where term_taxonomy_id='2421')";//日用百货
		//$sql = "update try_item set cate_id='336' where id in (select object_id from try_zzterm_relationships where term_taxonomy_id='2423')";//图书音像
		//$sql = "update try_item set cate_id='337' where id in (select object_id from try_zzterm_relationships where term_taxonomy_id='2428')";//食品酒饮
		//$r=$model->query($sql);
		//编辑推荐属性
		//$sql = "update try_item set isnice = 1 where uid=2";
		//爆料属性
		//$sql = "update try_item set isbao = 1 where uid<>2";
		//$r=$model->query($sql);
		//标签
		 $item_list = $item_mod->where("go_link<>'0'")->select();
		 foreach($item_list as $key=>$val){
			$data['id']=$val['id'];
			//$sql = "select name from try_zzterms where term_id in (select term_id from try_zzterm_taxonomy as t left join try_zzterm_relationships as r on r.term_taxonomy_id=t.term_taxonomy_id where object_id=$val[id] and t.taxonomy='post_tag')";
			// $data_name = $model->query($sql);
			//标签
			// $data["tag_cache"]=serialize($this->arraytoarray($data_name,'name'));
			//内容加<p>
			// $con = explode("\n",$val['content']);
			// $content = "";
			// foreach($con as $v){
				// if($v<>""){
					// $content .="<p>".$v."</p>";
				// }
			// }
			// $data['content']=$content;
			$go_link = unserialize($val['go_link']);
			$i=1;
			foreach($go_link as $key=>$val){
				if($i==1){
					$data["url"]=$val['link'];
				}
			}
			$r = $item_mod->save($data);
			}
		echo "4";die();
	}
	//二维数组转一维
	public function arraytoarray($arr,$kst){
		$akr = array();
		foreach($arr as $key=>$val){
			$akr[] = $val[$kst];
		}
		return $akr;
	}
}
?>