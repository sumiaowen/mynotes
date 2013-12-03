<?php
/**
 * Created by PhpStorm.
 * User: sumiaowen
 * Date: 13-12-3
 * Time: 下午4:43
 * To change this template use File | Settings | File Templates.
 */

function dmysql_real_escape_string($str, $like = false)
{
	if(get_magic_quotes_gpc())
	{
		$str = stripslashes($str);
	}

	if(is_array($str))
	{
		foreach($str as $key => $val)
		{
			$str[$key] = dmysql_real_escape_string($val, $like);
		}

		return $str;
	}

	if(function_exists('mysql_real_escape_string'))
	{
		$str = mysql_real_escape_string($str);
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