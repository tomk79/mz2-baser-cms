<?php 
class UploaderCategoriesSchema extends CakeSchema {

	public $file = 'uploader_categories.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $uploader_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
