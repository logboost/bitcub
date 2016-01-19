<?
class ConfigObj 
{
	protected $id ;
	protected $key ;
	protected $value ;

	public function __construct($key, $value) {
		$this->key = $key;
		$this->value = $value ;
	}

	public function __get($property) {
		if('id' === $property) {
		  return $this->id;
	    } else if('key' === $property) {
	      return $this->key;
	    } else if('value' === $property) {
			return $this->value;
	    } else {
	      throw new Exception('Invalid property '.$property);
	    }
	}

	public function __set($property,$value) {
	    if('id' === $property) {
		  $this->id = $value; 
	    } else if('key' === $property) {
	      $this->fid = $key;  
	    } else if('value' === $property) {
	      $this->value = $value; 
	    } else {
	      throw new Exception('Invalid property');
	    }
  	}
}
?>