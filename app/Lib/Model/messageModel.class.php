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
    * 用户未读消息数量
    */
    public function unread_count($uid = 0){
        if(!$uid) return false;

        $map = array();
        $map['to_id'] = $uid;
        $map['ck_status'] = 0;

        $count = $this->where($map)->count();
        return $count;
    }

    /**
    * 用户系统消息数量
    */
    public function system_count($uid = 0){
        if(!$uid) return false;

        $map = array();
        $map['from_id'] = 0;
        $map['to_id'] = $uid;

        $arr = D('ssb')->get_mids($uid); //删除的message IDs
        if(count($arr) > 0){
            $map['id']  = array('not in', $arr);
        }

        $count = $this->where($map)->count();
        return $count;
    }

    /**
    * 用户系统消息列表
    */
    public function system_list($uid = 0, $limit = '0,10', $order = 'id DESC'){
        if(!$uid) return false;

        $map = array();
        $map['from_id'] = 0;
        $map['to_id'] = $uid;

        $arr = D('ssb')->get_mids($uid); //删除的message IDs
        if(count($arr) > 0){
            $map['id']  = array('not in', $arr);
        }

        $list = $this->where($map)->order($order)->limit($limit)->select();
        return $list;
    }

    /**
    * 更新消息查看状态,1：已读，2：未读
    */
    function set_ck_status($from_id, $to_id, $ck_status = 1){
        if(!$from_id && $from_id !== 0) return false;
        if(!$to_id && $to_id !== 0) return false;
        if(!$ck_status && $ck_status !== 0) return false;

        $map = array(
            'from_id' => $from_id,
            'to_id' => $to_id,
        );
        $this->where($map)->setField('ck_status', $ck_status);
    }

}