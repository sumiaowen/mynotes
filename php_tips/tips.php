<?php
/**
 * 记录PHP 小技巧
 * Created by PhpStorm.
 * User: sumiaowen
 * Contact: http://www.php230.com/
 * Date: 13-12-3
 * Time: 下午10:55
 * To change this template use File | Settings | File Templates.
 */

//1、in_array()函数，该函数会把值转换成整型后，再做比较，建议使用时加上第三个参数true

//该例子将输出：one
if(in_array('01', array('1')))
{
	echo 'one';
}
elseif(in_array('01', array('1'), true))
{
	echo 'two';
}

function daYin($param)
{
	echo '<pre>';
	var_dump($param);
	echo '</pre><hr>';
}