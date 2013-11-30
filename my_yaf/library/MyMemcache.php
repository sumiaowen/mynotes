<?php
/**
 * 简易 memcache 操作类
 * Created by PhpStorm.
 * User: sumiaowen
 * Contact: http://www.php230.com/
 * Date: 13-12-1
 * Time: 上午12:05
 * To change this template use File | Settings | File Templates.
 */
class MyMemcache
{
	private $_memcache = null;

	public function __construct()
	{
		$this->_memcache = new memcache();
		$this->_memcache->connect(Yaf_Registry::get('config')->cache->memcache->host, Yaf_Registry::get('config')->cache->memcache->port);
	}

	/**
	 * 存储数据
	 * @param     $key    要设置值的key
	 * @param     $var    要存储的值，字符串和数值直接存储，其他类型序列化后存储。
	 * @param int $expire 有效期。此值设置为0表明此数据永不过期。你可以设置一个UNIX时间戳或 以秒为单位的整数（从当前算起的时间差）来说明此数据的过期时间，但是在后一种设置方式中，不能超过 2592000秒（30天）
	 * @return bool
	 */
	public function save_data($key, $var, $expire = 3600)
	{
		return $this->_memcache->set($key, $var, 0, $expire);
	}

	/**
	 * 替换数据
	 * @param     $key    要设置值的key
	 * @param     $var    要存储的值，字符串和数值直接存储，其他类型序列化后存储。
	 * @param int $expire 有效期。此值设置为0表明此数据永不过期。你可以设置一个UNIX时间戳或 以秒为单位的整数（从当前算起的时间差）来说明此数据的过期时间，但是在后一种设置方式中，不能超过 2592000秒（30天）
	 * @return bool
	 */
	public function replace_data($key, $var, $expire = 3600)
	{
		return $this->_memcache->replace($key, $var, 0, $expire);
	}

	/**
	 * 获取数据
	 * @param $key 要获取值的key
	 * @return array|string
	 */
	public function get_data($key)
	{
		return $this->_memcache->get($key);
	}

	/**
	 * 删除数据
	 * @param string $key     要删除值的key
	 * @param int    $timeout 删除该值的执行时间。如果值为0,则该元素立即删除，如果值为30,元素会在30秒内被删除。
	 * @return bool
	 */
	public function delete_data($key, $timeout = 0)
	{
		return $this->_memcache->delete($key, $timeout);
	}

	/**
	 * 清除所有memcache值
	 */
	public function clean_data()
	{
		return $this->_memcache->flush();
	}
}