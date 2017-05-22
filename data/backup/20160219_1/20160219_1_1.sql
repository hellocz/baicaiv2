-- TuanPhp SQL Dump Program
-- 
-- DATE : 2016-02-19 09:24:31
-- Vol : 1
DROP TABLE IF EXISTS `try_hd`;
CREATE TABLE `try_hd` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `hdname` varchar(255) NOT NULL COMMENT '活动名称',
  `hdurl` varchar(255) NOT NULL,
  `istop` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO try_hd ( `id`, `hdname`, `hdurl`, `istop` ) VALUES  ('1','满500-40、1000-100、2000-200','http://p2.jiaodaoren.com/item/144420.html','1');
INSERT INTO try_hd ( `id`, `hdname`, `hdurl`, `istop` ) VALUES  ('2','满599元3件','http://www.meidebi.com/g-977806.html','1');
INSERT INTO try_hd ( `id`, `hdname`, `hdurl`, `istop` ) VALUES  ('3','亚马逊 建行银联IC借记卡优惠活动 最高立减50元','http://www.meidebi.com/g-939436.html','1');
INSERT INTO try_hd ( `id`, `hdname`, `hdurl`, `istop` ) VALUES  ('4','英亚 男女儿童服饰鞋靴箱包腕表 低至3折！','http://www.meidebi.com/h-941753.html','1');
INSERT INTO try_hd ( `id`, `hdname`, `hdurl`, `istop` ) VALUES  ('5','新年读好书 满100-20、200-50、300-100','http://www.meidebi.com/g-960235.html','1');
