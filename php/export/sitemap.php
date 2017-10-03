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

	/** 出力先ディレクトリ */
	private $realpath_output;

	/** Data Array */
	private $ary_contents;
	private $ary_pages;
	private $ary_content_folders;

	/** Row Templates */
	private $row_template_contents;
	private $row_template_pages;
	private $row_template_content_folders;

	/** bread crumb */
	private $breadcrumb;

	/**
	 * Constructor
	 */
	public function __construct( $core ){
		$this->core = $core;
		$this->counter = new utils_counter();
		$this->breadcrumb = array();
	}

	/**
	 * 出力を実行する
	 * @return boolean 実行結果の真偽
	 */
	public function export( $realpath_output ){
		$this->realpath_output = $realpath_output;

		// contents.csv
		// 提議行を雛形として読み込み
		$path_contents_csv = $this->realpath_output.'exports/pickles2_export/Config/data/default/contents.csv';
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
		$path_pages_csv = $this->realpath_output.'exports/pickles2_export/Config/data/default/pages.csv';
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
		$path_content_folders_csv = $this->realpath_output.'exports/pickles2_export/Config/data/default/content_folders.csv';
		$this->ary_content_folders = $this->core->fs()->read_csv( $path_content_folders_csv, array('charset'=>'utf-8') );
		$column_define_content_folders = $this->ary_content_folders[0];

		$this->row_template_content_folders = array();
		foreach($column_define_content_folders as $column_name){
			$this->row_template_content_folders[$column_name] = null;
		}
		$this->ary_content_folders = array();
		array_push($this->ary_content_folders, $column_define_content_folders );

		// パンくずメモを処理
		$this->breadcrumb = array();

		// --------------------------------------
		// ページツリーを処理
		if( !$this->apply_page_tree_recursive( null ) ){
			return false;
		}

		// 保存
		$src_contents_csv = $this->core->fs()->mk_csv( $this->ary_contents );
		$this->core->fs()->save_file( $path_contents_csv, $src_contents_csv );

		$src_pages_csv = $this->core->fs()->mk_csv( $this->ary_pages );
		$this->core->fs()->save_file( $path_pages_csv, $src_pages_csv );

		$src_content_folders_csv = $this->core->fs()->mk_csv( $this->ary_content_folders );
		$this->core->fs()->save_file( $path_content_folders_csv, $src_content_folders_csv );

		return true;
	}

	/**
	 * ページツリーを再帰的に処理する
	 */
	private function apply_page_tree_recursive( $page_path = null ){
		if( is_null( $page_path ) ){
			$page_path = '/';
		}

		$page_info_all = $this->core->px2query($page_path.'?PX=px2dthelper.get.all&filter=false');
		$page_info_all = json_decode($page_info_all);

		// var_dump($page_info_all->navigation_info->children_info);

		// var_dump($page_info_all->page_info);
		array_push( $this->breadcrumb, array(
			'id'=>$page_info_all->page_info->id,
			'path'=>$page_info_all->page_info->path,
			'idx'=>null
		) );

		$this->add_new_content_folder( $page_info_all );
		// var_dump($this->breadcrumb);
		$this->add_new_page( $page_info_all );
		$this->add_new_content( $page_info_all );

		foreach( $page_info_all->navigation_info->children_info as $child_page_info ){
			$this->apply_page_tree_recursive($child_page_info->path);
		}

		// 入れ子木構造の処理
		$parent_content_idx = @$this->breadcrumb[count($this->breadcrumb)-1]['idx'];
		if( !is_null($parent_content_idx) ){
			$this->ary_contents[$parent_content_idx]['rght'] = $this->counter->get('nested_tree_coordinate');
		}
		array_pop( $this->breadcrumb );

		return true;
	}

	/**
	 * Page を追加する
	 * Page は、 Pickles 2 でいう Content を格納するテーブルです。
	 */
	private function add_new_page( $page_info_all ){
		$page_info = $page_info_all->page_info;

		if( $this->counter->is_exists('pages', $page_info->path) ){
			// 提議済みの場合
			return true;
		}

		$content_operator = new export_content( $this->core, $this->realpath_output, $this->row_template_pages, $page_info_all );
		$pages_row = $content_operator->export();
		$pages_row['id'] = $this->counter->get('pages', $page_info->path); // IDは `$counter` から発番

		// pages.csv 行完成
		array_push($this->ary_pages, $pages_row );

		return true;
	}

	/**
	 * 変換後の新しいパスを取得
	 */
	private function get_new_path( $path ){
		var_dump($path);
		if( preg_match( '/^(?:[a-zA-Z0-9]+\:|\/\/|\#)/', $path ) ){
			return $path;
		}
		return $path;
	}
	/**
	 * CSSファイル中のパスを解決
	 */
	private function path_resolve_in_css( $bin ){

		$rtn = '';

		// url()
		while( 1 ){
			if( !preg_match( '/^(.*?)url\s*\\((.*?)\\)(.*)$/si', $bin, $matched ) ){
				$rtn .= $bin;
				break;
			}
			$rtn .= $matched[1];
			$rtn .= 'url("';
			$res = trim( $matched[2] );
			if( preg_match( '/^(\"|\')(.*)\1$/si', $res, $matched2 ) ){
				$res = trim( $matched2[2] );
			}
			$res = $this->get_new_path( $res );
			$rtn .= $res;
			$rtn .= '")';
			$bin = $matched[3];
		}

		// @import
		$bin = $rtn;
		$rtn = '';
		while( 1 ){
			if( !preg_match( '/^(.*?)@import\s*([^\s\;]*)(.*)$/si', $bin, $matched ) ){
				$rtn .= $bin;
				break;
			}
			$rtn .= $matched[1];
			$rtn .= '@import ';
			$res = trim( $matched[2] );
			if( !preg_match('/^url\s*\(/', $res) ){
				$rtn .= '"';
				if( preg_match( '/^(\"|\')(.*)\1$/si', $res, $matched2 ) ){
					$res = trim( $matched2[2] );
				}
				$res = $this->get_new_path( $res );
				$rtn .= $res;
				$rtn .= '"';
			}else{
				$rtn .= $res;
			}
			$bin = $matched[3];
		}

		return $rtn;
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
		$contents_row['layout_template'] = 'default';
		$contents_row['level'] = $this->get_level($contents_row['url']);

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

		// 入れ子木構造
		$contents_row['lft'] = $this->counter->get('nested_tree_coordinate');
		$this->breadcrumb[count($this->breadcrumb)-1]['idx'] = count($this->ary_contents);
		// $contents_row['rght'] = $this->counter->get('nested_tree_coordinate');

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
	 * Content は、 Pickles 2 の page に当たる一覧。
	 */
	private function add_new_content( $page_info_all ){
		$page_info = $page_info_all->page_info;

		// --------------------------------------
		// contents.csv 行作成
		$contents_row = $this->row_template_contents;
		$contents_row['id'] = $this->counter->get('contents', 'Page::'.$page_info->id);
		$contents_row['name'] = basename($page_info->path);
		if( $contents_row['name'] == 'index.html' ){
			$contents_row['name'] = 'index'; // `index` は特別な名前。親フォルダと一体化する。
		}
		$contents_row['plugin'] = 'Core';
		$contents_row['type'] = 'Page';
		$contents_row['url'] = $page_info->path;
		$contents_row['url'] = preg_replace('/\/index\.html$/', '/index', $contents_row['url']); // `index.html` は `index` に丸める
		$contents_row['author_id'] = '1'; // admin？
		$contents_row['status'] = '1';
		$contents_row['self_status'] = '1';
		$contents_row['site_id'] = '0';
		$contents_row['title'] = $page_info->title;
		$contents_row['description'] = $page_info->description;
		// $contents_row['site_root'] = (!strlen($page_info->id) ? '1' : '0');
		$contents_row['site_root'] = '0';
		$contents_row['deleted'] = '0';
		$contents_row['exclude_menu'] = '0';
		$contents_row['blank_link'] = '0';
		$contents_row['level'] = $this->get_level($contents_row['url']);

		// `layout_template`
		// レイアウトテンプレート のこと。
		// テーマフォルダの `<theme>/Layouts/{$layout_template}.php` に関連付けられる。
		$contents_row['layout_template'] = 'default';

		// コンテンツのID
		// pages.csv のIDに紐づく
		$contents_row['entity_id'] = $this->counter->get('pages', $page_info->path);

		// パンくずの階層構造
		$physical_dir_name = dirname($page_info->path);
		$physical_dir_name = preg_replace('/\\/*$/', '', $physical_dir_name).'/';
		$contents_row['parent_id'] = $this->counter->get('contents', 'ContentFolder::'.$physical_dir_name);

		// 入れ子木構造
		$contents_row['lft'] = $this->counter->get('nested_tree_coordinate');
		$contents_row['rght'] = $this->counter->get('nested_tree_coordinate');

		// contents.csv 行完成
		array_push($this->ary_contents, $contents_row );


		return true;
	}

	/**
	 * url を参照して level 値を生成する
	 * @param  string $url urlカラムの値
	 * @return int level 値
	 */
	private function get_level($url){
		$url = preg_replace('/\/+$/', '', $url);
		$path_ary = explode('/', $url);
		return count($path_ary)-1;
	}

}
