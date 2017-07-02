<?php
/**
 * Morizke 2 - baserCMS Export
 */
namespace tomk79\pickles2\mz2_baser_cms;

class export_sitemap{

	/** Core Object */
	private $core;

	/** Counter Object */
	private $counter;

	/** Data Array */
	private $ary_contents;
	private $ary_pages;
	private $ary_content_folders;

	/** Row Templates */
	private $row_template_contents;
	private $row_template_pages;
	private $row_template_content_folders;

	/**
	 * Constructor
	 */
	public function __construct( $core ){
		$this->core = $core;
		$this->counter = new utils_counter();
	}

	/**
	 * 出力を実行する
	 * @return boolean 実行結果の真偽
	 */
	public function export( $path_output ){
		// contents.csv
		// 提議行を雛形として読み込み
		$path_contents_csv = $path_output.'exports/export_data/core/contents.csv';
		$this->ary_contents = $this->core->fs()->read_csv( $path_contents_csv, array('charset'=>'utf-8') );
		$column_define_contents = $this->ary_contents[0];

		$this->row_template_contents = array();
		foreach($column_define_contents as $column_name){
			$this->row_template_contents[$column_name] = null;
		}
		$this->ary_contents = array();
		array_push($this->ary_contents, $column_define_contents );

		// pages.csv
		// 提議行を雛形として読み込み
		$path_pages_csv = $path_output.'exports/export_data/core/pages.csv';
		$this->ary_pages = $this->core->fs()->read_csv( $path_pages_csv, array('charset'=>'utf-8') );
		$column_define_pages = $this->ary_pages[0];

		$this->row_template_pages = array();
		foreach($column_define_pages as $column_name){
			$this->row_template_pages[$column_name] = null;
		}
		$this->ary_pages = array();
		array_push($this->ary_pages, $column_define_pages );

		// content_folders.csv
		// 提議行を雛形として読み込み
		$path_content_folders_csv = $path_output.'exports/export_data/core/content_folders.csv';
		$this->ary_content_folders = $this->core->fs()->read_csv( $path_content_folders_csv, array('charset'=>'utf-8') );
		$column_define_content_folders = $this->ary_content_folders[0];

		$this->row_template_content_folders = array();
		foreach($column_define_content_folders as $column_name){
			$this->row_template_content_folders[$column_name] = null;
		}
		$this->ary_content_folders = array();
		array_push($this->ary_content_folders, $column_define_content_folders );


		// --------------------------------------

		// サイトマップ配列を取得
		$sitemap = $this->core->px2query('/?PX=api.get.sitemap', array(), $val);
		$sitemap = @json_decode($sitemap);
		if( !is_object($sitemap) ){
			$this->core->error('Failed to load sitemap list from `/?PX=px2dthelper.get.sitemap`.');
			return false;
		}

		// --------------------------------------

		foreach($sitemap as $page_info){

			// --------------------------------------
			// contents.csv 行作成
			$contents_row = $this->row_template_contents;

			$page_info_all = $this->core->px2query($page_info->path.'?PX=px2dthelper.get.all');
			$page_info_all = json_decode($page_info_all);
			// var_dump($page_info_all);

			$this->add_new_content_folder( $page_info_all );
			$this->add_new_page( $page_info_all );
			$this->add_new_content( $page_info_all );
		}

		// 保存
		$src_contents_csv = $this->core->fs()->mk_csv( $this->ary_contents );
		$this->core->fs()->save_file( $path_contents_csv, $src_contents_csv );
		$this->core->fs()->save_file( $path_output.'exports/bc_sample/Config/data/default/contents.csv', $src_contents_csv );

		$src_pages_csv = $this->core->fs()->mk_csv( $this->ary_pages );
		$this->core->fs()->save_file( $path_pages_csv, $src_pages_csv );
		$this->core->fs()->save_file( $path_output.'exports/bc_sample/Config/data/default/pages.csv', $src_pages_csv );

		$src_content_folders_csv = $this->core->fs()->mk_csv( $this->ary_content_folders );
		$this->core->fs()->save_file( $path_content_folders_csv, $src_content_folders_csv );
		$this->core->fs()->save_file( $path_output.'exports/bc_sample/Config/data/default/content_folders.csv', $src_content_folders_csv );

		$config = '';
		$config .= '<'.'?php'."\n";
		$config .= '$title = \'Pickles 2 プロジェクトからのエクスポート\';'."\n";
		$config .= '$description = \'Pickles 2 からエクスポートしたデータです。\';'."\n";
		$config .= '$author = \'Tomoya Koyanagi\';'."\n";
		$config .= '$url = \'http://pickles2.pxt.jp/\';'."\n";
		$this->core->fs()->save_file( $path_output.'exports/bc_sample/config.php', $config );

		return true;
	}

