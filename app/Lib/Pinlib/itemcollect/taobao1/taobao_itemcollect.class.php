<?php

/**
 * 淘宝商品获取
 *
 * @author andery
 */
class taobao_itemcollect {

    private $_code = 'taobao';

    public function fetch($url) {
        $id = $this->get_id($url);
        if (!$id) {
            return false;
        }
        $key = 'taobao_' . $id;
        $item_site = M('item_site')->where(array('code' => $this->_code))->find();
        $api_config = unserialize($item_site['config']);

        //使用淘宝开放平台API
        vendor('Taobaotop.TopClient');
        vendor('Taobaotop.RequestCheckUtil');
        vendor('Taobaotop.Logger');
        $tb_top = new TopClient;
        $tb_top->appkey = $api_config['app_key'];
        $tb_top->secretKey = $api_config['app_secret'];
        $req = $tb_top->load_api('TbkItemInfoGetRequest');
        $req->setFields('num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url');
        $req->setNumIids($id);
        $resp = $tb_top->execute($req);
        if (!isset($resp->results)) {
            return false;
        }
        $item = (array) $resp->results->n_tbk_item;
        $result = array();
        $result['item']['key_id'] = $key;
        $x=strip_tags($item['title']);
        $result['item']['title'] = strip_tags($item['title']);
        $result['item']['price'] = $item['zk_final_price'];
        $result['item']['img'] = $item['pict_url'];
        $result['item']['url'] = $item['item_url'];

        //商品相册
        $result['item']['imgs'] = array();
        $item_imgs = (array) $item['small_images'];
        $item_imgs = (array) $item_imgs['string'];
        foreach ($item_imgs as $_img) {
            if ($_img) {
                $result['item']['imgs'][] = array(
                    'url' => $_img
                );
            }
        }        
        
        return $result['item'];
    }

    public function get_id($url) {
        $id = 0;
        $parse = parse_url($url);
        if (isset($parse['query'])) {
            parse_str($parse['query'], $params);
            if (isset($params['id'])) {
                $id = $params['id'];
            } elseif (isset($params['item_id'])) {
                $id = $params['item_id'];
            } elseif (isset($params['default_item_id'])) {
                $id = $params['default_item_id'];
            }
        }
        return $id;
    }

    public function get_key($url) {
        $id = $this->get_id($url);
        return 'taobao_' . $id;
    }

}