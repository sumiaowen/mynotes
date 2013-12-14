<?php
/**
 * Created by PhpStorm.
 * User: sumiaowen
 * Contact: http://www.php230.com/
 * Date: 13-12-2
 * Time: 下午9:15
 * To change this template use File | Settings | File Templates.
 */
include 'discuzPost.php';

$database             = array();
$database['dns']      = 'mysql:host=localhost;dbname=discuz';
$database['username'] = 'root';
$database['password'] = '123456';

$fid          = 2;
$title        = '11111111111';
$content      = '2222222222';
$author       = 'admin';
$author_id    = 1;
$displayorder = 0;

$discuz = new discuzPost($database, $fid, $title, $content, $author, $author_id, $displayorder);

echo $discuz->post_posts();