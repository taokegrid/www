DROP TABLE IF EXISTS user;

CREATE TABLE IF NOT EXISTS user( 
  user_id int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  name varchar(64) NOT NULL DEFAULT '' COMMENT '用户昵称',
  avatar varchar(255) NOT NULL DEFAULT '' COMMENT '用户头像',
  oauth_uid varchar(255) NOT NULL DEFAULT '' COMMENT 'oauth2 uid',
  oauth_via varchar(32) NOT NULL DEFAULT '' COMMENT 'oauth2 来源',
  alipay_account varchar(64) NOT NULL DEFAULT '' COMMENT '支付宝帐号',
  add_time  DATETIME  NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '商品添加时间',
  PRIMARY KEY (user_id),
  UNIQUE index  oauth_uid (oauth_uid, oauth_via)
  )ENGINE=InnoDB  DEFAULT CHARSET=utf8;
