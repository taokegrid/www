DROP TABLE IF EXISTS category;

CREATE TABLE IF NOT EXISTS category( 
  cid int(11) NOT NULL DEFAULT 0 COMMENT '商品分类id',
  parent_cid int(11) NOT NULL DEFAULT 0 COMMENT '商品父分类id',
  name varchar(255) NOT NULL DEFAULT 0 COMMENT '分类名称',
  PRIMARY KEY (cid)
  )ENGINE=InnoDB  DEFAULT CHARSET=utf8;
