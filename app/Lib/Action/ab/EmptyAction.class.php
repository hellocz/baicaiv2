<?php
/**
 * 404错误 
 */
class EmptyAction extends Action {
    public function _empty() {
        send_http_status(404);
        // $this->display(TMPL_PATH . '404.html');
        $this->display('public:404');
    }
}