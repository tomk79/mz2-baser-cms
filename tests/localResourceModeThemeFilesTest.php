<?php
/**
 * test for tomk79/mz2-baser-cms
 */
class localResourceModeThemeFilesTest extends PHPUnit_Framework_TestCase{
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
	 * 出力を実行
	 */
	public function testExecute(){
		$mz2basercms = new \tomk79\pickles2\mz2_baser_cms\main( __DIR__.'/testdata/standard/.px_execute.php', array('local_resource_mode'=>'theme_files') );

		$res = $mz2basercms->export( __DIR__.'/output/execute_test_002.zip' );
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


	/**
	 * 生成されたZIPを解凍してチェック
	 */
	public function testUnzip(){
		$zip = new \ZipArchive;
		if ($zip->open( __DIR__.'/output/execute_test_002.zip' ) === true) {
			$zip->extractTo( __DIR__.'/output/unzip_execute_test_002.zip/' );
			$zip->close();
		}
		$this->assertTrue( is_dir(__DIR__.'/output/unzip_execute_test_002.zip/') );
		$this->assertTrue( is_file(__DIR__.'/output/unzip_execute_test_002.zip/pickles2_export/Config/data/default/contents.csv') );
	} // testUnzip()


	/**
	 * contents.csv の内容をチェック
	 */
	public function testContentsCsv(){
		$contentsCsv = $this->fs->read_csv( __DIR__.'/output/unzip_execute_test_002.zip/pickles2_export/Config/data/default/contents.csv' );
		// var_dump($contentsCsv);
		$this->assertTrue( is_array($contentsCsv) );
		$this->assertEquals( count($contentsCsv), 17 );

		$this->assertEquals( $contentsCsv[9][0], 9 );
		$this->assertEquals( $contentsCsv[9][2], "testpage4" );
		$this->assertEquals( $contentsCsv[9][4], "ContentFolder" );
		$this->assertEquals( $contentsCsv[9][5], "/testpage4/" );
		$this->assertEquals( $contentsCsv[9][7], 16 );
		$this->assertEquals( $contentsCsv[9][8], 23 );
		$this->assertEquals( $contentsCsv[9][9], "TEST4" );

		$this->assertEquals( $contentsCsv[12][0], 12 );
		$this->assertEquals( $contentsCsv[12][2], "test4-2.html" );
		$this->assertEquals( $contentsCsv[12][4], "Page" );
		$this->assertEquals( $contentsCsv[12][5], "/testpage4/test4-2.html" );
		$this->assertEquals( $contentsCsv[12][7], 21 );
		$this->assertEquals( $contentsCsv[12][8], 22 );
		$this->assertEquals( $contentsCsv[12][9], "TEST4-2" );
	} // testContentsCsv()

	/**
	 * content_folders.csv の内容をチェック
	 */
	public function testContentFoldersCsv(){
		$contentFoldersCsv = $this->fs->read_csv( __DIR__.'/output/unzip_execute_test_002.zip/pickles2_export/Config/data/default/content_folders.csv' );
		// var_dump($contentFoldersCsv);
		$this->assertTrue( is_array($contentFoldersCsv) );
		$this->assertEquals( count($contentFoldersCsv), 5 );

		$this->assertEquals( $contentFoldersCsv[1][0], 1 );

		$this->assertEquals( $contentFoldersCsv[3][0], 3 );
	} // testContentFoldersCsv()

	/**
	 * pages.csv の内容をチェック
	 */
	public function testPagesCsv(){
		$pagesCsv = $this->fs->read_csv( __DIR__.'/output/unzip_execute_test_002.zip/pickles2_export/Config/data/default/pages.csv' );
		// var_dump($pagesCsv);
		$this->assertTrue( is_array($pagesCsv) );
		$this->assertEquals( count($pagesCsv), 13 );

		$this->assertEquals( $pagesCsv[9][0], 9 );
		$this->assertEquals( $pagesCsv[9][1], '<p style="color:#f00;">404 - File NOT Exists.</p><p style="color:#f00;">'.htmlspecialchars( $this->fs->get_realpath(__DIR__.'/testdata/standard/testpage4/test4-2.html') ).'</p>' );

		$this->assertTrue( $this->fs->is_dir( __DIR__.'/output/unzip_execute_test_002.zip/pickles2_export/files/bgeditor/img/' ) );
		$this->assertTrue( $this->fs->is_file( __DIR__.'/output/unzip_execute_test_002.zip/pickles2_export/files/bgeditor/img/pages___-__common__-__images__-__sample_image.png' ) );
		$this->assertTrue( $this->fs->is_file( __DIR__.'/output/unzip_execute_test_002.zip/pickles2_export/files/bgeditor/img/pages___-__testpage1__-__index_files__-__sample_image.jpg' ) );
	} // testPagesCsv()

}
