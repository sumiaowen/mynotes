<?php

/**
 * Created by PhpStorm.
 * User: sumiaowen
 * Date: 13-12-18
 * Time: 22:40
 * To change this template use File | Settings | File Templates.
 */
class Test_TestController extends Yaf_Controller_Abstract
{
	public function IndexAction()
	{
		echo $_GET['id'];
		return false;
	}
}