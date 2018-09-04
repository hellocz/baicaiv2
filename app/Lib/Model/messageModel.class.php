<?php
/**
 * 短信状态说明
 * 0: 未读
 * 1：已读
 * 2：发送者已删除
 * 3：接收者已删除
 */
class messageModel extends Model
{
    //自动完成
    protected $_auto = array(
        array('add_time', 'time', 1, 'function'),
    );

    /**
     * 用户删除信息
     */
    public function user_delete($mid, $uid) {
        $mids = is_array($mid) ? $mid : explode(',', $mid);
        if (!$mid || !$uid) {
            return false;
        }
        $delete_ids = array();
        foreach ($mids as $mid) {
            $info = $this->find($mid);
            if ($info['from_id'] == 0 && $info['to_id'] == $uid) {
                //系统发给用户的可以直接删除记录
                $delete_ids[] = $mid;
            } elseif ($info['to_id'] == $uid) {
                //收件箱
                if ($info['status'] == 2) {
                    //如果发送方已经删除则删除记录
                    $delete_ids[] = $mid;
                } else {
                    //修改状态为接收者删除
                    $this->where(array('id'=>$mid))->setField('status', 3);
                }
            } elseif ($info['from_id'] == $uid) {
                //发件箱
                if ($info['status'] == 3) {
                    //如果接收方已经删除则删除记录
                    $delete_ids[] = $mid;
                } else {
                    //修改状态为发送者删除
                    $this->where(array('id'=>$mid))->setField('status', 2);
                }
            } else {
                continue;
            }
        }
        return $delete_ids ? $this->delete(implode(',', $delete_ids)) : count($mids);
    }

    function setName($id,$value)
    {
        if( $id&&$value ){
            $map = array(
                'from_id' => $id,
                'from_name' => $value,
            );
            $this->where(array('from_id'=>$id))->save($map);

            $map2 = array(
                'to_id' => $id,
                'to_name' => $value,
            );
            $this->where(array('to_id'=>$id))->save($map);
        }
    }
    public function add1($data='',$options=array(),$replace=false) {
        if(empty($data)) {
            // 没有传递数据，获取当前数据对象的值
            if(!empty($this->data)) {
                $data           =   $this->data;
                // 重置数据
                $this->data     = array();
            }else{
                $this->error    = L('_DATA_TYPE_INVALID_');
                return false;
            }
        }
        // 分析表达式
        $options    =   $this->_parseOptions($options);
        // 数据处理
        $data       =   $this->_facade($data);
        if(false === $this->_before_insert($data,$options)) {
            return false;
        }
        // 写入数据到数据库
        $result = $this->db->insert($data,$options,$replace);
        if(false !== $result ) {
            $insertId   =   $this->getLastInsID();
            if($insertId) {
                // 自增主键返回插入ID
                $data[$this->getPk()]  = $insertId;
                $this->_after_insert($data,$options);
                return $insertId;
            }
            $this->_after_insert($data,$options);
        }
        return $result;
    }

    /**
    * 系统消息 - 更新查看状态,1：已读，0：未读
    */
    function set_system_ck_status($uid = 0, $ck_status = 1){
        if(!$uid) return false;

        $map = array(
            'from_id' => 0,
            'to_id' => $uid,
        );
        $this->where($map)->setField('ck_status', $ck_status);
    }

    /**
    * 网友消息 - 更新接收者的消息查看状态,1：已读，0：未读
    */
    function set_message_ck_status($ftid = 0, $uid = 0, $ck_status = 1){
        if(!$uid) return false;

        if($ftid){
            $map = "ftid='".$ftid."' AND to_id=".$uid;
        }else{
            $map = "from_id > 0 AND to_id=".$uid;
        }
        
        $result = $this->where($map)->setField('ck_status', $ck_status);

        return $result;
    }

    /**
    * 所有未读消息数量更新
    */
    public function set_unread_message_num($uid = 0){
        if(!$uid) return false;

        $map = "to_id=".$uid." AND status<>3 AND ck_status=0";
        $field = "sum(1) as total_count";
        $field.= ", sum(case when from_id=0 then 1 else 0 end) as system_count";
        $field.= ", sum(case when from_id>0 then 1 else 0 end) as user_count";

        // $count = $this->where($map)->count();
        $arr = $this->field($field)->where($map)->find();

        //更新保存至用户信息session
        // $_SESSION['user_info']['message'] = $count;        
        $_SESSION['user_info']['message']['total'] = intval($arr['total_count']);
        $_SESSION['user_info']['message']['system'] = intval($arr['system_count']);
        $_SESSION['user_info']['message']['user'] = intval($arr['user_count']);
        $_SESSION['user_info']['message']['follow'] = 0;

        return $_SESSION['user_info']['message'];
    }

    /**
    * 系统消息数量
    */
    public function system_count($uid = 0){
        if(!$uid) return false;

        $map = array();
        $map['from_id'] = 0;
        $map['to_id'] = $uid;

        //单个删除系统消息, 新版本可去除
        $arr = D('ssb')->get_mids($uid); //删除的message IDs
        if(count($arr) > 0){
            $map['id']  = array('not in', $arr);
        }

        $count = $this->where($map)->count();
        return $count;
    }

    /**
    * 网友消息对话数量, 即ftid唯一数
    */
    public function talk_count($uid = 0){
        if(!$uid) return false;

        $map = "from_id > 0 AND ((from_id = '".$uid."' AND status<>2) OR (to_id = '".$uid."' AND status<>3))";

        $count = $this->where($map)->count('distinct ftid');
        return $count;
    }

