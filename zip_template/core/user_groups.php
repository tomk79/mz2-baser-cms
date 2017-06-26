<?php 
class UserGroupsSchema extends CakeSchema {

	public $file = 'user_groups.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $user_groups = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'auth_prefix' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'use_admin_globalmenu' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'default_favorites' => array('type' => 'text', 'null' => true, 'default' => null),
		'use_move_contents' => array('type' => 'boolean', 'null' => true, 'default' => '\'0\''),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
