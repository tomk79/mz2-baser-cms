<?php
/**
 * Morizke 2 - baserCMS Export
 */
namespace tomk79\pickles2\mz2_baser_cms;

class main{

	/** Core Object */
	private $core;

	/**
	 * Constructor
	 */
	public function __construct( $path_entry_script, $cms_settings = array(), $options = array() ){

		// coreオブジェクト生成
		$this->core = new core( $path_entry_script, $cms_settings, $options );

	}

	/**
	 * 出力を実行する
	 * @return boolean 実行結果の真偽
	 */
	public function export( $path_output ){
		if( !strlen( $path_output ) || !is_string( $path_output ) ){
			$this->core->error('Output path is required.');
			return false;
		}
		if( !is_dir( dirname($path_output) ) ){
			$this->core->error('Output directory is not exists.');
			return false;
		}

		// Pickles 2 の環境情報を取得
		$project_info_all = $this->core->px2query('/?PX=px2dthelper.get.all', array(), $val);
		$project_info_all = @json_decode($project_info_all);
		if( !is_object($project_info_all) ){
			$this->core->error('Failed to load project info from `/?PX=px2dthelper.get.all`.');
			return false;
		}
		// var_dump($project_info_all);

		// Temporary Directory
		$path_tmp_dir = $project_info_all->realpath_homedir.'_sys/ram/caches/mz2-baser-cms-'.urlencode(date('Ymd-His')).'/';
		// var_dump($path_tmp_dir);

		// Template Directory
		$path_template_dir = __DIR__.'/../zip_template/';

		// 一旦雛形を展開
		$this->core->fs()->copy_r($path_template_dir, $path_tmp_dir.'exports/');

		// Pickles 2 からデータを出力
		$export_sitemap = new export_sitemap( $this->core );
		$export_sitemap->export($path_tmp_dir);


		// ZIPファイルに固める
		$this->core->zip($path_tmp_dir.'exports/', $path_output);

		return true;
	}

	/**
	 * エラーメッセージを発行
	 * @return array エラーメッセージ一覧
	 */
	public function get_errors(){
		return $this->core->get_errors();
	}

}
