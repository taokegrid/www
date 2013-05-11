DROP TABLE IF EXISTS user_product;

CREATE TABLE IF NOT EXISTS user_product( 
  user_id int(11) NOT NULL DEFAULT 0 COMMENT '用户id',
  grid_id int(11) NOT NULL DEFAULT 0 COMMENT '格子id',
  product_id int(11) NOT NULL DEFAULT 0 COMMENT '商品id',
  cid int(10)  NOT NULL DEFAULT 0 COMMENT '商品淘宝分类',
  KEY (user_id),
  INDEX grid_id(user_id,grid_id)
  )ENGINE=InnoDB  DEFAULT CHARSET=utf8;
