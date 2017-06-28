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
		$column_define_contents = array(
			"id",
			"name",
			"plugin",
			"type",
			"entity_id",
			"url",
			"site_id",
			"alias_id",
			"main_site_content_id",
			"parent_id",
			"lft",
			"rght",
			"level",
			"title",
			"description",
			"eyecatch",
			"author_id",
			"layout_template",
			"status",
			"publish_begin",
			"publish_end",
			"self_status",
			"self_publish_begin",
			"self_publish_end",
			"exclude_search",
			"created_date",
			"modified_date",
			"site_root",
			"deleted_date",
			"deleted",
			"exclude_menu",
			"blank_link",
			"created",
			"modified",
		);
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

		$csv = array();
		array_push($csv, $column_define_contents );
		$id = 0;
		foreach($sitemap as $page_info){
			$id++;
			$row = $row_template_contents;
			$row['id'] = $id;
			$row['name'] = $page_info->id;
			$row['plugin'] = 'Core';
			$row['type'] = 'Page';
			$row['url'] = $page_info->path;
			$row['site_id'] = '0';
			$row['title'] = $page_info->title;
			array_push($csv, $row );
		}
		$src_csv = $this->core->fs()->mk_csv( $csv );
		$this->core->fs()->save_file( $path_output.'exports/core/contents.csv', $src_csv );

		return true;
	}
}
