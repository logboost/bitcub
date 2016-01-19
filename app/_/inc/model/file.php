<?
class File 
{
	protected $id ;
	protected $fid ;
	protected $name ;
	protected $type ;
	protected $size ;
	protected $dtoken ;
	protected $adddate ;
	protected $lastusagedate ;
	protected $usage ;

	public function __get($property) {
		if('id' === $property) {
		  return $this->id;
	    } else if('fid' === $property) {
	      return $this->fid;
	    } else if('name' === $property) {
			return $this->name;
		} else if('type' === $property) {
			return $this->type;
		} else if('size' === $property) {
			return $this->size;
		} else if('dtoken' === $property) {
			return $this->dtoken;
		} else if('adddate' === $property) {
			return $this->adddate;
		} else if('lastusagedate' === $property) {
			return $this->lastusagedate;
		} else if('usage' === $property) {
			return $this->usage;
	    } else {
	      throw new Exception('Invalid property '.$property);
	    }
	}

	public function __set($property,$value) {
	    if('id' === $property) {
		  $this->id = $value; 
	    } else if('fid' === $property) {
	      $this->fid = $value;  
	    } else if('name' === $property) {
	      $this->name = $value; 
	    } else if('type' === $property) {
	      $this->type = $value; 
	    } else if('size' === $property) {
	      $this->size = $value; 
	    } else if('dtoken' === $property) {
	      $this->dtoken = $value; 
	    } else if('adddate' === $property) {
	      $this->adddate = $value; 
	    } else if('lastusagedate' === $property) {
	      $this->lastusagedate = $value; 
	    } else if('usage' === $property) {
	      $this->usage = $value; 
	    } else {
	      throw new Exception('Invalid property');
	    }
  	}
}
?>