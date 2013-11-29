<?php
/**
 * Created by PhpStorm.
 * User: sumiaowen
 * Date: 13-11-29
 * Time: 下午9:25
 * To change this template use File | Settings | File Templates.
 */
/**
 * 一个单例模式的数据库操作类
 * Class db
 */
class db
{
	private static $_instance = null;
	private $conn = null;

	private function __construct($host, $username, $password, $databaseName)
	{
		$this->conn = mysql_connect($host, $username, $password);
		mysql_select_db($databaseName, $this->conn);
	}

	private function __clone() { }

	/**
	 * 链接数据库
	 * @param $host         数据库地址
	 * @param $username     数据库用户名
	 * @param $password     数据库用户密码
	 * @param $databaseName 数据库名
	 * @return db|null
	 */
	public function get_instance($host, $username, $password, $databaseName)
	{
		if(!(self::$_instance instanceof self))
		{
			self::$_instance = new self($host, $username, $password, $databaseName);
		}

		return self::$_instance;
	}

	/**
	 * 根据条件获取记录
	 * @param        $tableName
	 * @param string $condition
	 * @param string $fields
	 * @param string $order
	 * @param string $limit
	 * @return array
	 */
	public function fetch_all_by_condition($tableName, $condition = '1=1', $fields = '*', $order = '', $limit = '')
	{
		if($limit != '')
		{
			$limit = "LIMIT {$limit}";
		}

		if($order != '')
		{
			$order = "ORDER BY {$order}";
		}

		$sql = "SELECT {$fields} FROM `{$tableName}` WHERE {$condition} {$order} {$limit}";

		return $this->query($sql);
	}

	/**
	 * 插入 1条 或 多条 数据
	 * @param $tableName
	 * @param $data
	 * @return int
	 */
	public function insert_data($tableName, $data)
	{
		$fields_name  = array();
		$fields_value = array();

		$i   = 0;
		$j   = 0;
		$tmp = array();
		foreach($data as $key => $value)
		{
			if(is_array($value)) //多条记录
			{
				foreach($value as $subKey => $subValue)
				{
					$fields_name[] = $subKey;
					$tmp[$i][]     = $subValue;
				}
				$j = 1;
			}
			else //单条记录
			{
				$fields_name[]  = $key;
				$value          = $this->dateEscape($data);
				$fields_value[] = "'{$value}'";
			}
			$i++;
		}

		$fields_name = implode(',', array_unique($fields_name));
		if($j == 0)
		{
			$fields_value = implode(',', $fields_value);
			$fields_value = "({$fields_value})";
		}
		else
		{
			$tmp2 = array();
			foreach($tmp as $key => $value)
			{
				$tmp3 = array();
				foreach($value as $subValue)
				{
					$subValue = $this->dateEscape($subValue);
					$tmp3[]   = "'{$subValue}'";
				}
				$str = '';
				$str .= '(';
				$str .= implode(',', $tmp3);
				$str .= ')';
				$tmp2[] = $str;
			}
			$fields_value = implode(',', $tmp2);
		}

		$sql = "INSERT INTO `{$tableName}`({$fields_name}) VALUES{$fields_value}";
		mysql_query($sql, $this->conn);

		return mysql_affected_rows($this->conn);
	}

	/**
	 * 根据条件更新一条记录
	 * @param $tableName
	 * @param $data
	 * @param $condition
	 * @return int
	 */
	public function update_data($tableName, $data, $condition)
	{
		$tmp = array();
		foreach($data as $key => $value)
		{
			$value = $this->dateEscape($value);
			$tmp[] = "{$key}='{$value}'";
		}

		$set = implode(',', $tmp);
		$sql = "UPDATE `{$tableName}` SET {$set} WHERE {$condition}";
		mysql_query($sql, $this->conn);

		return mysql_affected_rows($this->conn);
	}

	/**
	 * 根据条件删除数据
	 * @param $tableName
	 * @param $condition
	 * @return int
	 */
	public function delete_data($tableName, $condition)
	{
		$sql = "DELETE FROM `{$tableName}` WHERE {$condition}";

		mysql_query($sql, $this->conn);

		return mysql_affected_rows($this->conn);
	}

	/**
	 * query 执行 SQL语句
	 * @param $sql
	 * @return array
	 */
	public function query($sql)
	{
		$query = mysql_query($sql, $this->conn);
		$tmp   = array();
		while($row = mysql_fetch_assoc($query))
		{
			$tmp[] = $row;
		}

		return $tmp;
	}

	/**
	 * 数据转义
	 * @param      $str
	 * @param bool $like
	 * @return array|mixed|string
	 */
	public function dateEscape($str, $like = false)
	{
		if(get_magic_quotes_gpc())
		{
			$str = stripslashes($str);
		}

		if(is_array($str))
		{
			foreach($str as $key => $val)
			{
				$str[$key] = dateEscape($val, $like);
			}

			return $str;
		}

		if(function_exists('mysql_real_escape_string'))
		{
			$str = addslashes($str);
		}
		elseif(function_exists('mysql_escape_string'))
		{
			$str = mysql_escape_string($str);
		}
		else
		{
			$str = addslashes($str);
		}

		if($like === true)
		{
			$str = str_replace(array('%', '_'), array('\\%', '\\_'), $str);
		}

		return $str;
	}
}