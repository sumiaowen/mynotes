<?php
/**
 * Created by PhpStorm.
 * User: sumiaowen
 * Date: 13-12-3
 * Time: 下午4:37
 * To change this template use File | Settings | File Templates.
 */

/**
 * 字符串截取(注意编码格式)
 * @param   $string     string      需要截取的字符串
 * @param   $length     int         字符串截取的长度
 * @param   $postfix    string      截取后字符串后缀,默认为空
 * @return  string      string      截取后的字符串（包含后缀$postfix）
 */
function cutOutString($string, $length, $postfix = '')
{
	$result = (mb_strlen($string, 'utf-8') <= $length) ? $string : mb_substr($string, 0, $length, 'utf-8');

	return $result . $postfix;
}