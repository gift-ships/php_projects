<?php
include "document_tags.php";
class Document extends Attrib implements Element{
	private String $DocType;
	private HtmlBody $DocBody;
	private Title $Title;
	private Style $Style;
	private Header_i $Header1;
	//private $bodyl =  new stdClass();	
	private $lang = "en";
    private $innerhtmlTags = [];
	private $tagCount = 0;
	public function __construct($doc_type,$title){
		$this->DocType = $doc_type;
		$this->Title = new Title($title);
		$this->DocBody =  new HtmlBody();
		$this->AddAttrib("lang","en");
	}
	public function AddElement($element){
		$this->DocBody->AddElement($element);
	}
	
	public function addStyle($style){
		$this->Style = new Style($style);
		
		
	}
	public function render(){
		try
		{
			echo "<!DOCTYPE ".$this->DocType.">";
			echo "<".$this->DocType.">";
			if (isset($this->Title)){
				$this->Title->render();
			}
			if (isset($this->Style)){
				$this->Style->render();
			}
			$this->DocBody->render();
			
		}
		catch (Exception $e) 
		{
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	
	}
	
}
?>