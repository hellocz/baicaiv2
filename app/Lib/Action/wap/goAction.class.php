<?php
class goAction extends frontendAction {

    public function index() {
		$url = $this->_get("to","base64_decode");
		redirect($url);
    }
}