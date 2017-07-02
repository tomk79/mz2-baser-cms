<?php 
class MailMessage1Schema extends CakeSchema {

	public $file = 'mail_message_1.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $mail_message_1 = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'length' => 8),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'name_1' => array('type' => 'text', 'null' => true, 'default' => null),
		'name_2' => array('type' => 'text', 'null' => true, 'default' => null),
		'name_kana_1' => array('type' => 'text', 'null' => true, 'default' => null),
		'name_kana_2' => array('type' => 'text', 'null' => true, 'default' => null),
		'sex' => array('type' => 'text', 'null' => true, 'default' => null),
		'email_1' => array('type' => 'text', 'null' => true, 'default' => null),
		'email_2' => array('type' => 'text', 'null' => true, 'default' => null),
		'tel_1' => array('type' => 'text', 'null' => true, 'default' => null),
		'tel_2' => array('type' => 'text', 'null' => true, 'default' => null),
		'tel_3' => array('type' => 'text', 'null' => true, 'default' => null),
		'zip' => array('type' => 'text', 'null' => true, 'default' => null),
		'address_1' => array('type' => 'text', 'null' => true, 'default' => null),
		'address_2' => array('type' => 'text', 'null' => true, 'default' => null),
		'address_3' => array('type' => 'text', 'null' => true, 'default' => null),
		'category' => array('type' => 'text', 'null' => true, 'default' => null),
		'message' => array('type' => 'text', 'null' => true, 'default' => null),
		'root' => array('type' => 'text', 'null' => true, 'default' => null),
		'root_etc' => array('type' => 'text', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

}
