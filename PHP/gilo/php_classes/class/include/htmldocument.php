<?php
class Document {
	private String $docType;
	private object $docBoby;
	private String $title;
	//private $bodyl =  new stdClass();	
	private $lang = "en";
    private $innerhtmlTags = [];
	private $tagCount = 0;
	public function __construct($doc_type,$title){
		$this->docType = $doc_type;
		$this->title = $title;
	}
	
	public function addBody( $Body){
		$this->body = $Body;
		
		
	}
	public function addInnerTag($tag ){
		$innerhtmlTags[$tagCount] = $tag;
		$tagCount++;
	}
	public function render(){
		//parent::render();
		try
		{
			//if (strcmp({$docType},"html")){
				
				echo "<!DOCTYPE html>";
				echo "<html>";
				echo "<head>";
				
				if (isset($this->title)){
					echo "<title>". $this->title ."</title>";
				}
				echo "</head>";
				echo "</body></html>";
	
		}
		catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	
	}
	
}
?>