<?php
class rssAction extends frontendAction {
    public function index() {
	   header("Content-type: application/xml");
	   $time_e =time();
	   $time_s = $time_e -60*60*24;
	   $list = M()->query("select i.*,c.name as catname from try_item as i left join try_item_cate as c on i.cate_id=c.id where i.status=1 and i.add_time>$time_s and i.add_time<$time_e  order by add_time desc limit 50");
	   $string ='<?xml version="1.0" encoding="UTF-8"?>';
	   $string .= '<rss version="2.0"
			xmlns:content="http://purl.org/rss/1.0/modules/content/"
			xmlns:wfw="http://wellformedweb.org/CommentAPI/"
			xmlns:dc="http://purl.org/dc/elements/1.1/"
			xmlns:atom="http://www.w3.org/2005/Atom"
			xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
			xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
			>';
	  $string .='<channel>';
	  $string .= '<title>白菜哦-高性价比海淘购物推荐 &#187; -白菜哦-高性价比海淘购物推荐</title>
		<atom:link href="http://www.baicaio.com/feed" rel="self" type="application/rss+xml" />
		<link>http://www.baicaio.com</link>
		<description>海淘教程,网上购物,海外购,优惠券,特价,打折,亚马逊优惠信息,转运</description>
		<lastBuildDate>'.gmstrftime("%a, %d %b %Y %T %Z",time()).'</lastBuildDate>
		<language>zh-CN</language>
		<sy:updatePeriod>hourly</sy:updatePeriod>
		<sy:updateFrequency>1</sy:updateFrequency>
		<generator>http://wordpress.org/?v=4.2.5</generator>';
	  foreach($list as $key=>$val){
		  $string .= '<item>';
		  $string .= '<title><![CDATA['.$val['title'].']]></title>';
		  $string .= '<link>http://'.$_SERVER['HTTP_HOST'].U('item/index',array('id'=>$val['id'])).'</link>';
		  $string .= '<comments>http://'.$_SERVER['HTTP_HOST'].U('item/index',array('id'=>$val['id'])).'#comments</comments>';
		  $string .= '<pubDate>'.gmstrftime("%a, %d %b %Y %T %Z",$val['add_time']).'</pubDate>';
		  $string .= '<dc:creator><![CDATA['.$val['uname'].']]></dc:creator>';
		  $string .= '<category><![CDATA['.$val['catname'].']]></category>';
		  $string .= '<guid isPermaLink="false">http://'.$_SERVER['HTTP_HOST'].U('item/index',array('id'=>$val['id'])).'</guid>';
		  $string .= '<description><![CDATA['.$val['intro'].']]></description>';
		  $string .= '<content:encoded><![CDATA['.$val['content'].']]></content:encoded>';
		  $string .= '<slash:comments>0</slash:comments>';
		  $string .= '</item>';
	  }
	  $string .='</channel>';
	  $string .='</rss>';
	  echo $string;
    }
}
?>