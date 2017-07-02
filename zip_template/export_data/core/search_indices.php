<?php 
class SearchIndicesSchema extends CakeSchema {

	public $file = 'search_indices.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $search_indices = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'model' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'model_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'site_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'content_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'content_filter_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'title' => array('type' => 'string', 'null' => true, 'default' => null),
		'detail' => array('type' => 'text', 'null' => true, 'default' => null),
		'url' => array('type' => 'string', 'null' => true, 'default' => null),
		'status' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'priority' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
