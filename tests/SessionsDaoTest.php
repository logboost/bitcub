<?php
class SessionsDaoTest extends PHPUnit_Framework_TestCase {
	
	// Check if FilesDao save function create a
	// new row when the id is unknow
	public function testSave() {

		$fdao = new SessionsDao() ;

		$session = new Session() ;
		$session->sid = "testsid" ;
		$session->username = "testname" ;
		$fdao->save($session) ;

		$res = $fdao->getBySid("testsid") ;

		$this->assertGreaterThan(0, $res);

		$res = $fdao->getBySid("fzefezfez") ;

		$this->assertEquals(0, $res);

	}

	// Check if FilesDao save function update
	// properly the existing row when passing
	// an already assigned id
	public function testUpdate() {

		$fdao = new SessionsDao() ;

		$session = new Session() ;
		$session->sid = "testsid" ;
		$session->username = "testname" ;
		$fdao->save($file) ;

		$res = $fdao->getBySid("testsid") ;

		$this->assertGreaterThan(0, $res);

		$dsession = $res[0] ;

		$dsession->username = "changedname" ;

		$fdao->save($dsession) ;

		$msession = $fdao->getById($dsession->id)[0] ;

		$this->assertEquals("changedname", $msession->username) ;
	}

}
?>