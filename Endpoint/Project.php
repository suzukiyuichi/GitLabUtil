<?php

/**
 * LibGitLab$Project
 *
 * @version    2013/09/16 yuichisuzuki
 * @since      2013/09/16
 * @author     yuichisuzuki
 * @copyright  (C)2013 yuichisuzuki
 */
class GLU_Project extends GLU_ApiBase {

	// ------------------------------------------------------------------------------------
	// 公開部
	// ------------------------------------------------------------------------------------
	/**
	 * プロジェクトの情報を表示するメソッド
	 * @param 	int 	$projectId			(任意)	プロジェクトのID(入力しない場合は全てのプロジェクトを表示する。)
	 * @return 	array 						API空の返却結果
	 */
	public function find($projectId = null) {
		if (empty($projectId)) {
			return $this->get('/projects');
		} else {
			return $this->get('/projects/' . $projectId);
		}
	}

	/**
	 * プロジェクトの新規するメソッド
	 * @param 	string 	$name				(必須)	プロジェクト名
	 * @param	string	$description		(任意)	説明
	 * @param	bool	$isPublic			(任意)	Publicアクセスを許可するか。(デフォルトはfalse)
	 * @param	string	$defaultBranch		(任意)	デフォルトのブランチ名。(デフォルトはmaster)
	 * @param	bool	$enableIssues		(任意)	Issuesの登録を許可するか。(デフォルトはtrue)
	 * @param	bool	$enableMergeRequest	(任意)	MergeRequestを許可するか。(デフォルトはtrue)
	 * @param	bool	$enableWiki			(任意)	Wikiを許可するか。(デフォルトはtrue)
	 * @param	bool	$enableWall			(任意)	Wall(SimpleChat)を許可するか。(デフォルトはfalse)
	 * @param	bool	$enableSnippets		(任意)	Snippetを許可するか。(デフォルトはfalse)
	 * @return 	array 	API空の返却結果
	 */
	public function create($name, $description = null, $isPublic = null, $defaultBranch = null, $enableIssues = null,
						   $enableMergeRequest = null, $enableWiki = null, $enableWall = null, $enableSnippets = null) {
		$array = array();
		$array['name'] = $name;
		if (!is_null($description)) {
			$array['description'] = $description;
		}
		if (!is_null($isPublic)) {
			$array['public'] = $this->bool2String($isPublic);
		}
		if (!is_null($defaultBranch)) {
			$array['default_branch'] = $defaultBranch;
		}
		if (!is_null($enableIssues)) {
			$array['issues_enabled'] = $this->bool2String($enableIssues);
		}
		if (!is_null($enableMergeRequest)) {
			$array['merge_requests_enabled'] = $this->bool2String($enableMergeRequest);
		}
		if (!is_null($enableWiki)) {
			$array['wiki_enabled'] = $this->bool2String($enableWiki);
		}
		if (!is_null($enableWall)) {
			$array['wall_enabled'] = $this->bool2String($enableWall);
		}
		if (!is_null($enableSnippets)) {
			$array['snippets_enabled'] = $this->bool2String($enableSnippets);
		}

		return $this->post('/projects', $array);
	}

	/**
	 * プロジェクトに所属するユーザを表示するメソッド
	 *
	 * @param 	int 	$projectId			(必須)	プロジェクトのID
	 * @param 	int 	$userId				(任意)	ユーザのID
	 * @return 	array 						API空の返却結果
	 */
	public function getMember($projectId, $userId = null) {
		if (empty($userId)) {
			return $this->get('/projects/' . $projectId . '/members');
		} else {
			return $this->get('/projects/' . $projectId . '/members/' . $userId);
		}
	}

	/**
	 * プロジェクトに所属するユーザを追加するメソッド
	 *
	 * @param 	int 	$projectId			(必須)	プロジェクトのID
	 * @param 	int 	$userId				(必須)	ユーザのID
	 * @param 	int 	$accessLevel		(任意)	リポジトリのアクセスレベル
	 * @return 	array 						API空の返却結果
	 */
	public function addMember($projectId, $userId, $accessLevel = 30) {
		$array = array();
		$array['id'] = $projectId;
		$array['user_id'] = $userId;
		$array['access_level'] = $accessLevel;

		return $this->post("/projects/{$array['id']}/members", $array);
	}

	/**
	 * プロジェクトに所属するユーザを削除するメソッド
	 *
	 * @param 	int 	$projectId			(必須)	プロジェクトのID
	 * @param 	int 	$userId				(必須)	ユーザのID
	 * @return 	array 						API空の返却結果
	 */
	public function removeMember($projectId, $userId) {
		$array = array();
		$array['id'] = $projectId;
		$array['user_id'] = $userId;

		return $this->delete("/projects/{$array['id']}/members/{$array['user_id']}");
	}

	/**
	 * 公開レベル一覧を取得するメソッド
	 *
	 * @return array 公開レベルの配列
	 */
	public function getAccessLevel() {
		$array = array();
		$array['10'] = 'GUEST';
		$array['20'] = 'REPORTER';
		$array['30'] = 'DEVELOPER';
		$array['40'] = 'MASTER';
	}

	/**
	 * プロジェクトのhookを表示するメソッド
	 *
	 * @param 	int 	$projectId			(必須)	プロジェクトのID
	 * @param 	int 	$hookId				(任意)	hooksのID
	 * @return 	array 						API空の返却結果
	 */
	public function getHook($projectId, $hookId = null) {
		if (empty($hookId)) {
			return $this->get('/projects/' . $projectId . '/hooks');
		} else {
			return $this->get('/projects/' . $projectId . '/hooks/' . $hookId);
		}
	}

