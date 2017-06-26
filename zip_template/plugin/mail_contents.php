<?php 
class MailContentsSchema extends CakeSchema {

	public $file = 'mail_contents.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $mail_contents = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'description' => array('type' => 'text', 'null' => true, 'default' => null),
		'sender_1' => array('type' => 'string', 'null' => true, 'default' => null),
		'sender_2' => array('type' => 'string', 'null' => true, 'default' => null),
		'sender_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'subject_user' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'subject_admin' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'form_template' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'mail_template' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'redirect_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'auth_captcha' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'widget_area' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'ssl_on' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'save_info' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'publish_begin' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'publish_end' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
