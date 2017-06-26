<?php 
class BlogPostsSchema extends CakeSchema {

	public $file = 'blog_posts.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $blog_posts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'blog_content_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'no' => array('type' => 'integer', 'null' => true, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'content' => array('type' => 'text', 'null' => true, 'default' => null),
		'detail' => array('type' => 'text', 'null' => true, 'default' => null),
		'blog_category_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'status' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'posts_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'content_draft' => array('type' => 'text', 'null' => true, 'default' => null),
		'detail_draft' => array('type' => 'text', 'null' => true, 'default' => null),
		'publish_begin' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'publish_end' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'exclude_search' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'eye_catch' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