	/**
	 * プロジェクトにhookを追加するメソッド
	 *
	 * @param 	int 	$projectId			(必須)	プロジェクトのID
	 * @param 	string 	$url				(必須)	hooksのurl
	 * @return 	array 						API空の返却結果
	 */
	public function addHook($projectId, $url) {
		$array = array();
		$array['id'] = $projectId;
		$array['url'] = $url;
		return $this->post("/projects/{$array['id']}/hooks", $array);
	}

	/**
	 * プロジェクトのhookを削除するメソッド
	 *
	 * @param 	int 	$projectId			(必須)	プロジェクトのID
	 * @param 	int 	$hookId				(必須)	hooksのID
	 * @return 	array 						API空の返却結果
	 */
	public function removeHook($projectId, $hookId) {
		$array = array();
		$array['id'] = $projectId;
		$array['hook_id'] = $hookId;

		return $this->delete("/projects/{$array['id']}/hooks/{$array['hook_id']}", $array);
	}

	/**
	 * プロジェクトのissueを表示するメソッド
	 *
	 * @param 	int 	$projectId			(必須)	プロジェクトのID
	 * @param 	int 	$issueId			(任意)	issueのID
	 * @return 	array 						API空の返却結果
	 */
	public function getIssue($projectId, $issueId = null) {
		if (empty($issueId)) {
			return $this->get('/projects/' . $projectId . '/issues');
		} else {
			return $this->get('/projects/' . $projectId . '/issues/' . $issueId);
		}
	}

	/**
	 * プロジェクトにissueを追加するメソッド
	 *
	 * @param 	int 	$projectId			(必須)	プロジェクトのID
	 * @param 	string 	$title				(必須)	タイトル
	 * @param 	string 	$description		(任意)	説明
	 * @param 	int 	$assigneeId			(任意)	アサインするユーザのID
	 * @param 	int 	$milestoneId		(任意)	マイルストーンのID
	 * @param 	string 	$labels				(任意)	ラベル
	 * @return 	array 						API空の返却結果
	 */
	public function addIssue($projectId, $title, $description = null, $assigneeId = null, $milestoneId = null, $labels = null) {
		$array = array();
		$array['id'] = $projectId;
		$array['title'] = $title;
		if (!is_null($description)) {
			$array['description'] = $description;
		}
		if (!is_null($assigneeId)) {
			$array['assignee_id'] = $assigneeId;
		}
		if (!is_null($milestoneId)) {
			$array['milestone_id'] = $milestoneId;
		}
		if (!is_null($labels)) {
			$array['labels'] = $labels;
		}
		return $this->post('/projects/' . $array['id'] . '/issues', $array);
	}

	/**
	 * プロジェクトのissueを削除するメソッド
	 *
	 * @param 	int 	$projectId			(必須)	プロジェクトのID
	 * @param 	int 	$issueId			(必須)	issueのID
	 * @return 	array 						API空の返却結果
	 */
	public function removeIssue($projectId, $issueId) {
		$array = array();
		$array['id'] = $projectId;
		$array['issue_id'] = $issueId;
		return $this->delete("/projects/{$array['id']}/issues/{$array['issue_id']}", $array);
	}

	/**
	 * プロジェクトのbranchを表示するメソッド
	 *
	 * @param 	int 	$projectId			(必須)	プロジェクトのID
	 * @param 	string 	$branch				(任意)	branch
	 * @return 	array 						API空の返却結果
	 */
	public function getBranch($projectId, $branch = null) {
		if (empty($branch)) {
			return $this->get('/projects/' . $projectId . '/repository/branches');
		} else {
			return $this->get('/projects/' . $projectId . '/repository/branches/' . $branch);
		}
	}

	/**
	 * プロジェクトのtagを表示するメソッド
	 *
	 * @param 	int 	$projectId			(必須)	プロジェクトのID
	 * @return 	array 						API空の返却結果
	 */
	public function getTag($projectId) {
		return $this->get('/projects/' . $projectId . '/repository/tags');
	}

	/**
	 * プロジェクトのコミット履歴を表示するメソッド
	 *
	 * @param 	int 	$projectId			(必須)	プロジェクトのID
	 * @param 	string 	$refName			(任意)	参照するbranch名もしくはtag名。省略時はdefaultのbranch
	 * @return 	array 						API空の返却結果
	 */
	public function getCommitHistory($projectId, $refName = null) {
		$array = array();

		if (!is_null($refName)) {
			$array['ref_name'] = $refName;
		}
		return $this->get('/projects/' . $projectId . '/repository/commits', $array);
	}

	/**
	 * プロジェクトのリポジトリツリーを表示するメソッド
	 *
	 * @param 	int 	$projectId			(必須)	プロジェクトのID
	 * @param 	string 	$path				(任意)	内部リポジトリのpath
	 * @param 	string 	$refName			(任意)	参照するbranch名もしくはtag名。省略時はdefaultのbranch
	 * @return 	array 						API空の返却結果
	 */
	public function geRepositoryTree($projectId, $path = null, $refName = null) {
		$array = array();

		if (!is_null($path)) {
			$array['path'] = $path;
		}
		if (!is_null($refName)) {
			$array['ref_name'] = $refName;
		}
		return $this->get('/projects/' . $projectId . '/repository/tree', $array);
	}
}