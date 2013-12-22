<?php

/**
 * Created by PhpStorm.
 * User: sumiaowen
 * Date: 13-12-22
 * Time: 22:43
 * To change this template use File | Settings | File Templates.
 */
class ChannelController extends Yaf_Controller_Abstract
{
	public function IndexAction()
	{
		$bytenews = new Yaf_Config_Ini(APPLICATION_PATH . "/conf/bytenews.ini",'bytenews');

		echo $bytenews->app->channel->id;

		return false;
	}
}