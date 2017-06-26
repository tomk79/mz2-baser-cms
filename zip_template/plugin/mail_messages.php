<?php 
class MailMessagesSchema extends CakeSchema {

	public $file = 'mail_messages.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $mail_messages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
