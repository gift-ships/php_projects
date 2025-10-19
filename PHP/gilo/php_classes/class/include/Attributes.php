<?php 
Class attribute {
	private $Attribs = array();
	public function __construct(){
		
	}
	public function AddAttrib($Namevalue)
		foreach($Namevalue as $key => $value){
				$this->Attribs[$key] = $value;
			}
		
	}
	public function AddAttrib($attribname,$value)
	
	{ /*attribs wont be repeated*/
		$this->Attribs[$attribname] = $value;
		
	}
	
	public function render(){
		if (isset($this->Attribs)){
			foreach($this->Attribs as $key => $value){
				echo " $key = \"$value\""
			}
		}
	}
	
}
?>