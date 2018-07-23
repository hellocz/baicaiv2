<?php
class listAction extends frontendAction {

    public function index(){

        $this->filter();

        $this->display();
    }


}