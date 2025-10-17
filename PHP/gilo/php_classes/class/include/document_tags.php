<?php 

function exceptions_error_handler($severity, $message, $filename, $lineno) {
    throw new ErrorException($message, 0, $severity, $filename, $lineno);
}

//set_error_handler('exceptions_error_handler');

interface Element {
	    /*public string   $ElementClass { get; set; }*/
        public function AddElement($element);
        public function render();
    }
	
Class Attrib {
	private $Attribs = array();
	public function __construct(){
		
	}
	public function AddAttrib($attribname,$value):void 
	
	{ /*attribs wont be repeated*/
		$this->Attribs[$attribname] = $value;
		
	}
	public function renderAttrib():void {
		if (isset($this->Attribs)){
			foreach($this->Attribs as $key => $value){
			echo $key.'="'.$value.'"' ;
			}
		}
		
	}
	
}
Class Title implements Element{
	/*public string $ElementClass{ get; set; }*/
	private String $Title = "";
	
	public function __construct($title){
		$this->Title = $title;
		$ElementClass = get_class($this); 
	}
    public function AddElement($element):void {
		throw new ErrorException("AddElement function  not allowed for Object ".get_class($this), 0, 1, "documents_tags.php", 1 );
		 
		/*$this->Elements[] = $element;*/
	}
    public function render():void {
	   
		echo "<title>". $this->Title ."</title>";
	}	
}

Class Header_i implements Element{
	/*public string $ElementClass{ get; set; }*/
	private String $Header = "";
	
	public function __construct($header){
		$this->Header = $header;
		$ElementClass = get_class($this); 
	}
    public function AddElement($element):void {
		throw new ErrorException("AddElement function  not allowed for Object ".get_class($this), 0, 1, "documents_tags.php", 1 );
		 
		/*$this->Elements[] = $element;*/
	}
    public function render():void {
	    if (isset($this->Header))
		{echo "<h1>{$this->Header}</h1>";}
	}	
}
Class Table extends Attrib implements Element{
	private String $caption;
	private $Elements = array();
    private $Tablecolumn;
	public function __construct($tablecaption,$tablecolumn){
		$this->caption = $tablecaption; 
		
		$this->Tablecolumn = explode(",", $tablecolumn ); 
	}
    public function AddElement($element):void {
		array_push($this->Elements,(object) $element);

	}

	public function render():void {
		echo "<table ",$this->renderAttrib()," >";
		if (isset($this->caption) && strlen($this->caption) > 0){
			echo "<caption>".$this->caption."<caption>";
		}
		if (isset($this->Tablecolumn)){
			echo "<thead>";
			echo "<tr>";
			foreach($this->Tablecolumn as $column){
				echo "<th>". $column."</th>";
			}
			echo "</tr>";
			echo "</thead>";
		}
		if (isset($this->Elements)){
			foreach($this->Elements as $element){
				$element->render();
			}
		}
		echo "</table>";
		
	}
}
Class HtmlBody extends Attrib implements Element {
	/*public string $ElementClass{ get; set; }*/
	private $Elements = array();
	public function __construct(){
		
	}
    public function AddElement($element):void {
		array_push($this->Elements,(object) $element);

	}
    public function render():void {
	   echo "<body>";
		if (isset($this->Elements)){
			foreach($this->Elements as $element){
				$element->render();
			}
		}
		echo "</body>";
	}	
}
/*
Class HtmlBody implements Element{
	public string $ElementClass{ get; set; }
	private $Elements = array();
	public function __construct(){
		
	}
    public function AddElement($element){
		array_push($this->Elements,(object) $element);

	}
    public function render(){
	   
		echo "<body>";
		
		if (isset($this->Elements)){
			foreach($this->Elements as $element){
				$element->render();
			}
		}
		echo "</body>";
	}	
}*/
Class Head implements  Element{
	private $Elements = array();
	/*public string $ElementClass{ get; set; }*/
	public function render():void {
	   
		echo "<head>";
		if (isset($this->Elements)){
			foreach($this->Elements as $element){
				$element->render();
			}
		}
		echo "</head>";
	}
	public function __construct(){
		$ElementClass = get_class($this); 
	}
    public function AddElement($element):void {
		
		array_push($this->Elements,(object) $element);
	}		
}

Class Style implements  Element {
	private String $Style;
	private $Elements = array();
	public function __construct($style){
		
		$this->Style = $style; 
		
	}
	public function AddElement($element):void {
		//throw new ErrorException("AddElement function  not allowed for Object 'Style'", 0, 1, "documents_tags.php", 1 );
		 array_push($this->Elements,(object) $element);
	}
	public function render():void {
		if (isset($this->Style)){
			echo "<style>";
			foreach($this->Elements as $element){
				$element->render();
			}
		echo $this->Style ."</style>";}
	}
}

?>

