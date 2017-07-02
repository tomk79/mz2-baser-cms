<?php 
class PermissionsSchema extends CakeSchema {

	public $file = 'permissions.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $permissions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'no' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'sort' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'user_group_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'url' => array('type' => 'string', 'null' => true, 'default' => null),
		'auth' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'status' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
