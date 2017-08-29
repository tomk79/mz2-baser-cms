<?php
/**
 * test for tomk79/mz2-baser-cms
 */
class cleanupTest extends PHPUnit_Framework_TestCase{
	private $fs;

	public function setup(){
		mb_internal_encoding('UTF-8');
		$this->fs = new tomk79\filesystem();
	}


	/**
	 * 後始末
	 */
	public function testCleanup(){
		$core = new \tomk79\pickles2\mz2_baser_cms\core( __DIR__.'/testdata/standard/.px_execute.php' );
		$core->px2query('/?PX=clearcache', array(), $val);

		$this->fs->rm( __DIR__.'/output/' );
	} // testCleanup()

}
