DROP TABLE IF EXISTS grid_product;

CREATE TABLE IF NOT EXISTS grid_product( 
  grid_id int(11) NOT NULL DEFAULT 0 COMMENT '格子id',
  product_id int(11) NOT NULL DEFAULT 0 COMMENT '商品id',
  cid int(10)  NOT NULL DEFAULT 0 COMMENT '商品淘宝分类',
  KEY (grid_id),
  INDEX grid_id(grid_id, product_id)
  )ENGINE=InnoDB  DEFAULT CHARSET=utf8;
