<?php

class expressModel extends Model{

    /**
     * 转运公司列表
     */
    public function express_cache() {
        if (false !== $express_list = F('express_list')) {
            return $express_list;
        }
        $result = $this->field("*,case when name REGEXP '^[0-9]' then '0~9' else upper(fristPinyin(LTRIM(name))) end as letter")->order("name")->select();
        $express_list = array();
        foreach ($result as $val) {
            $express_list[$val['id']] = $val;
        }
        F('express_list', $express_list);
        return $express_list;
    }

    /**
     * 热门商城列表
     */
    public function hot_express_cache() {
        if (false !== $hot_express_list = F('hot_express_list')) {
            return $hot_express_list;
        }
        $result = $this->where("is_hot=1")->order("id asc")->select();
        $hot_express_list = array();
        foreach ($result as $val) {
            $hot_express_list[$val['id']] = $val;
        }
        F('hot_express_list', $hot_express_list);
        return $hot_express_list;
    }
}