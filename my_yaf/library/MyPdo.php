<?php
/**
 * 简易 PDO mysql 操作类
 * Created by PhpStorm.
 * User: sumiaowen
 * Contact: http://www.php230.com/
 * Date: 13-11-30
 * Time: 下午10:33
 * To change this template use File | Settings | File Templates.
 */
class MyPdo
{
	private $dns = null;
	private $username = null;
	private $password = null;
	private $conn = null;

	public function __construct($database = 'default')
	{
		$this->dns      = Yaf_Registry::get('config')->db->$database->dns;
		$this->username = Yaf_Registry::get('config')->db->$database->username;
		$this->password = Yaf_Registry::get('config')->db->$database->password;

		$this->_connect();
	}

	private function _connect()
	{
		try
		{
			$this->conn = new PDO($this->dns, $this->username, $this->password);
			$this->conn->query('set names utf8');
		}
		catch(PDOException $e)
		{
			exit('PDOException: ' . $e->getMessage());
		}
	}

	/**
	 * 查询一条SQL语句
	 * @param string $sql
	 * @param array  $parameters 需要绑定的参数
	 * @param int    $option
	 * @return array
	 */
	public function query($sql, $parameters = array(), $option = PDO::FETCH_ASSOC)
	{
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($parameters);

		$tmp = array();
		while($row = $stmt->fetch($option))
		{
			$tmp[] = $row;
		}

		return $tmp;
	}

	/**
	 * 插入一条数据
	 * @param string $sql
	 * @param array  $parameters
	 * @return int  1 or 0 返回影响行数
	 */
	public function insert($sql, $parameters = array())
	{
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($parameters);

		return $stmt->rowCount();
	}

	/**
	 * 更新一条数据
	 * @param string $sql
	 * @param array  $parameters
	 * @return int  1 or 0 返回影响行数
	 */
	public function update($sql, $parameters = array())
	{
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($parameters);

		return $stmt->rowCount();
	}

	/**
	 * 删除一条数据
	 * @param string $sql
	 * @param array  $parameters
	 * @return int  1 or 0 返回影响行数
	 */
	public function delete($sql, $parameters = array())
	{
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($parameters);

		return $stmt->rowCount();
	}
}