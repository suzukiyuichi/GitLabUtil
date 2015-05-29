<?php
$classes = glob(dirname(__FILE__) . '/Endpoint/*.php');
array_unshift($classes, 'ApiBase.php');
foreach ($classes as $class) {
	require $class;
}

/**
 * GitLab操作クラス
 *
 * @version    2013/09/16 yuichisuzuki
 * @since      2013/09/16
 * @author     yuichisuzuki
 * @copyright  (C)2013 yuichisuzuki
 */
class GitLabUtil {

	public $project;
	public $user;

	public function __construct($domain, $token) {
		$this->project = new GLU_Project($domain, $token);
		$this->user = new GLU_User($domain, $token);
	}
}
