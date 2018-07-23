<?php
class downloadAction extends frontendAction {

    public function index(){

        $this->_config_seo(array('title'=>'下载中心'));
        $this->display();
    }

}