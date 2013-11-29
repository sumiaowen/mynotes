<?php
/**
 * snoopy使用示例
 * Created by PhpStorm.
 * User: sumiaowen
 * Date: 13-11-27
 * Time: 下午1:32
 * To change this template use File | Settings | File Templates.
 */
include 'Snoopy.class.php';

$snoopy = new Snoopy();

//浏览器模拟
$snoopy->agent                         = "(compatible; MSIE 4.01; MSN 2.5; AOL 4.0; Windows 98)";
$snoopy->referer                       = '127.0.0.1';
$snoopy->rawheaders["Pragma"]          = "no-cache";
$snoopy->rawheaders["X_FORWARDED_FOR"] = "127.0.0.11";

$url = 'http://127.0.0.1/test/github/snoopy-use-examples/doSubmit.php';

////获取页面内容
//$snoopy->fetch($url);
//
////获取页面中的所有链接
//$snoopy->fetchlinks($url);
//
////获取页面中 form表单元素内容(即获取form表单所有HTML代码)
//$snoopy->fetchform($url);
//
////获取页面中所有的文字，实际就是fetch获取内容后，通过strip_tags去除html标签
//$snoopy->fetchtext($url);

//POST表单提交，返回所有数据
//submit 总共有3个参数，第一个参数为提交的地址，第二个参数为各各表单域值，第三个参数为附件地址
$formvars = array('username' => 'test12313');
//$snoopy->submit($url,$formvars);

//post表单提交，清除所有的HTML标签和其他数据，只返回链接
//$snoopy->submitlinks($url,$formvars);

//post表单提交,清除所有的HTML标签和其他数据，只返回文本数据
$snoopy->submittext($url, $formvars);

$result = $snoopy->results;
myPrint($result);

function myPrint($param)
{
	echo '<pre>';
	print_r($param);
	echo '</pre><hr>';
	unset($param);
}