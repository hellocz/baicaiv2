<?php
class item_voteModel extends Model
{

    public function vote($userid,$xid, $itemid,$type)
    {
        $isvote=$this->where("uid=$userid and xid=$xid and itemid=$itemid")->find();
        if($isvote){
            $status['code'] = 0;
            $status['error'] = "不能重复投票";
        }
        else{
            $i_mod = get_mod($xid);
            if($type==1){
                $i_mod->where("id=$itemid")->setInc("zan");
            }
            else{
                $i_mod->where("id=$itemid")->setInc("cai");
            }
            $this->add(array('itemid'=>$itemid,'xid'=>$xid,'add_time'=>time(),'uid'=>$userid,'type'=>$type));
            $status['code'] = 1;
        }
        return $status;
    }

   
}