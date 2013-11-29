pdo_mysql_class
===============

mysql pdo operation


使用示例：

$params             = array();

$params['dns']      = 'mysql:host=192.168.126.128;dbname=test';

$params['username'] = 'root';

$params['password'] = 'sumiaowen520';

$pdoObj = Pdo_db::get_instance($params);

//查询数据

$sql    = "select keyword from test where keyword like :keyword order by`id asc limit 5";

$result = $pdoObj->query($sql, array(':keyword' => 'PHP%'));

//插入数据

$sql    = "insert into test(keyword) values(:keyword)";

$result = $pdoObj->insert($sql, array(':keyword' => 'PHP%'));

//更新数据

$sql    = "update test set keyword = :keyword where id=:id";

$result = $pdoObj->update($sql, array(':keyword' => 'PHP%', ':id' => 11));

//删除数据

$sql    = "delete from test where id=:id";

$result = $pdoObj->delete($sql, array(':id' => 11));

更新中...

//批量处理

//事务
