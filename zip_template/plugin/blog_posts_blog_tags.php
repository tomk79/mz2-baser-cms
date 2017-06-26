<?php 
class BlogPostsBlogTagsSchema extends CakeSchema {

	public $file = 'blog_posts_blog_tags.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $blog_posts_blog_tags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'blog_post_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'blog_tag_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
