<?php
class articleModel extends RelationModel
{
    //自动完成
    protected $_auto = array(
        array('add_time', 'time', 1, 'function'),
    );
    //自动验证
    protected $_validate = array(
        array('title', 'require', '{%article_title_empty}'),
    );
    //关联关系
    protected $_link = array(
        'cate' => array(
            'mapping_type' => BELONGS_TO,
            'class_name' => 'article_cate',
            'foreign_key' => 'cate_id',
        )
    );
    public function addtime()
    {
        return date("Y-m-d H:i:s",time());
    }

    /**
     * article信息, 通过ID获取
     */
    public function get_info($id = '', $field = '') {
        if(!$id) return false;        
        $info = $this->field($field)->where(array('id' => $id))->find();
        return $info;
    }

    /**
    * 获得文章总数
    */
    public function sum($where = ''){
        if(!$where) return false;

        $sum = $this->field("count(1) as count, sum(zan) as zan")->where($where)->find();
        return $sum;
    }
    /**
    * 获得文章列表
    */
    public function article_list($where = '', $order = 'add_time desc', $limit = '1,10'){
        if(!$order){
            $order = 'add_time desc';
        }
        $list = $this->where($where)->order($order)->limit($limit)->select();
        return $list;
    }

    /**
    * 用户文章总数
    */
    public function user_article_sum($uid = 0, $status = 1){
        if(!$uid) return false;

        $time=time();
        $where = "uid='".$uid."' and cate_id in(select id from try_article_cate where pid in(9,10) or id in(9,10)) and add_time<$time"; //海淘攻略、晒单
        if($status !== ""){
            $where .= " and status = ({$status})";
        }else{
            $where .= " and status in ('0','1','2','3')"; //排除被删除的文章
        }
        $sum = $this->sum($where);

        return $sum;
    }

    /**
    * 用户文章列表
    */
    public function user_article_list($uid = 0, $status = 1, $field = '', $order = 'add_time desc', $limit = '1,10'){
        if(!$uid) return false;

        $time=time();
        $where = "uid='".$uid."' and cate_id in(select id from try_article_cate where pid in(9,10) or id in(9,10)) and add_time<$time"; //海淘攻略、晒单
        if($status !== ""){
            $where .= " and status = ({$status})";
        }else{
            $where .= " and status <> 4"; //排除被删除的文章
        }
        $list = $this->field($field)->where($where)->order($order)->limit($limit)->select();

        return $list;
    }

    /**
    * 用户文章列表-sql
    */
    public function user_article_sql($uid = 0, $status = 1, $field = '', $order = 'add_time desc', $limit = '1,10'){
        if(!$uid) return false;

        $time=time();
        $where = "uid='".$uid."' and cate_id in(select id from try_article_cate where pid in(9,10) or id in(9,10)) and add_time<$time"; //海淘攻略、晒单
        if($status !== ""){
            $where .= " and status = ({$status})";
        }else{
            $where .= " and status <> 4"; //排除被删除的文章
        }
        $sql = $this->field($field)->where($where)->order($order)->limit($limit)->buildSql();

        return $sql;
    }

}