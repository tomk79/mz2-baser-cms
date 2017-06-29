<?php
/**
 * Morizke 2 - baserCMS Export
 */
namespace tomk79\pickles2\mz2_baser_cms;

class export_sitemap{

	/** Core Object */
	private $core;

	/**
	 * Constructor
	 */
	public function __construct( $core ){
		$this->core = $core;
	}

	/**
	 * 出力を実行する
	 * @return boolean 実行結果の真偽
	 */
	public function export( $path_output ){
		$path_contents_csv = $path_output.'exports/core/contents.csv';
		$contents_csv = $this->core->fs()->read_csv( $path_contents_csv, array('charset'=>'utf-8') );
		$column_define_contents = $contents_csv[0];

		$row_template_contents = array();
		foreach($column_define_contents as $column_name){
			$row_template_contents[$column_name] = null;
		}

		$sitemap = $this->core->px2query('/?PX=api.get.sitemap', array(), $val);
		$sitemap = @json_decode($sitemap);
		if( !is_object($sitemap) ){
			$this->core->error('Failed to load sitemap list from `/?PX=px2dthelper.get.sitemap`.');
			return false;
		}
		// var_dump($sitemap);

		// contents.csv 上でのIDと、Pickles 2 の page_id の紐付けテーブル
		$relay_page_id2contents_id_table = array();
		$relay_path2page_id_table = array();
		$id = 0;
		foreach($sitemap as $page_info){
			$id++;
			$relay_page_id2contents_id_table[$page_info->id] = $id;
			$relay_path2page_id_table[$page_info->path] = $page_info->id;
		}

		// contents.csv を生成
		$csv = array();
		array_push($csv, $column_define_contents );
		$id = 0;
		foreach($sitemap as $page_info){
			$id++;
			$relay_page_id2contents_id_table[$page_info->id] = $id;
			$row = $row_template_contents;
			$row['id'] = $relay_page_id2contents_id_table[$page_info->id];
			$row['name'] = $page_info->id;
			$row['plugin'] = 'Core';
			$row['type'] = 'Page';
			$row['url'] = $page_info->path;
			$row['site_id'] = '0';
			$row['title'] = $page_info->title;
			$row['description'] = $page_info->description;

			// コンテンツのID
			// pages.csv のIDに紐づく
			$row['entity_id'] = '1';

			// パンくずの階層構造
			if( !strlen($page_info->id) ){
				$row['parent_id'] = '';
			}elseif( !strlen($page_info->logical_path) ){
				$row['parent_id'] = '1';
			}else{
				$breadcrumbs = explode('>', trim($page_info->logical_path));
				$parent_page_id = $breadcrumbs[count($breadcrumbs)-1];
				if( strlen(@$relay_path2page_id_table[$parent_page_id]) ){
					$parent_page_id = $relay_path2page_id_table[$parent_page_id];
				}
				$row['parent_id'] = $relay_page_id2contents_id_table[$parent_page_id];
			}

			// 行完成
			array_push($csv, $row );
		}
		$src_csv = $this->core->fs()->mk_csv( $csv );
		$this->core->fs()->save_file( $path_contents_csv, $src_csv );

		return true;
	}
}
