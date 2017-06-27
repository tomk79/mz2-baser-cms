<?php
/**
 * Morizke 2 - baserCMS Export
 */
namespace tomk79\pickles2\mz2_baser_cms;

class core{

	/** Filesystem Utility */
	private $fs;

	/** Entry Script */
	private $path_entry_script;

	/** CMS settings */
	private $cms_settings;

	/** Options */
	private $options;

	/** Error Messages */
	private $errors;

	/**
	 * Constructor
	 */
	public function __construct( $path_entry_script, $cms_settings = array(), $options = array() ){
		$this->path_entry_script = $path_entry_script;
		$this->cms_settings = $cms_settings;
		$this->options = $options;

		// 初期化
		$this->fs = new \tomk79\filesystem();
		$this->errors = array();

		// CMS設定を整理
		$this->cms_settings = json_decode( json_encode( $this->cms_settings ) );

		// オプション値を整理
		$this->options = json_decode( json_encode( $this->options ) );
		if( !@is_object($this->options) ){
			$this->options = json_decode('{}');
		}
		if( !@is_array($this->options->commands) ){
			@$this->options->commands = json_decode('{}');
		}
		if( !@strlen($this->options->commands->php) ){
			$this->options->commands->php = 'php';
		}
		if( !@strlen($this->options->php_ini) ){
			$this->options->php_ini = null;
		}
		if( !@strlen($this->options->php_extension_dir) ){
			$this->options->php_extension_dir = null;
		}
	}

	/**
	 * $fs を取得する
	 * @return object `$fs`
	 */
	public function fs(){
        return $this->fs;
    }

	/**
	 * 出力を実行する
	 * @return boolean 実行結果の真偽
	 */
	public function execute( $path_output ){
		if( !strlen( $path_output ) || !is_string( $path_output ) ){
			$this->error('Output path is required.');
			return false;
		}
		if( !is_dir( dirname($path_output) ) ){
			$this->error('Output directory is not exists.');
			return false;
		}

		// Pickles 2 の環境情報を取得
		$project_info_all = $this->query('/?PX=px2dthelper.get.all', array(), $val);
		$project_info_all = @json_decode($project_info_all);
		if( !is_object($project_info_all) ){
			$this->error('Failed to load project info from `/?PX=px2dthelper.get.all`.');
			return false;
		}
		// var_dump($project_info_all);

		// Temporary Directory
		$path_tmp_dir = $project_info_all->realpath_homedir.'_sys/ram/caches/mz2-baser-cms-'.urlencode(date('Ymd-His')).'/';
		// var_dump($path_tmp_dir);

		// Template Directory
		$path_template_dir = __DIR__.'/../zip_template/';

		// 一旦雛形を展開
		$this->fs->copy_r($path_template_dir, $path_tmp_dir.'exports/');

		// Pickles 2 からデータを出力
		// TODO: ここがメインの処理
		var_dump('TODO: Pickles 2 からデータを出力');

		$sitemap = $this->query('/?PX=api.get.sitemap', array(), $val);
		$sitemap = @json_decode($sitemap);
		if( !is_object($sitemap) ){
			$this->error('Failed to load sitemap list from `/?PX=px2dthelper.get.sitemap`.');
			return false;
		}
		// var_dump($sitemap);

		// $sitemap = new export_sitemap( $this->path_entry_script, $this->cms_settings, $this->options );


		// ZIPファイルに固める
		$this->zip($path_tmp_dir.'exports/', $path_output);

		return true;
	}

	/**
	 * ZIPアーカイブを生成する
	 * @return array 状態および成否情報
	 */
	public function zip($path_target_dir, $path_zip_to){
		$rtn = array(
			'result' => false,
			'files' => 0,
			'status' => null,
		);

		// 既存のZIPが存在する場合はファイルが追加されてしまうので、
		// 一旦内容を消さなければいけない。
		$this->fs->save_file($path_zip_to, '');

		// ZipArchive オブジェクト生成
		$zip = new \ZipArchive();
		$filename = $path_zip_to;

		if ($zip->open($filename, \ZipArchive::CREATE)!==TRUE) {
			// exit("cannot open <$filename>\n");
			return $rtn;
		}

		// 対象フォルダに移動して、ファイルを1つずつ追加する
		$tmp_cd = realpath('.');
		chdir($path_target_dir);
		$filelist = glob("**/*");
		foreach($filelist as $localpath){
			$zip->addFile($localpath);
		}
		chdir($tmp_cd); // もとのディレクトリに帰る

		$rtn['result'] = true;
		$rtn['files'] = $zip->numFiles;
		$rtn['status'] = $zip->status;
		$zip->close();
		return $rtn;
	}

	/**
	 * エラーメッセージを発行
	 * @param  string $msg エラーメッセージ
	 * @return boolean true
	 */
	public function error($msg){
		array_push( $this->errors, $msg );
		return true;
	}

	/**
	 * エラーメッセージを発行
	 * @return array エラーメッセージ一覧
	 */
	public function get_errors(){
		return $this->errors;
	}

	/**
	 * Pickles 2 にクエリを発行し、結果を受け取る
	 *
	 * @param string $request_path リクエストを発行する対象のパス
	 * @param array $options Pickles 2 へのコマンド発行時のオプション
	 * - output = 出力形式。`json` を指定すると、JSON形式の出力を受けられます。
	 * - user_agent = `HTTP_USER_AGENT` 文字列。 `user_agent` が空白の場合、または文字列 `PicklesCrawler` を含む場合には、パブリッシュツールからのアクセスであるとみなされます。
	 * @param array $return_var コマンドの終了コードを格納して返します (`passthru()` の第2引数として渡されます)
	 * @return mixed サブリクエストの実行結果。
	 * 通常は 得られた標準出力をそのまま文字列として返します。
	 * `output` オプションに `json` が指定された場合、 `json_decode()` された値が返却されます。
	 */
	public function query($request_path, $options = null, &$return_var = null){
		if(!is_string($request_path)){
			$this->error('Invalid argument supplied for 1st option $request_path in $px->internal_sub_request(). It required String value.');
			return false;
		}
		if(!strlen($request_path)){ $request_path = '/'; }
		if(is_null($options)){ $options = array(); }
		$php_command = array();
		array_push( $php_command, $this->options->commands->php );
		if( strlen(@$this->options->php_ini) ){
			$php_command = array_merge(
				$php_command,
				array(
					'-c', @$this->options->php_ini,// ← php.ini のパス
				)
			);
		}
		if( strlen(@$this->options->php_extension_dir) ){
			$php_command = array_merge(
				$php_command,
				array(
					'-d', @$this->options->php_extension_dir,// ← php.ini definition
				)
			);
		}
		array_push($php_command, $this->path_entry_script);
		if( @$options['output'] == 'json' ){
			array_push($php_command, '-o');
			array_push($php_command, 'json');
		}
		if( @strlen($options['user_agent']) ){
			array_push($php_command, '-u');
			array_push($php_command, $options['user_agent']);
		}
		array_push($php_command, $request_path);


		$cmd = array();
		foreach( $php_command as $row ){
			$param = escapeshellarg($row);
			array_push( $cmd, $param );
		}
		$cmd = implode( ' ', $cmd );
		ob_start();
		@passthru( $cmd, $return_var );
		$bin = ob_get_clean();

		if( @$options['output'] == 'json' ){
			$bin = json_decode($bin);
		}

		return $bin;
	} // query()

}
