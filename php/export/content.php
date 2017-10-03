<?php
/**
 * Morizke 2 - baserCMS Export
 */
namespace tomk79\pickles2\mz2_baser_cms;

class export_content{

	/** Core Object */
	private $core;

	/** 出力先ディレクトリ */
	private $realpath_output;

	/** Row Templates */
	private $row_template_pages;

	/** page info all */
	private $page_info_all;

	/**
	 * Constructor
	 */
	public function __construct( $core, $realpath_output, $row_template_pages, $page_info_all ){
		$this->core = $core;
		$this->realpath_output = $realpath_output;
		$this->row_template_pages = $row_template_pages;
		$this->page_info_all = $page_info_all;

		$page_info = $this->page_info_all->page_info;
		$this->path_content = $this->core->px2query($page_info->path.'?PX=px2dthelper.find_page_content');
		$this->realpath_content = $this->page_info_all->realpath_docroot.$this->page_info_all->path_controot.json_decode($this->path_content);
		$this->realpath_content = $this->core->fs()->get_realpath($this->realpath_content);
	}

	/**
	 * 出力を実行する
	 * @return boolean 実行結果の真偽
	 */
	public function export(){

		$src_content = '';
		if( !is_file($this->realpath_content) ){
			$src_content = '<p style="color:#f00;">404 - File NOT Exists.</p>';
			$src_content .= '<p style="color:#f00;">'.htmlspecialchars($this->realpath_content).'</p>';
		}elseif( !is_readable($this->realpath_content) ){
			$src_content = '<p style="color:#f00;">403 - File Exists, but NOT Readable.</p>';
			$src_content .= '<p style="color:#f00;">'.htmlspecialchars($this->realpath_content).'</p>';
		}else{
			$src_content = $this->core->fs()->read_file($this->realpath_content);
		}

		// HTMLをパース
		$html = str_get_html(
			$src_content ,
			false, // $lowercase
			false, // $forceTagsClosed
			DEFAULT_TARGET_CHARSET, // $target_charset
			false, // $stripRN
			DEFAULT_BR_TEXT, // $defaultBRText
			DEFAULT_SPAN_TEXT // $defaultSpanText
		);
		if($html !== false){

			$conf_dom_selectors = array(
				// '*[href]'=>'href',
				'*[src]'=>'src',
				// 'form[action]'=>'action',
			);

			foreach( $conf_dom_selectors as $selector=>$attr_name ){
				$ret = $html->find($selector);
				foreach( $ret as $retRow ){
					$val = $retRow->getAttribute($attr_name);
					$val = $this->get_new_resource_path($val);
					$retRow->setAttribute($attr_name, $val);
				}
			}

			$ret = $html->find('*[style]');
			foreach( $ret as $retRow ){
				$val = $retRow->getAttribute('style');
				$val = str_replace('&quot;', '"', $val);
				$val = str_replace('&lt;', '<', $val);
				$val = str_replace('&gt;', '>', $val);
				$val = $this->path_resolve_in_css($val);
				$val = str_replace('"', '&quot;', $val);
				$val = str_replace('<', '&lt;', $val);
				$val = str_replace('>', '&gt;', $val);
				$retRow->setAttribute('style', $val);
			}

			$ret = $html->find('style');
			foreach( $ret as $retRow ){
				$val = $retRow->innertext;
				$val = $this->path_resolve_in_css($val);
				$retRow->innertext = $val;
			}

			$src_content = $html->outertext;
		}

		// --------------------------------------
		// pages.csv 行作成
		$pages_row = $this->row_template_pages;
		$pages_row['id'] = null; // ID は、呼び出し側の `$counter` から発番されるので、ここでは null を入れておく。
		$pages_row['contents'] = $src_content;

		return $pages_row;
	}

	/**
	 * 変換後の新しいパスを取得
	 */
	private function get_new_resource_path( $path ){
		if( preg_match( '/^(?:[a-zA-Z0-9]+\:|\/\/|\#)/', $path ) ){
			// http://, https:// などスキーマ名から始まっていた場合、変換しない
			return $path;
		}

		$path_resource = null;
		if( preg_match( '/^\//', $path ) ){
			// 絶対パスの記述
			$path_resource = $this->core->fs()->get_realpath($this->page_info_all->path_controot.$path);
		}else{
			// 相対パスの記述
			$path_resource = $this->core->fs()->get_realpath($this->page_info_all->path_controot.dirname($this->page_info_all->page_info->content).'/'.$path);
		}
		$realpath_resource = $this->core->fs()->get_realpath($this->page_info_all->realpath_docroot.$path_resource);
		if( !is_file( $realpath_resource ) || !is_readable( $realpath_resource ) ){
			// ファイルの実体が存在しない場合、変換しないで返す
			return $path;
		}

		preg_match('/\.(.*?)$/', $realpath_resource, $matched);
		$ext = @strtolower($matched[1]);
		$mime = null;
		switch($ext){
			case 'png':
				$mime = 'image/png'; break;
			case 'gif':
				$mime = 'image/gif'; break;
			case 'jpg': case 'jpe': case 'jpeg':
				$mime = 'image/jpeg'; break;
		}

		$cms_settings = $this->core->get_cms_settings();
		if( $cms_settings->local_resource_mode == 'theme_files' ){
			$this->core->fs()->copy_r( $realpath_resource, $this->realpath_output.'exports/pickles2_export/files/pages/'.$path_resource );
			$path = '/pages'.$path_resource;
		}else{
			$bin = $this->core->fs()->read_file( $realpath_resource );
			$path = 'data:'.$mime.';base64,'.base64_encode($bin);
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
			$res = $this->get_new_resource_path( $res );
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
				$res = $this->get_new_resource_path( $res );
				$rtn .= $res;
				$rtn .= '"';
			}else{
				$rtn .= $res;
			}
			$bin = $matched[3];
		}

		return $rtn;
	}

}
