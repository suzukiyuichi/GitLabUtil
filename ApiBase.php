<?php

/**
 * GitLabAPI操作基底クラス
 *
 * @version    2013/09/16 yuichisuzuki
 * @since      2013/09/16
 * @author     yuichisuzuki
 * @copyright  (C)2013 yuichisuzuki
 */
class GLU_ApiBase {

	// ------------------------------------------------------------------------------------
	// 非公開部
	// ------------------------------------------------------------------------------------

	const HTTP_REQUEST_METHOD_GET    = 'GET';
	const HTTP_REQUEST_METHOD_POST   = 'POST';
	const HTTP_REQUEST_METHOD_PUT    = 'PUT';
	const HTTP_REQUEST_METHOD_DELETE = 'DELETE';

	/** @var $_baseUrl 		string	基底URL */
	private $_baseUrl;

	/** @var $_privateToken	string	アクセストークン */
	private $_privateToken;

	/**
	 * リクエストURL作成メソッド
	 * @param 	string 	$endpoint	エンドポイントのディレクトリ名
	 * @param 	array 	$params		URLパラメータ
	 * @param 	string	$method		メソッド名
	 * @return 	string				URL
	 */
	private function _createUrl($endpoint, $params, $method) {
		$query = '?private_token=' . $this->_privateToken . '&per_page=100';
		if ($method == self::HTTP_REQUEST_METHOD_GET) {
			$query .= '&' . http_build_query($params);
		}
		return "$this->_baseUrl$endpoint$query";
	}

	/**
	 * APIにリクエストを送るメソッド
	 * HTTP_RequestクラスだとPHP5.4環境でSTRICTが表示されるため独自にcURLで作成
	 * @param 	string 	$endpoint	エンドポイントのディレクトリ名
	 * @param 	array 	$params		URLパラメータ
	 * @param 	string	$method		メソッド名
	 * @return 	array	APIの戻り値
	 */
	private function _sendRequest($endpoint, $params, $method) {
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $this->_createUrl($endpoint, $params, $method));
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json',));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		if ($method == self::HTTP_REQUEST_METHOD_POST) {
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::HTTP_REQUEST_METHOD_POST);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		} elseif ($method == self::HTTP_REQUEST_METHOD_PUT) {
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::HTTP_REQUEST_METHOD_PUT);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		} elseif ($method == self::HTTP_REQUEST_METHOD_DELETE) {
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::HTTP_REQUEST_METHOD_DELETE);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		}

		$responseBody = curl_exec($curl);
		$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		curl_close($curl);

		return array('response' => json_decode($responseBody), 'status' => $statusCode);
	}
	// ------------------------------------------------------------------------------------
	// 非公開部
	// ------------------------------------------------------------------------------------
	/**
	 * コンストラクタ
	 *
	 * @param 	string	$baseUrl		基底URL
	 * @param 	string	$privateToken	アクセストークン
	 * @return return_type
	 */
	public function __construct($baseUrl, $privateToken) {
		$this->_baseUrl = $baseUrl;
		$this->_privateToken = $privateToken;
	}

	/**
	 * booleanをstring型に変換するメソッド
	 *
	 * @param 	bool	$bool		bool型の値
	 * @return 	string
	 */
	protected function bool2String($bool) {
		return ($bool === true) ? "1" : "0";
	}

	/**
	 * GETリクエスト送信メソッド
	 *
	 * @param 	string 	$endpoint	エンドポイントのディレクトリ名
	 * @param 	array 	$params		URLパラメータ
	 * @return 	array	APIの戻り値
	 */
	protected function get($endpoint, $params = array()) {
		return $this->_sendRequest($endpoint, $params, 'GET');
	}

	/**
	 * POSTリクエスト送信メソッド
	 *
	 * @param 	string 	$endpoint	エンドポイントのディレクトリ名
	 * @param 	array 	$params		URLパラメータ
	 * @return 	array	APIの戻り値
	 */
	protected function post($endpoint, $params = array()) {
		return $this->_sendRequest($endpoint, $params, 'POST');
	}

	/**
	 * PUTリクエスト送信メソッド
	 *
	 * @param 	string 	$endpoint	エンドポイントのディレクトリ名
	 * @param 	array 	$params		URLパラメータ
	 * @return 	array	APIの戻り値
	 */
	protected function put($endpoint, $params = array()) {
		return $this->_sendRequest($endpoint, $params, 'PUT');
	}

	/**
	 * DELETEリクエスト送信メソッド
	 *
	 * @param 	string 	$endpoint	エンドポイントのディレクトリ名
	 * @param 	array 	$params		URLパラメータ
	 * @return 	array	APIの戻り値
	 */
	protected function delete($endpoint, $params = array()) {
		return $this->_sendRequest($endpoint, $params, 'DELETE');
	}
}
