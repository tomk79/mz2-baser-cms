<?php 
class PluginsSchema extends CakeSchema {

	public $file = 'plugins.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $plugins = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'version' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'status' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'db_inited' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'priority' => array('type' => 'integer', 'null' => true, 'default' => '\'0\'', 'length' => 8),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
