<?php 
class BlogConfigsSchema extends CakeSchema {

	public $file = 'blog_configs.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $blog_configs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
