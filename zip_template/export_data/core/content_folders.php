<?php 
class ContentFoldersSchema extends CakeSchema {

	public $file = 'content_folders.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $content_folders = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'folder_template' => array('type' => 'string', 'null' => true, 'default' => null),
		'page_template' => array('type' => 'string', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