    /**
    * 系统消息列表
    */
    public function system_list($uid = 0, $limit = '0,10', $order = 'id DESC'){
        if(!$uid) return false;

        $map = array();
        $map['from_id'] = 0;
        $map['to_id'] = $uid;

        //单个删除系统消息, 新版本可去除
        $arr = D('ssb')->get_mids($uid); //删除的message IDs
        if(count($arr) > 0){
            $map['id']  = array('not in', $arr);
        }

        $list = $this->where($map)->order($order)->limit($limit)->select();
        return $list;
    }


    /**
    * 网友消息对话列表
    */
    public function talk_list($uid = 0, $limit = '0,10', $order = 'id DESC'){
        if(!$uid) return false;

        $map = "from_id > 0 AND ((from_id = '".$uid."' AND status<>2) OR (to_id = '".$uid."' AND status<>3))";

        $list = array();
        $map1 = array();
        $arr = $this->field('ftid, MAX(id) as id,COUNT(id) as num')->where($map)->group('ftid')->order($order)->limit($limit)->select();
        if(count($arr) > 0){
            foreach ($arr as $val) {
                $talks[$val['id']] = $val['num'];
            }
            $map1['id']  = array('in', array_keys($talks));

            $list = $this->where($map1)->order($order)->select();
            foreach ($list as $key=>$val) {
                //对方信息
                if ($val['from_id'] == $uid) {
                    $list[$key]['ta_id'] = $val['to_id'];
                    $list[$key]['ta_name'] = $val['to_name'];
                } else {
                    $list[$key]['ta_id'] = $val['from_id'];
                    $list[$key]['ta_name'] = $val['from_name'];
                }
                $list[$key]['num'] = $talks[$val['id']];
            }
        }

        return $list;
    }

    /**
    * 网友消息列表, ftid: 对话ID 
    */
    public function message_list($ftid = 0, $uid = 0, $limit = '0,10', $order = 'id DESC'){
        if(!$uid) return false;

        if($ftid){
            $map = "ftid='".$ftid."' AND ((from_id = '".$uid."' AND status<>2) OR (to_id = '".$uid."' AND status<>3))";
        }else{
            $map = "from_id > 0 AND ((from_id = '".$uid."' AND status<>2) OR (to_id = '".$uid."' AND status<>3))";
        }

        $list = $this->where($map)->order($order)->limit($limit)->select();

        return $list;
    }

    /**
    * 网友消息列表IDs 
    */
    public function get_message_ids($ftid = 0, $uid = 0){
        if(!$uid) return false;

        if($ftid){
            $map = "ftid='".$ftid."' AND ((from_id = '".$uid."' AND status<>2) OR (to_id = '".$uid."' AND status<>3))";
        }else{
            $map = "from_id > 0 AND ((from_id = '".$uid."' AND status<>2) OR (to_id = '".$uid."' AND status<>3))";
        }

        $list = $this->where($map)->select();
        $ids = array();
        if(count($list) > 0){
            foreach ($list as $key => $val) {
                $ids[$val['id']] = $val['id'];
            }
        }
        return $ids;
    }

    /**
    * 发布一条消息
    */
    public function publish($data) {

        //判断等级
        // ( grade($uid) < 2) &&  $this->ajaxReturn(0, '您的等级还不够，需要升到 2 级才能发送私息！');
        
        //判断积分
        if($data['from_id'] > 0){
            $score = D('user')->get_field($data['from_id'], 'score');
            if($score < 2){
                $this->error = '您的积分不够了';
                return false;
            }
        }
        //判断内容
        $data['info'] = Input::deleteHtmlTags($data['info']);
        if(!$data['info']) {
            $this->error = L('message_content_empty');
            return false;
        }
        //添加到动态表
        $data = $this->create($data);
        if ($data['id'] = $this->add()) {

            //提示接收者
            D('user_msgtip')->add_tip($data['to_id'], 3);
            
            if($data['from_id'] > 0){
                //更新积分
                M("user")->where("id=".$data['from_id'])->setDec("score",2);
                //积分日志
                set_score_log(array('id'=>$data['from_id'],'username'=>$data['from_name']),'shixin',-2,'','','');
            }
            //发布成功
            return $data;
        } else {
            //发布失败
            $this->error = L('illegal_parameters');
            return false;
        }
    }

    /**
    * 最近联系人数
    */
    public function user_contact_count($uid = 0){
        if(!$uid) return false;

        $field_uid = "case when from_id={$uid} then to_id else from_id end";
        // $field = "{$field_uid} as uid, max(id) as mid";
        $map = "from_id > 0 AND ((from_id = '".$uid."') OR (to_id = '".$uid."'))";

        $count = $this->where($map)->count('distinct '.$field_uid);
        return $count;
    }

    /**
    * 最近联系人
    */
    public function user_contact_list($uid = 0, $limit = '0,10', $order = 'mid DESC'){
        if(!$uid) return false;

        $field_uid = "case when from_id={$uid} then to_id else from_id end";
        $field = "{$field_uid} as uid, max(id) as mid";
        $map = "from_id > 0 AND ((from_id = '".$uid."') OR (to_id = '".$uid."'))";

        $sql = $this->field($field)->where($map)->group($field_uid)->buildSql();
        $list = $this->table($sql." as t")->join("join try_user u ON u.id=t.uid")->order($order)->limit($limit)->select();
        return $list;
    }

}