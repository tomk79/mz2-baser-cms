<?php 
class PagesSchema extends CakeSchema {

	public $file = 'pages.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $pages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'contents' => array('type' => 'text', 'null' => true, 'default' => null),
		'draft' => array('type' => 'text', 'null' => true, 'default' => null),
		'page_template' => array('type' => 'string', 'null' => true, 'default' => null),
		'code' => array('type' => 'text', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
