DROP TABLE IF EXISTS grid;

CREATE TABLE IF NOT EXISTS  grid( 
  grid_id int(11) NOT NULL AUTO_INCREMENT COMMENT '格子ID',
  name varchar(255) NOT NULL DEFAULT '' COMMENT '格子名称',
  notes  text  NOT NULL DEFAULT '' COMMENT '格子简述',
  title varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  keywords varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO关键词',
  description varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  add_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '格子添加时间',
  PRIMARY KEY (grid_id)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
