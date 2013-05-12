DROP TABLE IF EXISTS user_grid;

CREATE TABLE IF NOT EXISTS user_grid( 
  user_id int(11) NOT NULL DEFAULT 0 COMMENT '用户id',
  grid_id int(11) NOT NULL DEFAULT 0 COMMENT '格子id',
  KEY (user_id),
  INDEX grid_id(user_id,grid_id)
  )ENGINE=InnoDB  DEFAULT CHARSET=utf8;
