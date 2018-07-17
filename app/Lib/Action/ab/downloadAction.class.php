<?php
class downloadAction extends newfrontendAction {

    public function index(){

        $this->_config_seo(array('title'=>'下载中心'));
        $this->display();
    }

}