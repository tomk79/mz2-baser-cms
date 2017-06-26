<?php 
class UploaderConfigsSchema extends CakeSchema {

	public $file = 'uploader_configs.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $uploader_configs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'name' => array('type' => 'string', 'null' => false, 'default' => null),
		'value' => array('type' => 'text', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
