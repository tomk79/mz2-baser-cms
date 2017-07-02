<?php 
class BlogCategoriesSchema extends CakeSchema {

	public $file = 'blog_categories.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $blog_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'blog_content_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'no' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'status' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 2),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'owner_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
