<?php
/**
 * test for tomk79/mz2-baser-cms
 */
class zipTest extends PHPUnit_Framework_TestCase{
	private $fs;

	public function setup(){
		mb_internal_encoding('UTF-8');
		$this->fs = new tomk79\filesystem();
	}


	/**
	 * ZIP圧縮のテスト
	 */
	public function testZip(){
		$core = new \tomk79\pickles2\mz2_baser_cms\core( __DIR__.'/testdata/standard/.px_execute.php' );

		$res = $core->zip(__DIR__.'/../php/', __DIR__.'/output/ziptest_001.zip' );
		// var_dump($res);
		$this->assertTrue( $res['result'] );

		// 後始末
		$core->px2query('/?PX=clearcache', array(), $val);
	} // testZip()

}
