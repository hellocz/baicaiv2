<?php
class listAction extends frontendAction {

    public function index(){

        $this->search();

        $this->display();
    }


}