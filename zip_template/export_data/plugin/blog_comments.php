<?php 
class BlogCommentsSchema extends CakeSchema {

	public $file = 'blog_comments.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $blog_comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'blog_content_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'blog_post_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'no' => array('type' => 'integer', 'null' => true, 'default' => null),
		'status' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 2),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'email' => array('type' => 'string', 'null' => true, 'default' => null),
		'url' => array('type' => 'string', 'null' => true, 'default' => null),
		'message' => array('type' => 'text', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
