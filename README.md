# GitLabUtil
PHPのGitLabクライアント(作り中)

  
## 利用方法
### 初期化   

```php
$baseUrl = 'http://hostname/api/v3/';
$token = 'privetaToken';
$gitlab = new GitLabUtil($baseUrl, $token);
```

### プロジェクト一覧の取得   

```php
/**
 * プロジェクトの情報を表示するメソッド
 * @param 	int 	$projectId			(任意)	プロジェクトのID(入力しない場合は全てのプロジェクトを表示する。)
 * @return 	array 						API空の返却結果
 */
public function find($projectId = null) 
```
   
例)  プロジェクト一覧を取得

```php
$gitlab->project->find();
```

例)  プロジェクトID「1」の情報を取得

```php
$gitlab->project->find(1);
```

  
### プロジェクト作成

```php
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
 * @return 	array 	API空の返却結果
 */
public function create($name, $description = null, $isPublic = null, $defaultBranch = null, $enableIssues = null,
					   $enableMergeRequest = null, $enableWiki = null, $enableWall = null, $enableSnippets = null)
```
   
例)  プロジェクト名「test」を作成

```php
$gitlab->project->create('test');
```

  
### プロジェクトのメンバー一覧の取得   

```php
/**
 * プロジェクトに所属するユーザを表示するメソッド
 *
 * @param 	int 	$projectId			(必須)	プロジェクトのID
 * @param 	int 	$userId				(任意)	ユーザのID
 * @return 	array 						API空の返却結果
 */
	public function getMember($projectId, $userId = null)
```
   
例)  プロジェクトID「120」のメンバー一覧を取得

```php
$gitlab->project->getMember(120);
```

例)  プロジェクトID「120」のメンバーID「5」情報を取得

```php
$gitlab->project->getMember(120, 5);
```

  
### プロジェクトメンバーの追加

```php
/**
 * プロジェクトに所属するユーザを追加するメソッド
 *
 * @param 	int 	$projectId			(必須)	プロジェクトのID
 * @param 	int 	$userId				(必須)	ユーザのID
 * @param 	int 	$accessLevel		(任意)	リポジトリのアクセスレベル(10:GUEST, 20:REPORTER, 30:DEVELOPER, 40:MASTER)
 * @return 	array 						APIからの返却結果
 */
public function addMember($projectId, $userId, $accessLevel = 30)
```
   
例)  プロジェクトID「10」のプロジェクトにメンバーID「5」のメンバーを追加

```php
$gitlab->project->addMember(10, 5);
```

  
### プロジェクトメンバーの削除

```php
/**
 * プロジェクトに所属するユーザを削除するメソッド
 *
 * @param 	int 	$projectId			(必須)	プロジェクトのID
 * @param 	int 	$userId				(必須)	ユーザのID
 * @return 	array 						API空の返却結果
 */
public function removeMember($projectId, $userId)
```
   
例)  プロジェクトID「10」のプロジェクトにメンバーID「5」のメンバーを削除

```php
$gitlab->project->removeMember(10, 5);
```

  
