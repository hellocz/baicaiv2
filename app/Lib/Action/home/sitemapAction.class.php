<?php
class sitemapAction extends frontendAction {    
    public function index() {
		$this->assign("page_seo",set_seo('网站地图'));
        $this->display();
    }

    public function xml(){
		header("Content-type: application/xml");
	   
	   $string ='<?xml version="1.0" encoding="UTF-8" ?>
	   <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
	   $string .='<url>
<loc>http://www.baicaio.com/</loc>
<lastmod>' . date("Y-m-d") . '</lastmod>
<changefreq>always</changefreq> 
<priority>1</priority>
</url>';
	$string .='<url>
<loc>http://www.baicaio.com/topics/gny/1/</loc>
<lastmod>' . date("Y-m-d") . '</lastmod>
<changefreq>always</changefreq> 
<priority>0.9</priority>
</url>
<url>
<loc>http://www.baicaio.com/topics/gny/0/</loc>
<lastmod>' . date("Y-m-d") . '</lastmod>
<changefreq>always</changefreq> 
<priority>0.9</priority>
</url>
<url>
<loc>http://www.baicaio.com/baicai/</loc>
<lastmod>' . date("Y-m-d") . '</lastmod>
<changefreq>always</changefreq> 
<priority>0.9</priority>
</url>
<url>
<loc>http://www.baicaio.com/tag/9.9%E5%8C%85%E9%82%AE</loc>
<lastmod>' . date("Y-m-d") . '</lastmod>
<changefreq>always</changefreq> 
<priority>0.9</priority>
</url>';
	$cate_levelones = M("item_cate")->field('id,pid,spid,cate_html')->where("pid=0 and spid=0")->order("id asc")->select();
	$levelone_ids = array();
	foreach ($cate_levelones as $cate_levelone) {
		if(empty($cate_levelone['cate_html'])){
			$url = 'http://www.baicaio.com/topics/c' .  $cate_levelone['id'];
		}
		else{
			$url = 'http://www.baicaio.com/topics/' .  $cate_levelone['cate_html'];
		}
		$string .= '<url>
<loc>' . $url . '</loc>
<lastmod>' . date("Y-m-d") . '</lastmod>
<changefreq>always</changefreq> 
<priority>0.9</priority>
</url>';
	array_push($levelone_ids,$cate_levelone['id']);
	}

	$leveltwo_where['pid'] = array('IN',$levelone_ids);
	$leveltwo_ids = array();
	$cate_leveltwos = M("item_cate")->field('id')->where($leveltwo_where)->order("id asc")->select();
	foreach ($cate_leveltwos as $cate_leveltwo) {
		$url = 'http://www.baicaio.com/topics/c' .  $cate_leveltwo['id'];
		$string .= '<url>
<loc>' . $url . '</loc>
<lastmod>' . date("Y-m-d") . '</lastmod>
<changefreq>always</changefreq> 
<priority>0.8</priority>
</url>';
	array_push($leveltwo_ids,$cate_leveltwo['id']);
	}

	$levelthree_where['pid'] = array('IN',$leveltwo_ids);
	$cate_levelthrees = M("item_cate")->field('id')->where($levelthree_where)->order("id asc")->select();
	foreach ($cate_levelthrees as $cate_levelthree) {
		$url = 'http://www.baicaio.com/topics/c' .  $cate_levelthree['id'];
		$string .= '<url>
<loc>' . $url . '</loc>
<lastmod>' . date("Y-m-d") . '</lastmod>
<changefreq>always</changefreq> 
<priority>0.7</priority>
</url>';
	}

	$time_e = time();
	$time_s = $time_e -60*60*24*7;
	$item_list = M("item")->field('id')->where("add_time<$time_e and add_time>$time_s and status=1")->order("add_time desc")->select();
	foreach ($item_list as $item) {
		$url = 'http://www.baicaio.com/item/' .  $item['id'] . '.html';
		$string .= '<url>
<loc>' . $url . '</loc>
<lastmod>' . date("Y-m-d") . '</lastmod>
<changefreq>yearly</changefreq> 
<priority>0.6</priority>
</url>';
	}
	$article_list = M("article")->field('id')->where("add_time<$time_e and add_time>$time_s and status=1")->order("add_time desc")->select();
	foreach ($article_list as $article) {
		$url = 'http://www.baicaio.com/article/' .  $article['id'] . '.html';
		$string .= '<url>
<loc>' . $url . '</loc>
<lastmod>' . date("Y-m-d") . '</lastmod>
<changefreq>yearly</changefreq> 
<priority>0.6</priority>
</url>';
	}


	  $string .='</urlset>';
	  echo $string;
    }
}