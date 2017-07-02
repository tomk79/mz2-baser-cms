<?php 
class EditorTemplatesSchema extends CakeSchema {

	public $file = 'editor_templates.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $editor_templates = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'image' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'description' => array('type' => 'string', 'null' => true, 'default' => null),
		'html' => array('type' => 'text', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
