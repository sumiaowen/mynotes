<?php
/**
 * 简单的CSV文件导入、导出类
 * Created by PhpStorm.
 * User: sumiaowen
 * Contact: http://www.php230.com/
 * Date: 13-12-1
 * Time: 上午12:23
 * To change this template use File | Settings | File Templates.
 */
class MyCsv
{
	private $resource;

	/**
	 * @param string $fileName 文件路径
	 * @param string $mode     文件访问类型：w：写入、r：只读
	 */
	public function __construct($fileName, $mode)
	{
		$this->resource = fopen($fileName, $mode);
	}

	public function __destruct()
	{
		fclose($this->resource);
	}

	/**
	 * 导入CSV
	 * @param array $data
	 * @return int
	 */
	public function export($data)
	{
		fputcsv($this->resource, $data);
	}

	/**
	 * 导出CSV
	 * @return array
	 */
	public function import()
	{
		$tmp = array();
		while($data = fgetcsv($this->resource))
		{
			$tmp[] = $data;
		}

		return $tmp;
	}
}