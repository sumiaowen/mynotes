<?php
/**
 * 模拟discuz发贴
 * Created by PhpStorm.
 * User: sumiaowen
 * Contact: http://www.php230.com/
 * Date: 13-12-2
 * Time: 下午8:14
 * To change this template use File | Settings | File Templates.
 */
include '../pdo_mysql_class/myPdo.php';

class discuzPost
{
	private $pdo = null;
	private $fid = null; //发帖版块ID
	private $title = null; //帖子标题
	private $content = null; //帖子内容
	private $author = null; //发帖用户名
	private $author_id = null; //发帖用户UID
	private $current_time = null; //发帖时间
	private $displayorder = null; //0:正常，-2:待审核

	public function __construct($pdoParams, $fid, $title, $content, $author, $author_id, $displayorder)
	{
		//链接数据库
		$this->pdo = myPdo::get_instance($pdoParams);

		//设置帖子信息
		$this->fid          = $fid;
		$this->title        = $title;
		$this->content      = $content;
		$this->author       = $author;
		$this->author_id    = $author_id;
		$this->displayorder = $displayorder;
	}

	public function post_posts()
	{
		$this->current_time = $_SERVER['REQUEST_TIME'];

		$tid = $this->do_pre_forum_thread();

		if(!$tid)
		{
			return '更新表 pre_forum_thread 失败<br />';
		}

		$pid = $this->do_pre_forum_post_tableid();

		if(!$this->do_pre_forum_post($pid, $tid))
		{
			return '更新表 pre_forum_post 失败<br />';
		}

		if(!$this->do_pre_forum_forum())
		{
			return '更新表 pre_forum_forum 失败<br />';
		}

		if($this->displayorder == -2)
		{
			if(!($this->do_pre_forum_thread_moderate($tid)))
			{
				return '更新表 pre_forum_thread_moderate 失败<br />';
			}
		}

		return ($this->do_pre_common_member_count()) ? '发帖成功<br />' : '更新表 pre_pre_common_member_count 失败<br />';
	}

	private function do_pre_forum_thread()
	{
		$data                  = array();
		$data[':fid']          = $this->fid;
		$data[':author']       = $this->author;
		$data[':authorid']     = $this->author_id;
		$data[':subject']      = $this->title;
		$data[':dateline']     = $this->current_time;
		$data[':lastpost']     = $this->current_time;
		$data[':lastposter']   = $this->author;
		$data[':displayorder'] = $this->displayorder;

		$sql = "insert into
				pre_forum_thread(fid,author,authorid,subject,dateline,lastpost,lastposter,displayorder)
				values(:fid,:author,:authorid,:subject,:dateline,:lastpost,:lastposter,:displayorder)";

		$result = $this->pdo->execution($sql, $data);

		if($result)
		{
			return $this->pdo->getLastInsertId();
		}

		return false;
	}

	private function do_pre_forum_post_tableid()
	{
		$sql    = "INSERT INTO `pre_forum_post_tableid`(`pid`) VALUES(NULL)";
		$result = $this->pdo->execution($sql);
		if($result)
		{
			return $this->pdo->getLastInsertId();
		}

		return false;
	}

	private function do_pre_forum_post($pid, $tid)
	{
		$data              = array();
		$data[':pid']      = $pid;
		$data[':fid']      = $this->fid;
		$data[':tid']      = $tid;
		$data[':first']    = 1;
		$data[':author']   = $this->author;
		$data[':authorid'] = $this->author_id;
		$data[':subject']  = $this->title;
		$data[':dateline'] = $this->current_time;
		$data[':message']  = $this->content;

		$sql = "insert into
				pre_forum_post(pid,fid,tid,first,author,authorid,subject,dateline,message)
				values(:pid,:fid,:tid,:first,:author,:authorid,:subject,:dateline,:message)";

		$result = $this->pdo->execution($sql, $data);

		return ($result) ? true : false;
	}

	private function do_pre_forum_forum()
	{
		$sql = "UPDATE `pre_forum_forum` SET `threads`=threads+1,`posts`=posts+1,`todayposts`=todayposts+1 WHERE `fid`=:fid";

		$result = $this->pdo->execution($sql, array(':fid' => $this->fid));

		return ($result) ? true : false;
	}

	private function do_pre_forum_thread_moderate($tid)
	{
		$data              = array();
		$data[':tid']      = $tid;
		$data[':status']   = 0;
		$data[':dateline'] = $this->current_time;

		$sql = "insert into pre_forum_thread_moderate(tid,status,dateline) values(:tid,:status,:dateline)";

		$result = $this->pdo->execution($sql, $data);

		return ($result) ? true : false;
	}

	private function do_pre_common_member_count()
	{
		$sql = "UPDATE `pre_common_member_count` SET `threads`=threads+1 WHERE `uid`=:uid";

		$result = $this->pdo->execution($sql, array(':uid' => $this->author_id));

		return ($result) ? true : false;
	}
}