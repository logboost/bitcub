<?
class FilesDao
{
	private $db = null ;

	public function __construct() {
		$this->db = SqliteDb::getInstance() ;
	}

    protected function execute($stmt) {
        $res = $stmt->execute();

        $i=0 ;
        while($obj = $res->fetchArray()) {
            $files[$i] = new File();

            $files[$i]->id = $obj['id'];
            $files[$i]->fid = $obj['fid'];
            $files[$i]->name = $obj['name'];
            $files[$i]->type = $obj['type'];
            $files[$i]->size = $obj['size'];
            $files[$i]->dtoken = $obj['dtoken'];
            $files[$i]->adddate = $obj['adddate'];
            $files[$i]->lastusagedate = $obj['lastusagedate'];
            $files[$i]->usage = $obj['usage'];

            $i++ ;
        }
        return $files ;
    }

	public function save($file) {
        if($file->id != null) {
            $res = $this->getById($file->id) ;
        } else {
            $res = null ;
        }

        $stmt = null ;
        if(count($res) > 0) {
            $stmt = $this->db->db->prepare("UPDATE files SET fid=:fid, name=:name, type=:type, size=:size, dtoken=:dtoken, adddate=:adddate, lastusagedate=:lastusagedate, usage=:usage where id=:id");
            $stmt->bindValue(":id", $file->id);
        } else {
            $stmt = $this->db->db->prepare("INSERT INTO files (fid, name, type, size, dtoken, adddate, lastusagedate, usage) VALUES (:fid, :name, :type, :size, :dtoken, :adddate, :lastusagedate, :usage)");
        }

        $stmt->bindValue(":fid", $file->fid);
        $stmt->bindValue(":name", $file->name);
        $stmt->bindValue(":type", $file->type);
        $stmt->bindValue(":size", $file->size);
        $stmt->bindValue(":dtoken", $file->dtoken);
        $stmt->bindValue(":adddate", $file->adddate);
        $stmt->bindValue(":lastusagedate", $file->lastusagedate);
        $stmt->bindValue(":usage", $file->usage);

        $stmt->execute() ;
	}

	public function getById($id) {
        $stmt = $this->db->db->prepare("SELECT * FROM files WHERE id=:id");
        $stmt->bindValue(":id", $id);
        return $this->fetchLast($this->execute($stmt)) ;
    }

	public function getByFid($fid) {
		$stmt = $this->db->db->prepare("SELECT * FROM files WHERE fid=:fid");
		$stmt->bindValue(":fid", $fid);
    	return $this->fetchLast($this->execute($stmt)) ;
	}

    public function countFiles() {
        $stmt = $this->db->db->prepare("SELECT count(*) as count FROM files WHERE 1");
        return $stmt->execute()->fetchArray()["count"] ;
    }

    public function filesTotalSize() {
        $stmt = $this->db->db->prepare("SELECT sum(size) as size FROM files WHERE 1");
        return $stmt->execute()->fetchArray()["size"] ;
    }

    public function getLastFiles($start,$nb) {
        $stmt = $this->db->db->prepare("SELECT * FROM files WHERE 1 ORDER BY id DESC LIMIT :start,:nb ");
        $stmt->bindValue(":start", $start);
        $stmt->bindValue(":nb", $nb);
        return $this->execute($stmt) ;
    }

    public function searchByName($name) {
        $name = "%".$name."%";
        $stmt = $this->db->db->prepare("SELECT * FROM files WHERE name LIKE :name ORDER BY id DESC");
        $stmt->bindValue(":name", $name);
        return $this->execute($stmt) ;
    }

    public function deleteFile($fid) {
        $stmt = $this->db->db->prepare("DELETE FROM files WHERE fid=:fid");
        $stmt->bindValue(":fid", $fid);
        return $stmt->execute();
    }

    private function fetchLast($res) {
        if(count($res) > 0) {
            return $res[count($res)-1] ;
        }
        return null ;
    }
}
?>