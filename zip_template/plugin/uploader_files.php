<?php 
class UploaderFilesSchema extends CakeSchema {

	public $file = 'uploader_files.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $uploader_files = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'alt' => array('type' => 'text', 'null' => true, 'default' => null),
		'uploader_category_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'publish_begin' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'publish_end' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
