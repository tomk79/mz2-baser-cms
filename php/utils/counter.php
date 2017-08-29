<?php
/**
 * Morizke 2 - baserCMS Export
 */
namespace tomk79\pickles2\mz2_baser_cms;

class utils_counter{

	/** Counter */
	private $counter;

	/**
	 * Constructor
	 */
	public function __construct(){
		$this->counter = array();
	}

	/**
	 * オプション情報を取得する
	 * @return array Options.
	 */
	public function get($counter_name, $primary_key = null){
		if( !is_string($counter_name) ){
			return false;
		}
		if( !is_string($primary_key) ){
			$primary_key = null;
		}
		if( !array_key_exists($counter_name, $this->counter) ){
			// initialize
			$this->counter[$counter_name] = array();
			$this->counter[$counter_name]['increment'] = 0;
			$this->counter[$counter_name]['primary_keys'] = array();
		}
		if( is_string($primary_key) && array_key_exists($primary_key, $this->counter[$counter_name]['primary_keys']) ){
			// 既に番号を発行済のキーを場合、
			return $this->counter[$counter_name]['primary_keys'][$primary_key];
		}

		// 初めてのキーなら、追加する。
		$this->counter[$counter_name]['increment']++;
		$this->counter[$counter_name]['primary_keys'][$primary_key] = $this->counter[$counter_name]['increment'];

		return $this->counter[$counter_name]['primary_keys'][$primary_key];
	}

	/**
	 * 既に発行済のキーか確認する
	 */
	public function is_exists($counter_name, $primary_key){
		if( @$this->counter[$counter_name]['primary_keys'][$primary_key] ){
			return true;
		}
		return false;
	}
}
