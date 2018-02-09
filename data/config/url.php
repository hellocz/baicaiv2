<?php
return array(
    'URL_MODEL' => 2,
    'URL_HTML_SUFFIX' => '',
    'URL_PATHINFO_DEPR' => '-',
    'URL_ROUTER_ON' => true,
    'URL_ROUTE_RULES' =>
        array(



            '/^topics\/$/' => 'book/index',
            '/^topics\/p(\d+)$/' => 'book/index?p=:1',
            '/^topics\/c(\d+)\/$/' => 'book/cate?cid=:1',
			
			//分类
			'/^topics\/ghhz\/$/' => 'book/cate?cid=333',  //个护化妆 
			'/^topics\/bjys\/$/' => 'book/cate?cid=334',  //保健养生  
			'/^topics\/tsyx\/$/' => 'book/cate?cid=336',  //图书音像  
			'/^topics\/smjd\/$/' => 'book/cate?cid=116',  //数码家电  
			'/^topics\/lyxx\/$/' => 'book/cate?cid=338',  //旅游休闲  
			'/^topics\/rybh\/$/' => 'book/cate?cid=335',  //日用百货  
			'/^topics\/fzxm\/$/' => 'book/cate?cid=1',    //服装鞋帽  
			'/^topics\/mywj\/$/' => 'book/cate?cid=115',  //母婴玩具  
			'/^topics\/dyzx\/$/' => 'book/cate?cid=339',  //电影资讯  
			'/^topics\/yzps\/$/' => 'book/cate?cid=340',  //眼镜配饰  
			'/^topics\/xbsd\/$/' => 'book/cate?cid=50',   //箱包手袋  
			'/^topics\/ydhw\/$/' => 'book/cate?cid=102',  //运动户外  
			'/^topics\/zbss\/$/' => 'book/cate?cid=114',  //钟表首饰  
			'/^topics\/spjy\/$/' => 'book/cate?cid=337',  //食品酒饮  
			'/^topics\/zqzb\/$/' => 'book/cate?cid=341',  //杂七杂八  
		    '/^topics\/notice\/$/' => 'book/cate?cid=342',//活动公告  
            '/^topics\/finance\/$/' => 'book/cate?cid=349',//活动公告  
                                '/^topics\/oversea-guide\/$/' =>'article/index?id=9',
			//END
			
            '/^topics\/c(\d+)\/p(\d+)$/' => 'book/cate?cid=:1&p=:2',
            '/^topics\/gny\/(\d+)\/$/' => 'book/gny?tp=:1',
            '/^topics\/gny\/(\d+)\/p(\d+)$/' => 'book/gny?tp=:1&p=:2',
            '/^topics\/gny\/(\d+)\/isbao(\d+)$/' => 'book/gny?tp=:1&isbao=:2',
            '/^topics\/gny\/(\d+)\/isbao(\d+)\/p(\d+)$/' => 'book/gny?tp=:1&isbao=:2&p=:3',
            '/^topics\/gny\/(\d+)\/isnice(\d+)$/' => 'book/gny?tp=:1&isnice=:2',
            '/^topics\/gny\/(\d+)\/isnice(\d+)\/p(\d+)$/' => 'book/gny?tp=:1&isnice=:2&p=:3',
            '/^topics\/gny\/(\d+)\/(\S+)\/(\S+)\/isnice(\d+)$/' => 'book/gny?tp=:1&tab=:2&dss=:3&isnice=:4',
            '/^topics\/gny\/(\d+)\/(\S+)\/(\S+)\/isnice(\d+)\/p(\d+)$/' => 'book/gny?tp=:1&tab=:2&dss=:3&isnice=:4&p=:5',
            '/^topics\/gny\/(\d+)\/(\S+)\/(\S+)\/isbao(\d+)$/' => 'book/gny?tp=:1&tab=:2&dss=:3&isbao=:4',
            '/^topics\/gny\/(\d+)\/(\S+)\/(\S+)\/isbao(\d+)\/p(\d+)$/' => 'book/gny?tp=:1&tab=:2&dss=:3&isbao=:4&p=:5',
            '/^topics\/best$/' => 'book/best',

        //分类
           

            '/^article\/(\d+).html$/' => 'article/show?id=:1',
            '/^zr\/(\d+).html$/' => 'zr/show?id=:1',
            '/^zr\/$/' => 'zr/index',
            '/^zr\/p(\d+)$/' => 'zr/index?p=:1',
            '/^zr\/c(\d+)$/' => 'zr/index?id=:1',
            '/^zr\/c(\d+)\/p(\d+)$/' => 'zr/index?id=:1&p=:2',
            '/^item\/(\d+).html$/' => 'item/index?id=:1',
            '/^bao\/(\d+).html$/' => 'bitem/index?isbao=1&id=:1',
            '/^tag\/(\S+)$/' => 'book/index?tag=:1',
            '/^p\/(\d+)\/tag\/(\S+)$/' => 'book/index?p=:1&tag=:2',
            '/^topics\/oversea-guide\/p(\d+)$/' => 'article/index?id=9&p=:1',
            '/^shaidan\/$/' => 'article/index?id=10',
            '/^shaidan\/p(\d+)$/' => 'article/index?id=10&p=:1',
            '/^baicai\/$/' => 'book/baicai',
            '/^baicai\/p(\d+)$/' => 'book/baicai?p=:1',
            '/^ec\/$/' => 'exchange/index',
            '/^ec\/p(\d+)$/' => 'exchange/index?p=:1',
            '/^space$/' => 'space/index',
            '/^space\/(\d+)$/' => 'space/index?uid=:1',
            '/^space\/(\d+)\/(\S+)$/' => 'space/index?uid=:1&t=:2',
            '/^share\/(\S+)$/' => 'ajax/g_share?tg=:1',
            '/^sitemap.html$/' => 'sitemap/index',
            '/^go\/(\S+)$/' => 'go/index?to=:1',
            '/^rss$/' => 'rss/index',
              '/^topics\/$/' => 'wap/book/index',
            '/^topics\/p(\d+)$/' => 'wap/book/index?p=:1',
            '/^topics\/ghhz\/$/' => 'wap/book/cate?cid=333',  //个护化妆 
            '/^topics\/bjys\/$/' => 'wap/book/cate?cid=334',  //保健养生  
            '/^topics\/tsyx\/$/' => 'wap/book/cate?cid=336',  //图书音像  
            '/^topics\/smjd\/$/' => 'wap/book/cate?cid=116',  //数码家电  
            '/^topics\/lyxx\/$/' => 'wap/book/cate?cid=338',  //旅游休闲  
            '/^topics\/rybh\/$/' => 'wap/book/cate?cid=335',  //日用百货  
            '/^topics\/fzxm\/$/' => 'wap/book/cate?cid=1',    //服装鞋帽  
            '/^topics\/mywj\/$/' => 'wap/book/cate?cid=115',  //母婴玩具  
            '/^topics\/dyzx\/$/' => 'wap/book/cate?cid=339',  //电影资讯  
            '/^topics\/yzps\/$/' => 'wap/book/cate?cid=340',  //眼镜配饰  
            '/^topics\/xbsd\/$/' => 'wap/book/cate?cid=50',   //箱包手袋  
            '/^topics\/ydhw\/$/' => 'wap/book/cate?cid=102',  //运动户外  
            '/^topics\/zbss\/$/' => 'wap/book/cate?cid=114',  //钟表首饰  
            '/^topics\/spjy\/$/' => 'wap/book/cate?cid=337',  //食品酒饮  
            '/^topics\/zqzb\/$/' => 'wap/book/cate?cid=341',  //杂七杂八  
            '/^topics\/notice\/$/' => 'wap/book/cate?cid=342',//活动公告  
            '/^topics\/finance\/$/' => 'wap/book/cate?cid=349',
             '/^topics\/oversea-guide\/$/' =>'wap/article/index?id=9',
            //END
            
            '/^topics\/c(\d+)\/p(\d+)$/' => 'wap/book/cate?cid=:1&p=:2',
            '/^topics\/gny\/(\d+)\/$/' => 'wap/book/gny?tp=:1',
            '/^topics\/gny\/(\d+)\/p(\d+)$/' => 'wap/book/gny?tp=:1&p=:2',
            '/^topics\/gny\/(\d+)\/isbao(\d+)$/' => 'wap/book/gny?tp=:1&isbao=:2',
            '/^topics\/gny\/(\d+)\/isbao(\d+)\/p(\d+)$/' => 'wap/book/gny?tp=:1&isbao=:2&p=:3',
            '/^topics\/gny\/(\d+)\/isnice(\d+)$/' => 'wap/book/gny?tp=:1&isnice=:2',
            '/^topics\/gny\/(\d+)\/isnice(\d+)\/p(\d+)$/' => 'wap/book/gny?tp=:1&isnice=:2&p=:3',
            '/^topics\/gny\/(\d+)\/(\S+)\/(\S+)\/isnice(\d+)$/' => 'wap/book/gny?tp=:1&tab=:2&dss=:3&isnice=:4',
            '/^topics\/gny\/(\d+)\/(\S+)\/(\S+)\/isnice(\d+)\/p(\d+)$/' => 'wap/book/gny?tp=:1&tab=:2&dss=:3&isnice=:4&p=:5',
            '/^topics\/gny\/(\d+)\/(\S+)\/(\S+)\/isbao(\d+)$/' => 'wap/book/gny?tp=:1&tab=:2&dss=:3&isbao=:4',
            '/^topics\/gny\/(\d+)\/(\S+)\/(\S+)\/isbao(\d+)\/p(\d+)$/' => 'wap/book/gny?tp=:1&tab=:2&dss=:3&isbao=:4&p=:5',
            '/^topics\/best$/' => 'wap/book/best',

            '/^article\/(\d+).html$/' => 'wap/article/show?id=:1',
            '/^item\/(\d+).html$/' => 'wap/item/index?id=:1',
            '/^bao\/(\d+).html$/' => 'wap/bitem/index?isbao=1&id=:1',
            '/^tag\/(\S+)$/' => 'wap/book/index?tag=:1',
            '/^p\/(\d+)\/tag\/(\S+)$/' => 'wap/book/index?p=:1&tag=:2',
            '/^topics\/oversea-guide\/p(\d+)$/' => 'wap/article/index?id=9&p=:1',
            '/^shaidan\/$/' => 'wap/article/index?id=10',
            '/^shaidan\/p(\d+)$/' => 'wap/article/index?id=10&p=:1',
            '/^baicai\/$/' => 'wap/book/baicai',
            '/^baicai\/p(\d+)$/' => 'wap/book/baicai?p=:1',
            '/^ec\/$/' => 'wap/exchange/index',
            '/^ec\/p(\d+)$/' => 'wap/exchange/index?p=:1',
            '/^space$/' => 'wap/space/index',
            '/^space\/(\d+)$/' => 'wap/space/index?uid=:1',
            '/^space\/(\d+)\/(\S+)$/' => 'wap/space/index?uid=:1&t=:2',
            '/^share\/(\S+)$/' => 'wap/ajax/g_share?tg=:1',
            '/^sitemap.html$/' => 'wap/sitemap/index',


        ),
);
