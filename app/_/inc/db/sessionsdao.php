<?
class SessionsDao
{
	private $db = null ;

	public function __construct() {
		$this->db = SqliteDb::getInstance() ;
	}

	protected function execute($stmt) {
        $res = $stmt->execute();

        $i=0 ;
        $sessions = null ;
        while($obj = $res->fetchArray()) {
            $sessions[$i] = new Session();

            $sessions[$i]->id = $obj['id'];
            $sessions[$i]->sid = $obj['sid'];
            $sessions[$i]->authcode = $obj['authcode'];
            $sessions[$i]->username = $obj['username'];
            $sessions[$i]->ip = $obj['ip'];
            $sessions[$i]->date = $obj['date'];
            $sessions[$i]->validuntil = $obj['validuntil'];
            $sessions[$i]->plan = $obj['plan'];
            $i++ ;
        }
        return $sessions ;
	}

	public function save($session) {
        if($session->id != null) {
            $res = $this->getById($session->id) ;
        } else {
            $res = null ;
        }

        $stmt = null ;
        if(count($res) > 0) {
            $stmt = $this->db->db->prepare("UPDATE sessions SET sid=:sid, authcode=:authcode, username=:username, ip=:ip, date=:date, validuntil=:validuntil, plan=:plan where id=:id");
            $stmt->bindValue(":id", $session->id);
        } else {
            $stmt = $this->db->db->prepare("INSERT INTO sessions (sid, authcode, username, ip, date, validuntil, plan) VALUES (:sid, :authcode, :username, :ip, :date, :validuntil, :plan)");
        }

        $stmt->bindValue(":sid", $session->sid);
        $stmt->bindValue(":authcode", $session->authcode);
        $stmt->bindValue(":username", $session->username);
        $stmt->bindValue(":ip", $session->ip);
        $stmt->bindValue(":date", $session->date);
        $stmt->bindValue(":validuntil", $session->validuntil);
        $stmt->bindValue(":plan", $session->plan);
        $stmt->execute() ;
	}

    public function getById($id) {
        $stmt = $this->db->db->prepare("SELECT * FROM sessions WHERE id=:id");
        $stmt->bindValue(":id", $id);
        return $this->execute($stmt) ;
    }

	public function getBySid($sid) {
		$stmt = $this->db->db->prepare("SELECT * FROM sessions WHERE sid=:sid");
		$stmt->bindValue(":sid", $sid);
    	return $this->execute($stmt) ;
	}

    public function countSessions() {
        $stmt = $this->db->db->prepare("SELECT count(*) as count FROM sessions WHERE 1");
        return $stmt->execute()->fetchArray()["count"] ;
    }

    public function getSessionToday() {
        $datetoday = @date('Y-m-d');
        $stmt = $this->db->db->prepare("SELECT * FROM sessions WHERE strftime('%Y-%m-%d', date) = :datetoday");
        $stmt->bindValue(":datetoday", $datetoday);
        return $this->execute($stmt) ;
    }

    public function countUsers() {
        $stmt = $this->db->db->prepare("SELECT count(*) as count FROM (SELECT count(*) from sessions GROUP BY username)");
        return $stmt->execute()->fetchArray()["count"] ;
    }
}
?>