	/**
	 * Page を追加する
	 */
	private function add_new_page( $page_info_all ){
		$page_info = $page_info_all->page_info;

		if( $this->counter->is_exists('pages', $page_info->path) ){
			// 提議済みの場合
			return true;
		}

		$path_content = $this->core->px2query($page_info->path.'?PX=px2dthelper.find_page_content');
		$realpath_content = $page_info_all->realpath_docroot.$page_info_all->path_controot.json_decode($path_content);
		$src_content = '';
		if( !is_file($realpath_content) ){
			$src_content = '<p style="color:#f00;">404 - File NOT Exists.</p>';
		}elseif( !is_readable($realpath_content) ){
			$src_content = '<p style="color:#f00;">403 - File Exists, but NOT Readable.</p>';
		}else{
			$src_content = $this->core->fs()->read_file($realpath_content);
		}

		// --------------------------------------
		// pages.csv 行作成
		$pages_row = $this->row_template_pages;

		$pages_row['id'] = $this->counter->get('pages', $page_info->path);
		$pages_row['contents'] = $src_content;

		// pages.csv 行完成
		array_push($this->ary_pages, $pages_row );

		return true;
	}

	/**
	 * Content Folder を追加する
	 */
	private function add_new_content_folder( $page_info_all ){
		$page_info = $page_info_all->page_info;

		$physical_dir_name = dirname($page_info->path);
		$physical_dir_name = preg_replace('/\\/*$/', '', $physical_dir_name).'/';
		if( $this->counter->is_exists('content_folders', 'ContentFolder::'.$physical_dir_name) ){
			// 提議済みの場合
			return true;
		}
		// var_dump($physical_dir_name);

		$id_content_folders = $this->counter->get('content_folders', 'ContentFolder::'.$physical_dir_name);

		// --------------------------------------
		// contents.csv 行作成
		$contents_row = $this->row_template_contents;

		$contents_row['id'] = $this->counter->get('contents', 'ContentFolder::'.$physical_dir_name);
		$contents_row['name'] = basename(dirname($page_info->path));
		$contents_row['plugin'] = 'Core';
		$contents_row['type'] = 'ContentFolder';
		$contents_row['url'] = $physical_dir_name;
		$contents_row['author_id'] = '1'; // admin？
		$contents_row['status'] = '1';
		$contents_row['self_status'] = '1';
		$contents_row['site_id'] = '0';
		$contents_row['title'] = $page_info->title;
		$contents_row['site_root'] = ($physical_dir_name=='/' ? '1' : '0');
		$contents_row['deleted'] = '0';
		$contents_row['exclude_menu'] = '0';
		$contents_row['blank_link'] = '0';
		$contents_row['entity_id'] = $id_content_folders;

		// パンくずの階層構造
		// $parent_page_info = $this->core->px2query($page_info->path.'?PX=api.get.page_info&path='.urlencode($page_info_all->navigation_info->parent));
		// $parent_page_info = json_decode($parent_page_info);

		$physical_dir_name = dirname($page_info->path);
		$physical_dir_name = preg_replace('/\\/*$/', '', $physical_dir_name).'/';
		if($physical_dir_name != '/'){
			$physical_dir_name = dirname($physical_dir_name);
			$physical_dir_name = preg_replace('/\\/*$/', '', $physical_dir_name).'/';
			$contents_row['parent_id'] = $this->counter->get('contents', 'ContentFolder::'.$physical_dir_name);
		}

		// contents.csv 行完成
		array_push($this->ary_contents, $contents_row );

		// --------------------------------------
		// content_folders.csv 行作成
		$content_folders_row = $this->row_template_content_folders;
		$content_folders_row['id'] = $id_content_folders;

		// content_folders.csv 行完成
		array_push($this->ary_content_folders, $content_folders_row );
		return true;
	}

	/**
	 * Content を追加する
	 */
	private function add_new_content( $page_info_all ){
		$page_info = $page_info_all->page_info;

		// --------------------------------------
		// contents.csv 行作成
		$contents_row = $this->row_template_contents;
		$contents_row['id'] = $this->counter->get('contents', 'Page::'.$page_info->id);
		$contents_row['name'] = basename($page_info->path);
		$contents_row['plugin'] = 'Core';
		$contents_row['type'] = 'Page';
		$contents_row['url'] = $page_info->path;
		$contents_row['author_id'] = '1'; // admin？
		$contents_row['status'] = '1';
		$contents_row['self_status'] = '1';
		$contents_row['site_id'] = '0';
		$contents_row['title'] = $page_info->title;
		$contents_row['description'] = $page_info->description;
		$contents_row['site_root'] = (!strlen($page_info->id) ? '1' : '0');
		$contents_row['deleted'] = '0';
		$contents_row['exclude_menu'] = '0';
		$contents_row['blank_link'] = '0';

		// コンテンツのID
		// pages.csv のIDに紐づく
		$contents_row['entity_id'] = $this->counter->get('pages', $page_info->path);

		// パンくずの階層構造
		if( !strlen($page_info->id) ){
			$contents_row['parent_id'] = '';
		}else{
			$contents_row['parent_id'] = $this->counter->get('contents', 'Page::'.$page_info_all->navigation_info->parent);
		}

		// contents.csv 行完成
		array_push($this->ary_contents, $contents_row );


		return true;
	}

}
