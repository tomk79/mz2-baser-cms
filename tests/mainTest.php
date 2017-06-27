<?php
/**
 * test for tomk79/mz2-baser-cms
 */
class mainTest extends PHPUnit_Framework_TestCase{
	private $fs;

	public function setup(){
		mb_internal_encoding('UTF-8');
		$this->fs = new tomk79\filesystem();
	}


	/**
	 * セットアップ状態の確認
	 */
	public function testSetup(){
		$mz2basercms = new \tomk79\pickles2\mz2_baser_cms\main( __DIR__.'/testdata/standard/.px_execute.php' );

		$res = $mz2basercms->query('/', array(), $val);
		// var_dump($res);
		$this->assertEquals( gettype($res), gettype('') );

		// 後始末
		$mz2basercms->query('/?PX=clearcache', array(), $val);
	} // testSetup()

	/**
	 * 出力を実行
	 */
	public function testExecute(){
		$mz2basercms = new \tomk79\pickles2\mz2_baser_cms\main( __DIR__.'/testdata/standard/.px_execute.php' );

		$res = $mz2basercms->execute( __DIR__.'/output/execute_test_001.zip' );
		$this->assertTrue( $res );

		$errors = $mz2basercms->get_errors();
		$this->assertTrue( is_array($errors) );
		$this->assertEquals( count($errors), 0 );

		// 後始末
		$mz2basercms->query('/?PX=clearcache', array(), $val);
	} // testExecute()

}
