#!/bin/bash -x

test $# -ne 1 && { echo "please input database name"; exit 1; }

mysql="/Applications/MAMP/Library/bin/mysql -hlocalhost -uroot -p123456"
db_name=$1
echo "CREATE DATABASE IF NOT EXISTS $db_name " | $mysql

cat *.sql | $mysql $db_name
