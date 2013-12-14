<?php
/**
 * PDO 操作
 * Created by PhpStorm.
 * User: sumiaowen
 * Date: 13-11-28
 * Time: 下午9:12
 * To change this template use File | Settings | File Templates.
 */
class myPdo
{
	private $dns = null;
	private $username = null;
	private $password = null;
	private $conn = null;
	private static $_instance = null;

	private function __construct($params = array())
	{
		$this->dns      = $params['dns'];
		$this->username = $params['username'];
		$this->password = $params['password'];

		$this->_connect();
	}

	private function __clone() { }

	public static function get_instance($params = array())
	{
		if(!(self::$_instance instanceof self))
		{
			self::$_instance = new self($params);
		}

		return self::$_instance;
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
	 * 查询
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
	 * 增、删、改
	 * @param string $sql
	 * @param array  $parameters 需要绑定的参数数组
	 * @return int 返回影响行数
	 */
	public function execution($sql, $parameters = array())
	{
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($parameters);

		return $stmt->rowCount();
	}

	/**
	 * 返回最后插入行的ID
	 * @return mixed
	 */
	public function getLastInsertId()
	{
		return $this->conn->lastInsertId();
	}
}