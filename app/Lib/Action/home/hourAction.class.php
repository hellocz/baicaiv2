<?php
class hourAction extends frontendAction {
    
    public function index() {

    	$hour = $this->_get("hour");
    	if(empty($hour)){
    	$hour = date('H');
    	$hourplus = $hour+1;
    	if (false !== $item_list_plus = F('hour_list_' . $hourplus)){
    		F('hour_list_' . $hourplus,NULL);
    	}
    	$where['status'] = 1;
    	$order ="add_time desc";
    	if (false === $item_list = F('hour_list_' . $hour)) {
    	$item_list = M("item")->where($where)->limit(10)->order($order)->select();
    	F('hour_list_' . $hour,$item_list);
    	}
    	// var_dump(F('hour_list_' . $hour));
		}

		$this->display();
    }
}
