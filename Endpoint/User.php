<?php

/**
 * ユーザー関連API操作クラス
 * LDAP経由での利用が前提であるためユーザーのcreate,deleteは実装せず
 *
 * @version    2013/09/16 yuichisuzuki
 * @since      2013/09/16
 * @author     yuichisuzuki
 * @copyright  (C)2013 yuichisuzuki
 */
class GLU_User extends GLU_ApiBase {

	// ------------------------------------------------------------------------------------
	// 公開部
	// ------------------------------------------------------------------------------------
	/**
	 * ユーザーの一覧を表示するメソッド
	 * @param 	int 	$userId				(任意)	ユーザーのID(入力しない場合は全てのプロジェクトを表示する。)
	 * @return 	array 						API空の返却結果
	 */
	public function find($userId = null) {
		if (empty($userId)) {
			return $this->get('/users');
		} else {
			return $this->get('/users/' . $userId);
		}
	}

	/**
	 * 現在ログ飲されているユーザーを取得するメソッド
	 *
	 * @return return_type
	 */
	public function getCurrentUser() {
		return $this->get('/user');
	}
}
