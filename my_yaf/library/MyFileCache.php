<?php
/**
 * 文件缓存
 * Created by PhpStorm.
 * User: sumiaowen
 * Contact: http://www.php230.com/
 * Date: 13-11-30
 * Time: 下午11:10
 * To change this template use File | Settings | File Templates.
 */
include 'ThirdPart/Lite.php';
class MyFileCache
{
	public $_cache = '';
	public $path = '';
	public $option = array();

	public function __construct($cache_option = array())
	{
		$this->path   = $cache_option['cacheDir'];
		$this->option = $cache_option;

		//文件缓存路径
		$this->option['cacheDir'] = $this->path;

		//缓存所在的组,默认为 default
		$this->option['group'] = isset($cache_option['group']) ? $cache_option['group'] : 'default';

		//缓存有效期，默认为3600秒
		$this->option['lifeTime'] = isset($cache_option['lifeTime']) ? $cache_option['lifeTime'] : 3600;

		//是否开启对缓存文件名的保护,默认开启
		$this->option['fileNameProtection'] = isset($cache_option['fileNameProtection']) ? $cache_option['fileNameProtection'] : true;

		//是否开启自动清除过期缓存操作，默认为开启，该操作发生在新缓存写入时
		$this->option['automaticCleaningFactor'] = isset($cache_option['automaticCleaningFactor']) ? $cache_option['automaticCleaningFactor'] : 1;

		//是否开启递归目录，默认不开启,1为递归1层目录，2为递归2层目录
		$this->option['hashedDirectoryLevel'] = isset($cache_option['hashedDirectoryLevel']) ? $cache_option['hashedDirectoryLevel'] : 0;

		//开启递归目录时，创建目录时的权限值，默认为0777
		$this->option['hashedDirectoryUmask'] = isset($cache_option['hashedDirectoryUmask']) ? $cache_option['hashedDirectoryUmask'] : '0777';

		$this->_cache = new Cache_Lite($this->option);
	}

	public function __destruct()
	{
		unset($this->_cache);
	}

	/**
	 * @param string $cache_data 需要缓存的数据
	 * @param  mixed $cache_id   缓存ID，须唯一
	 * @return bool
	 */
	public function save_cache($cache_data, $cache_id)
	{
		if(!file_exists($this->path))
		{
			mkdir($this->path, 0777, true);
		}

		return $this->_cache->save($cache_data, $cache_id);
	}

	/**
	 * @param $cache_id
	 * @return mixed
	 */
	public function get_cache($cache_id)
	{
		$result = $this->_cache->get($cache_id);

		return $result;
	}

	/**
	 * @return mixed
	 */
	public function delete_cache()
	{
		return $this->_cache->clean();
	}
}