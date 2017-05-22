<?php
class sitemapAction extends frontendAction {    
    public function index() {
		$this->assign("page_seo",set_seo('网站地图'));
        $this->display();
    }
}