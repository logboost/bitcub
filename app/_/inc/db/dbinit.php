<?
require ("_/inc/model/file.php") ;
require ("_/inc/model/session.php") ;
require ("_/inc/model/configobj.php") ;
require ("_/inc/db/sessionsdao.php") ;
require ("_/inc/db/filesdao.php") ;
require ("_/inc/db/configdao.php") ;

//INIT DATABASE
class SqliteDb
{
	private static $instance = null ;
	public $db = null ;
	public static $dbfile = "sqlite.db" ;
	public static $dbpath = "" ;

	private function __construct() {
		if(!file_exists(self::$dbpath.'db/'.self::$dbfile)) {
			$this->db = new SQLite3(self::$dbpath.'db/'.self::$dbfile);

			// CREATE SESSIONS TABLE
			$this->db->exec('CREATE TABLE sessions (
				id INTEGER PRIMARY KEY ,
				sid VARCHAR(256),
				authcode VARCHAR(2048),
				username VARCHAR(128),
				ip VARCHAR(128),
				date DATE,
				validuntil DATE,
				plan INTEGER
				);');

			// CREATE FILES TABLE
			$this->db->exec('CREATE TABLE files (
				id INTEGER PRIMARY KEY ,
				fid VARCHAR(256),
				name VARCHAR(2048),
				type VARCHAR(256),
				size INTEGER,
				dtoken VARCHAR(256),
				adddate DATE,
				lastusagedate DATE,
				usage INTEGER
				);');

			// CREATE CONFIG TABLE
			$this->db->exec('CREATE TABLE config (
				id INTEGER PRIMARY KEY ,
				key VARCHAR(256),
				value VARCHAR(2048)
				);');

			$this->db->exec('INSERT INTO config (key, value) VALUES ("hoster_name", "Bitcub");');
			$this->db->exec('INSERT INTO config (key, value) VALUES ("openid_clientid ", "");');
			$this->db->exec('INSERT INTO config (key, value) VALUES ("openid_clientsecret ", "");');
			$this->db->exec('INSERT INTO config (key, value) VALUES ("maxfilesize ", 0);');
		} else {
			$this->db = new SQLite3(self::$dbpath.'db/'.self::$dbfile);
		}
	}

	public static function getInstance() {
		if (self::$instance == null) {
			self::$instance = new SqliteDb ;
		}

		return self::$instance ;
	}
}
?>