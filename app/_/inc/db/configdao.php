<?
class ConfigDao
{
	private $db = null ;

	public function __construct() {
		$this->db = SqliteDb::getInstance() ;
	}

	public function save($configobj) {
        if($configobj->key != null) {
            $res = $this->getValueByKey($configobj->key) ;
        } else {
            $res = null ;
        }

        $stmt = null ;
        if($res !=null && $res != "") {
            $stmt = $this->db->db->prepare("UPDATE config SET value=:value WHERE key=:key");
        } else {
            $stmt = $this->db->db->prepare("INSERT INTO config (key, value) VALUES (:key, :value)");
        }

        $stmt->bindValue(":key", $configobj->key);
        $stmt->bindValue(":value", $configobj->value);
        $stmt->execute() ;
	}

    public function getValueByKey($key) {
        $stmt = $this->db->db->prepare("SELECT value FROM config WHERE key=:key");
        $stmt->bindValue(":key", $key);
        return $stmt->execute()->fetchArray()["value"] ;
    }
}
?>