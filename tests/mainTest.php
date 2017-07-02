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
		$core = new \tomk79\pickles2\mz2_baser_cms\core( __DIR__.'/testdata/standard/.px_execute.php' );
		$mz2basercms = new \tomk79\pickles2\mz2_baser_cms\main( __DIR__.'/testdata/standard/.px_execute.php' );

		$res = $core->px2query('/', array(), $val);
		// var_dump($res);
		$this->assertEquals( gettype($res), gettype('') );

		// 後始末
		$core->px2query('/?PX=clearcache', array(), $val);
	} // testSetup()

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

		// (仮)出力されたテーマを試験環境にコピー
		$path_cache = __DIR__.'/testdata/standard/px-files/_sys/ram/caches/';
		$files = $this->fs->ls($path_cache);
		foreach( $files as $basename ){
			if( !preg_match('/^mz2\-baser\-cms\-[0-9]{8}\-[0-9]{6}$/', $basename) ){
				continue;
			}
			$this->fs->copy_r(
				$path_cache.$basename.'/exports/bc_sample/',
				__DIR__.'/../submodules/basercms/app/webroot/theme/pickles2_export/'
			);
			break;
		}

		// 後始末
		$core = new \tomk79\pickles2\mz2_baser_cms\core( __DIR__.'/testdata/standard/.px_execute.php' );
		$core->px2query('/?PX=clearcache', array(), $val);
	} // testExecute()

}
