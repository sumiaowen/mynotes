<?php
/**
 * Created by PhpStorm.
 * User: sumiaowen
 * Date: 13-11-28
 * Time: 下午3:55
 * To change this template use File | Settings | File Templates.
 */

//表单数据安全验证：

//1、数据类型转换，如：(int)、(string)......
$pageNum = (int)$_GET['page'];	//页码


######################################################
//2、验证数据长度

/**
 * 字符串截取,注意字符编码
 * @param   $string     string      需要截取的字符串
 * @param   $length     int         字符串截取的长度
 * @param   $postfix    string      截取后字符串后缀,默认为空
 * @return  string      string      截取后的字符串（包含后缀$postfix）
 */
function cutOutString($string, $length, $postfix='') {
	$result = (mb_strlen($string, 'utf-8') <= $length) ? $string : mb_substr($string, 0, $length, 'utf-8');
	return $result.$postfix;
}

######################################################
//3、正则判断

######################################################
//4、数据转义

######################################################
//5、特殊字符替换

######################################################
//6、格式化数据，如:strip_tags

######################################################
//7、表单域名和数据库字段名不同

######################################################
//8、防止远程表单提交
