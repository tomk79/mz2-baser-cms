<?php
/**
 * test for tomk79/mz2-baser-cms
 */
class mainTest extends PHPUnit_Framework_TestCase{
	private $fs;

	public function setup(){
		clearstatcache();
		mb_internal_encoding('UTF-8');
		$this->fs = new tomk79\filesystem();
		if( !is_dir( __DIR__.'/output/' ) ){
			$this->fs->mkdir( __DIR__.'/output/' );
		}
	}


	/**
	 * セットアップ状態の確認
	 */
	public function testSetup(){
		$core = new \tomk79\pickles2\mz2_baser_cms\core( __DIR__.'/testdata/standard/.px_execute.php' );
		$mz2basercms = new \tomk79\pickles2\mz2_baser_cms\main( __DIR__.'/testdata/standard/.px_execute.php' );

		$res = $core->px2query('/', array(), $val);
		// var_dump($res);
		$this->assertEquals( gettype($res), gettype('') );

		// 後始末
		$core->px2query('/?PX=clearcache', array(), $val);
	} // testSetup()

	/**
	 * ZIP圧縮のテスト
	 */
	public function testZip(){
		$core = new \tomk79\pickles2\mz2_baser_cms\core( __DIR__.'/testdata/standard/.px_execute.php' );
		$res = $core->zip(__DIR__.'/../php/', __DIR__.'/output/ziptest_001.zip' );
		// var_dump($res);
		$this->assertTrue( $res['result'] );
		$this->assertTrue( is_file(__DIR__.'/output/ziptest_001.zip') );
	} // testZip()


	/**
	 * 出力を実行
	 */
	public function testExecute(){
		$mz2basercms = new \tomk79\pickles2\mz2_baser_cms\main( __DIR__.'/testdata/standard/.px_execute.php' );

		$res = $mz2basercms->export( __DIR__.'/output/execute_test_001.zip' );
		$this->assertTrue( $res );

		$errors = $mz2basercms->get_errors();
		$this->assertTrue( is_array($errors) );
		$this->assertEquals( count($errors), 0 );


		// TODO: (仮)出力されたテーマを試験環境にコピー
		$path_cache = __DIR__.'/testdata/standard/px-files/_sys/ram/caches/';
		$files = $this->fs->ls($path_cache);
		foreach( $files as $basename ){
			if( !preg_match('/^mz2\-baser\-cms\-[0-9]{8}\-[0-9]{6}$/', $basename) ){
				continue;
			}
			$this->fs->copy_r(
				$path_cache.$basename.'/exports/pickles2_export/',
				__DIR__.'/../submodules/basercms/app/webroot/theme/pickles2_export/'
			);
			break;
		}
	} // testExecute()

}
