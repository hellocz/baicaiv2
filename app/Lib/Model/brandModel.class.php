<?php
class brandModel extends Model
{

    public function get_info($id) {
        if(!$id) return false;
        $brand = $this->where(array('id' => $id))->find();
        return $brand;
    }

    public function get_name($id) {
        if(!$id) return false;
        // $brand = $this->where(array('id' => $id))->find();
        
        if (false === $brand_list = F('brand_list')) {
            $brand_list = $this->brand_cache();
        }
        if (isset($brand_list[$id])) {
            return $brand_list[$id]['name'];
        } else {
            return false;
        }
    }

    public function get_chn_name($id) {
        if(!$id) return false;
        // $brand = $this->where(array('id' => $id))->find();
        
        if (false === $brand_list = F('brand_list')) {
            $brand_list = $this->brand_cache();
        }
        if (isset($brand_list[$id])) {
            return $brand_list[$id]['chn_name'];
        } else {
            return false;
        }
    }

    /**
     * 品牌列表
     */
    public function brand_cache() {
        if (false !== $brand_list = F('brand_list')) {
            return $brand_list;
        }
        $result = $this->field('id,name,chn_name')->order("name")->select();
        $brand_list = array();
        foreach ($result as $val) {
            $brand_list[$val['id']] = $val;
        }
        F('brand_list', $brand_list);
        return $brand_list;
    }

   /**
     * 读取写入缓存(二级分类列表及二级分类列表下所有brand品牌)
     */
   public function cate_brand_cache() {

          if (false !== $cate_brand_list = F('cate_brand_list')) {
            return $cate_brand_list;
          }

          $brand_list = $this->brand_cache();

          //分类数据
          $cate_data = D('item_cate')->cate_data_cache();

          //二层category分类信息+一层brand品牌信息
          $cate_brand_list = array();
          if(count($cate_data) > 0){
            foreach ($cate_data as $id => $val) {
              list($p1,$p2) = explode('|', $val['spid']."||");
              if($val['pid'] === '0'){
                $cate_brand_list[$id]['p'] = $val;
              }else if(empty($p2)){
                $cate_brand_list[$p1]['data'][$id]['p'] = $val;
              }else if(!empty($val['top'])){
                $arr = unserialize($val['top']);
                foreach ($arr as $brandid) {
                  if(!isset($brand_list[$brandid])) continue;
                  $cate_brand_list[$p1]['data'][$p2]['data'][$brandid] = $brand_list[$brandid];
                }
              }            
            }
          }

          //过滤空的category分类
          if(count($cate_brand_list) > 0){
            foreach ($cate_brand_list as $p1 => $val1) {
              foreach ($val1['data'] as $p2 => $val2) {
                $cnt = count($cate_brand_list[$p1]['data'][$p2]['data']);
                if($cnt == 0){
                  unset($cate_brand_list[$p1]['data'][$p2]);
                }
                // else if($cnt > 3){
                //   $cate_brand_list[$p1]['data'][$p2]['data'] = array_slice($cate_brand_list[$p1]['data'][$p2]['data'], 0, 3, TRUE );
                // }
              }

              $cnt = count($cate_brand_list[$p1]['data']);
              if($cnt == 0){
                unset($cate_brand_list[$p1]);
              }
            }
          }
          unset($brand_list);

          F('cate_brand_list', $cate_brand_list);
          return $cate_brand_list;
    }

    /**
     * 更新则删除缓存
     */
    protected function _before_write(&$data) {
        F('cate_brand_list', NULL);
    }

    /**
     * 删除也删除缓存
     */
    protected function _after_delete($data, $options) {
        F('cate_brand_list', NULL);
    }
}