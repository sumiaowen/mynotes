<?php
/**
 * PHP 导入、导出CSV文件
 * Created by PhpStorm.
 * User: sumiaowen
 * Date: 13-11-26
 * Time: 下午1:35
 * To change this template use File | Settings | File Templates.
 */
class csv
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
	 *  导出CSV
	 * @param bool $change
	 * @return array
	 */
	public function import($change = true)
	{
		$tmp = array();
		while($data = fgetcsv($this->resource))
		{
			$line = array();
			foreach($data as $value)
			{
				$line[] = ($change) ? strtolower(iconv('gb2312', 'utf-8', $value)) : $value;
			}
			$tmp[] = $line;
		}

		return $tmp;
	}
}
