<?php 
class BlogContentsSchema extends CakeSchema {

	public $file = 'blog_contents.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $blog_contents = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'description' => array('type' => 'text', 'null' => true, 'default' => null),
		'template' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'list_count' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'list_direction' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 4),
		'feed_count' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'tag_use' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'comment_use' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 2),
		'comment_approve' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 2),
		'auth_captcha' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'widget_area' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'eye_catch_size' => array('type' => 'text', 'null' => true, 'default' => null),
		'use_content' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
