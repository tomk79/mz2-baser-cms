<?php 
class FeedDetailsSchema extends CakeSchema {

	public $file = 'feed_details.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $feed_details = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'feed_config_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'url' => array('type' => 'string', 'null' => true, 'default' => null),
		'category_filter' => array('type' => 'string', 'null' => true, 'default' => null),
		'cache_time' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
