<?php
class listAction extends newfrontendAction {

    public function index(){

        $this->filter();

        $this->display();
    }


}