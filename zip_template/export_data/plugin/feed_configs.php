<?php 
class FeedConfigsSchema extends CakeSchema {

	public $file = 'feed_configs.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $feed_configs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'feed_title_index' => array('type' => 'string', 'null' => true, 'default' => null),
		'category_index' => array('type' => 'string', 'null' => true, 'default' => null),
		'template' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'display_number' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 3),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
