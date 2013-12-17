<?php
/**
 * Created by PhpStorm.
 * User: sumiaowen
 * Date: 13-12-16
 * Time: 21:24
 * To change this template use File | Settings | File Templates.
 */
class TestController extends Yaf_Controller_Abstract
{


	public function indexAction()
	{

		$memcache = new MyMemcache();
		$memcache->save_data('111', '111', 600);

		if($memcache->get_data('111'))
		{
			echo 'cache' . $memcache->get_data('111');
		}
		else
		{
			echo 'no cache';
		}

		return false;
	}

	public function nameAction()
	{

		echo 'sdfsdfsdf';

		return false;
	}

}