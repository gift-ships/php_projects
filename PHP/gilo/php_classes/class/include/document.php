<?php
include "document_tags.php";
class Document implements Element{
	private String $DocType;
	private HtmlBody $DocBody;
	private Title $Title;
	private Style $Style;
	private Header_i $Header1;
	//private $bodyl =  new stdClass();	
	private $lang = "en";
    private $innerhtmlTags = [];
	private $tagCount = 0;
	public function __construct($doc_type,$title,$lang){
		$this->DocType = $doc_type;
		$this->Title = new Title($title);
		$this->DocBody =  new HtmlBody();
		$this->lang = $lang;
		
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
			echo "<".$this->DocType." lang=$this->lang>";
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