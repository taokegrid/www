DROP TABLE IF EXISTS product;

CREATE TABLE IF NOT EXISTS  product ( 
  product_id int(11) NOT NULL  AUTO_INCREMENT COMMENT '商品ID',
  taobao_id int (11)  NOT NULL DEFAULT 0 COMMENT '商品在淘宝的货号',
  name varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称',
  click_url varchar(255) NOT NULL DEFAULT '' COMMENT '商品源地址',
  img_url varchar(255) NOT NULL DEFAULT '' COMMENT '商品图片地址',
  sell_price float(10,2) NOT NULL DEFAULT 0 COMMENT '销售价格',
  market_price float(10,2) NOT NULL DEFAULT 0 COMMENT '市场价格，可当作是原价',
  commission float(10,2) NOT NULL DEFAULT 0 COMMENT '佣金',
  title varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  keywords varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO关键词',
  description varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  notes text NOT NULL DEFAULT '' COMMENT '商品简述',
  status int(3)  NOT NULL DEFAULT 0 COMMENT '商品状态',
  visit int(11) NOT NULL DEFAULT 0 COMMENT '浏览次数',
  click int(11) NOT NULL DEFAULT 0 COMMENT '点击次数',
  volume int(11) NOT NULL DEFAULT 0 COMMENT '月销量',
  hot int(11) NOT NULL  DEFAULT 0 COMMENT '商品热度',
  sellernick varchar(60) NOT NULL DEFAULT ''  COMMENT '卖主称谓',
  add_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '商品添加时间',
  PRIMARY KEY (product_id),
  UNIQUE INDEX taobao_id (taobao_id)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
