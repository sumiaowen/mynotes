<?php

/**
 * redis 简单操作类
 * Created by PhpStorm.
 * User: sumiaowen
 * Date: 13-12-20
 * Time: 下午2:54
 * To change this template use File | Settings | File Templates.
 */
class MyRedis
{
	private $redis = null;

	public function __construct()
	{
		$this->redis = new redis();

		$this->redis->connect(Yaf_Registry::get('config')->redis->host, Yaf_Registry::get('config')->redis->port);
	}

	public function __destruct()
	{
		$this->redis->close();
	}

	/**
	 * 获取一个redis链接实例
	 * @return object
	 */
	public function conn()
	{
		return $this->redis;
	}

	/**
	 * 设置一个有生命周期的key-value
	 * @param string $key     键
	 * @param string $value   值
	 * @param int    $valid   有效期，单位为秒
	 * @param bool   $replace 是否修改指定键的值
	 * @return bool
	 */
	public function setex($key, $valid, $value, $replace = false)
	{
		if($replace)
		{
			return $this->redis->setex($key, $valid, $value);
		}

		if(!$this->redis->exists($key))
		{
			return $this->redis->setex($key, $valid, $value);
		}
		else
		{
			return false;
		}
	}
}