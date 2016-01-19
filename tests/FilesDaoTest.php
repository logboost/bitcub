<?php
class FilesDaoTest extends PHPUnit_Framework_TestCase {
	
	// Check if FilesDao save function create a
	// new row when the id is unknow
	public function testSave() {

		$fdao = new FilesDao() ;

		$file = new File() ;
		$file->fid = "testfid" ;
		$file->name = "testname" ;
		$fdao->save($file) ;

		$res = $fdao->getByFid("testfid") ;

		$this->assertGreaterThan(0, $res);

		$res = $fdao->getByFid("fzefezfez") ;

		$this->assertEquals(0, $res);

	}

	// Check if FilesDao save function update
	// properly the existing row when passing
	// an already assigned id
	public function testUpdate() {

		$fdao = new FilesDao() ;

		$file = new File() ;
		$file->fid = "testfid" ;
		$file->name = "testname" ;
		$fdao->save($file) ;

		$res = $fdao->getByFid("testfid") ;

		$this->assertGreaterThan(0, $res);

		$dfile = $res ;

		$dfile->name = "changedname" ;

		$fdao->save($dfile) ;

		$mfile = $fdao->getById($dfile->id) ;

		$this->assertEquals("changedname", $mfile->name) ;
	}

}
?>