<?php

class item_origModel extends Model{

    public function get_id_by_url($url) {
        $rs = preg_match("/^(http:\/\/|https:\/\/)/", $url, $match);
        if (intval($rs) == 0) {
            $url = "http://" . $url;
        }
        $rs = parse_url($url);
        $scheme = isset($rs['scheme']) ? $rs['scheme'] . "://" : "http://";
        $host = isset($rs['host']) ? $rs['host'] : "none";
        $host = explode('.', $host);
        $host = array_slice($host, -2, 2);
        $domain = implode('.', $host);
        $orig_id = $this->where(array('url' => array('like', '%'.$domain.'%')))->getField('id');
		$orig_id = $orig_id ? $orig_id : 0;
        return $orig_id;
    }

    /**
     * 检测是否存在
     */
    public function name_exists($name, $id=0)
    {
        $pk = $this->getPk();
        $where = "name='" . $name . "'  AND ". $pk ."<>'" . $id . "'";
        $result = $this->where($where)->count($pk);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 商城列表
     */
    public function orig_cache() {
        if (false !== $orig_list = F('orig_list')) {
            return $orig_list;
        }
        $result = $this->field("*,case when name REGEXP '^[0-9]' then '0~9' else upper(fristPinyin(LTRIM(name))) end as letter")->order("name")->select();
        $orig_list = array();
        foreach ($result as $val) {
            $orig_list[$val['id']] = $val;
        }
        F('orig_list', $orig_list);
        return $orig_list;
    }

    /**
     * 热门商城列表
     */
    public function hot_orig_cache() {
        if (false !== $hot_orig_list = F('hot_orig_list')) {
            return $hot_orig_list;
        }
        $result = $this->where("is_hot=1")->order("id asc")->select();
        $hot_orig_list = array();
        foreach ($result as $val) {
            $hot_orig_list[$val['id']] = $val;
        }
        F('hot_orig_list', $hot_orig_list);
        return $hot_orig_list;
    }

    public function get_info($id) {
        if(!$id) return false;
        $orig_list = $this->orig_cache();
        if (isset($orig_list[$id])) {
            return $orig_list[$id];
        } else {
            return false;
        }
    }

    public function get_orig_by_ids($ids) {
        if(!$ids || count($ids) == 0) return false;

        $list = array();
        $orig_list = $this->orig_cache();
        foreach ($ids as $id) {
            $list[$id] = $orig_list[$id]; 
        }

        return $list;
    }

    /**
     * 根据商城名查找商城
     */
    public function get_orig_by_name($name) {
        if(!$name) return false;

        $list = array();
        $orig_list = $this->orig_cache();
        foreach ($orig_list as $val) {
            if (strtolower(trim($val['name'])) == strtolower(trim($name))) {
                $list[$val['id']] = $val; 
            }
        }
        return $list;
    }

}