<?php 
class MailFieldsSchema extends CakeSchema {

	public $file = 'mail_fields.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $mail_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'mail_content_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'no' => array('type' => 'integer', 'null' => true, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'field_name' => array('type' => 'string', 'null' => true, 'default' => null),
		'type' => array('type' => 'string', 'null' => true, 'default' => null),
		'head' => array('type' => 'string', 'null' => true, 'default' => null),
		'attention' => array('type' => 'string', 'null' => true, 'default' => null),
		'before_attachment' => array('type' => 'string', 'null' => true, 'default' => null),
		'after_attachment' => array('type' => 'string', 'null' => true, 'default' => null),
		'source' => array('type' => 'text', 'null' => true, 'default' => null),
		'size' => array('type' => 'integer', 'null' => true, 'default' => null),
		'rows' => array('type' => 'integer', 'null' => true, 'default' => null),
		'maxlength' => array('type' => 'integer', 'null' => true, 'default' => null),
		'options' => array('type' => 'string', 'null' => true, 'default' => null),
		'class' => array('type' => 'string', 'null' => true, 'default' => null),
		'separator' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'default_value' => array('type' => 'string', 'null' => true, 'default' => null),
		'description' => array('type' => 'string', 'null' => true, 'default' => null),
		'group_field' => array('type' => 'string', 'null' => true, 'default' => null),
		'group_valid' => array('type' => 'string', 'null' => true, 'default' => null),
		'valid' => array('type' => 'string', 'null' => true, 'default' => null),
		'valid_ex' => array('type' => 'string', 'null' => true, 'default' => null),
		'auto_convert' => array('type' => 'string', 'null' => true, 'default' => null),
		'not_empty' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'use_field' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'no_send' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'sort' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
