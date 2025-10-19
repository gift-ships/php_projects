<?php
include "document_tags.php";
class Document implements Element{
	private String $DocType;
    private $Elements = array();

	public function __construct($doc_type,$doc){
		$this->DocType = $doc_type;
		$this->AddElement($doc);
		
	}
	  public function AddElement($element){
		array_push($this->Elements,(object) $element);

	}
	
	public function render(){
		try
		{
			echo "<!DOCTYPE ".$this->DocType.">";
			if (isset($this->Elements)){
			foreach($this->Elements as $element){
				$element->render();
			}
		}
			
			//$this->DocBody->render();
			
		}
		catch (Exception $e) 
		{
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	
	}
	
}
?>