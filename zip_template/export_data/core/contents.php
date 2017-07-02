<?php 
class ContentsSchema extends CakeSchema {

	public $file = 'contents.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $contents = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'name' => array('type' => 'text', 'null' => true, 'default' => null),
		'plugin' => array('type' => 'string', 'null' => true, 'default' => null),
		'type' => array('type' => 'string', 'null' => true, 'default' => null),
		'entity_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'url' => array('type' => 'string', 'null' => true, 'default' => null),
		'site_id' => array('type' => 'integer', 'null' => true, 'default' => '\'0\'', 'length' => 8),
		'alias_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'main_site_content_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'level' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'title' => array('type' => 'string', 'null' => true, 'default' => null),
		'description' => array('type' => 'text', 'null' => true, 'default' => null),
		'eyecatch' => array('type' => 'string', 'null' => true, 'default' => null),
		'author_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 8),
		'layout_template' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'status' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'publish_begin' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'publish_end' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'self_status' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'self_publish_begin' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'self_publish_end' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'exclude_search' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'created_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'site_root' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'deleted' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'exclude_menu' => array('type' => 'boolean', 'null' => true, 'default' => '\'0\''),
		'blank_link' => array('type' => 'boolean', 'null' => true, 'default' => '\'0\''),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
