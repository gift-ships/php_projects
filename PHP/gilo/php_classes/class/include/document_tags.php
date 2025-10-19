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
	public function AddAttrib(/*$attribname,$value*/):void 
	
	{ /*attribs wont be repeated*/
		$numArgs = func_num_args();
		
		if ($numArgs == 2){
		$this->Attribs[func_get_arg(0)] = func_get_arg(1);
		}
		elseif($numArgs == 1 && is_array(func_get_arg(0))){
			foreach(func_get_arg(0) as $key => $value){
				$this->Attribs[$key] = $value;
			}
		}
		else {
		    throw new ErrorException("AddAttrib1 function  not allowed for Object ".get_class($this)." with arguments ".$numArgs, 0, 1, "documents_tags.php", 1 );
			
		}
		
		
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

Class HeaderL implements Element{
	/*public string $ElementClass{ get; set; }*/
	private String $Header = "";
	private $HeaderL;
	public function __construct($headerl,$header){
		$this->Header = $header;
		$this->HeaderL = $headerl;
	}
    public function AddElement($element):void {
		throw new ErrorException("AddElement function  not allowed for Object ".get_class($this), 0, 1, "documents_tags.php", 1 );
	}
    public function render():void {
	    echo "<{$this->HeaderL}>";
		if (isset($this->Elements)){
			foreach($this->Elements as $element){
				$element->render();
			}
		}
		
		if (isset($this->Header)){
		
		 echo $this->Header;
		}
		echo "</$this->HeaderL>";}
		
}
Class Label extends Attrib implements Element{
	private $Class;
	private $Label ;

	public function __construct($class,$label){
		$this->Label = $label;
		$this->Class = $class;	
		}
	public function AddElement($element):void {
		throw new ErrorException("AddElement function  not allowed for Object ".get_class($this), 0, 1, "documents_tags.php", 1 );
	}
	
	public function render():void {
		if (isset($this->Label)){	
			echo "<label ",$this->renderAttrib(),">";
			if (isset($this->Elements)){
				foreach($this->Elements as $element){
					$element->render();
				}
			}		
				echo $this->Label.
				     "</label>";
		}
		
	}
}
Class Icon extends Attrib implements Element{
	private $Class;
	private $Icon ;

	public function __construct($class,$icon){
		$this->Icon = $icon;
		$this->Class = $class;	
		}
	public function AddElement($element):void {
		throw new ErrorException("AddElement function  not allowed for Object ".get_class($this), 0, 1, "documents_tags.php", 1 );
	}
	
	public function render():void {
		if (isset($this->Icon)){		
				echo "<i class=\"{$this->Icon}\"></i>";
		}
		
	}
}
Class Span extends Attrib implements Element{
	private $id ;
	private $Elements = array();
	private $Class;
	public function __construct($class,$text){
		$this->Class = $class;
		$this->Text = $text;
		if (strlen($this->Class)> 0){
			$this->AddAttrib("class",$this->Class);
		}
	}
	public function AddElement($element):void {
		array_push($this->Elements,(object) $element);

	}
	public function getElementId():Int{
		return $this->id;
	}
	public function render():void {
		echo "<span ",$this->renderAttrib(),">";
		if (isset($this->Elements)){
			foreach($this->Elements as $element){
				$element->render();
			}
		}
		if (isset($this->Text) && strlen($this->Text) > 0){
			echo $this->Text;
		}
		echo "</span>";
	}

}
Class Meta extends Attrib implements Element{
	private $id ;
	private $Elements = array();


//	private $Icon ;
	public function __construct(){
	}
	public function AddElement($element):void {
		throw new ErrorException("AddElement function  not allowed for Object ".get_class($this), 0, 1, "documents_tags.php", 1 );
	}
	 public function getElementId():Int{
		return $this->id;
	}
	public function render():void {
		echo "<meta ",$this->renderAttrib(),">";
	}
}
Class TableRow extends Attrib implements Element{
	private $id ;
	private $Elements = array();
	private $Span ;
	private $Class;
//	private $Icon ;
	public function __construct(){
	}
	public function AddElement($element):void {
		array_push($this->Elements,(object) $element);
	}
	 public function getElementId():Int{
		return $this->id;
	}
	public function render():void {
		echo "<tr ",$this->renderAttrib(),">";
		if (isset($this->Elements)){
			foreach($this->Elements as $element){
				$element->render();
			}
		}
		echo "</tr>";
	}
}
Class Button extends Attrib implements Element{
	private $id ;
	private $Elements = array();
	private $Span ;
	private $Class;
//	private $Icon ;
	public function __construct($class,$text){
		$this->Text = $text;
		$this->Class = $class;	
		$this->AddAttrib("class",$this->Class);
		$this->AddAttrib("type","button");
		}
	public function AddElement($element):void {
		array_push($this->Elements,(object) $element);

	}
	 public function getElementId():Int{
		return $this->id;
	}
	public function render():void {
		echo "<button ",$this->renderAttrib(),">";
	
		if (isset($this->Elements)){
			foreach($this->Elements as $element){
				$element->render();
			}
		}
	    if (isset($this->Text)){
			$Span = new Span ("css-button-text","");
			$Span->AddElement(new Span("",$this->Text));
			$Span->render();
		}
		echo "</button>";
	}
}
Class Input extends Attrib implements Element{
private $id ;
	private $Elements = array();
//	private $Icon ;
	public function __construct($text){
		if (isset($text)&& strlen($text)>0){
			$this->Text = $text;
		}
	}
	public function AddElement($element):void {
		array_push($this->Elements,(object) $element);

	}
	 public function getElementId():Int{
		return $this->id;
	}
	public function render():void {
		echo "<input ",$this->renderAttrib(),">";
	
		if (isset($this->Elements)){
			foreach($this->Elements as $element){
				$element->render();
			}
		}
		if (isset($this->Text)){
			echo $this->Text;
		}
		echo "</input>";
	}
}
Class TableHead extends Attrib implements Element{
	private $id ;
	private $Elements = array();
//	private $Icon ;
	public function __construct(){
		
	}
	public function AddElement($element):void {
		array_push($this->Elements,(object) $element);

	}
	 public function getElementId():Int{
		return $this->id;
	}
	public function render():void {
		echo "<thead ",$this->renderAttrib(),">";
	
		if (isset($this->Elements)){
			foreach($this->Elements as $element){
				$element->render();
			}
		}
		
		echo "</thead>";
	}
}
Class TableColumn extends Attrib implements Element{
	private $id ;
	private $Elements = array();
//	private $Icon ;
	public function __construct($text){
		if (isset($text)&& strlen($text)>0){
			$this->Text = $text;
		}
	}
	public function AddElement($element):void {
		array_push($this->Elements,(object) $element);

	}
	 public function getElementId():Int{
		return $this->id;
	}
	public function render():void {
		echo "<th ",$this->renderAttrib(),">";
	
		if (isset($this->Elements)){
			foreach($this->Elements as $element){
				$element->render();
			}
		}
		if (isset($this->Text)){
			echo $this->Text;
		}
		echo "</th>";
	}
}
Class TableBody extends Attrib implements Element{
	private $id ;
	private $Elements = array();
//	private $Icon ;
	public function __construct(){
		
	}
	public function AddElement($element):void {
		array_push($this->Elements,(object) $element);

	}
	 public function getElementId():Int{
		return $this->id;
	}
	public function render():void {
		echo "<tbody ",$this->renderAttrib(),">";
	
		if (isset($this->Elements)){
			foreach($this->Elements as $element){
				$element->render();
			}
		}
		if (isset($this->Text)){
			echo $this->Text;
		}
		echo "</tbody>";
	}
}
Class Table extends Attrib implements Element{
	private String $caption;
	private $id ;
	private $Elements = array();
    private $Tablecolumn;
	private $TableHead;
	public function __construct($tablecaption,$tablecolumn){
		$this->caption = $tablecaption; 
		
		$this->Tablecolumn = explode(",", $tablecolumn ); 
		$this->TableHead = new TableHead();
	}
    public function AddElement($element):void {
		array_push($this->Elements,(object) $element);

	}
 public function getElementId():Int{
	 return $this->id;
 }
 public function getTableHead():TableHead{
	 return $this->TableHead;
 }
 public function setTableHead($tablehead){
	  $this->TableHead = $tablehead;
 } 
	public function render():void {
		$TableRow = new TableRow();
		
		echo "<table ",$this->renderAttrib()," >";
		if (isset($this->caption) && strlen($this->caption) > 0){
			echo "<caption>".$this->caption."<caption>";
		}
		if (isset($this->Tablecolumn)){
			
			foreach($this->Tablecolumn as $column){
			
			$TableColumn = new TableColumn($column);
            $TableRow->AddElement($TableColumn);
			
			}
			$this->TableHead->AddElement($TableRow);
			$this->AddElement($this->TableHead);
		}
		if (isset($this->Elements)){
			foreach($this->Elements as $element){
				$element->render();
			}
		}
		echo "</table>";
		
	}
}
Class Div extends Attrib implements Element {
	/*public string $ElementClass{ get; set; }*/
	private $Elements = array();
	public function __construct(){
		
	}
    public function AddElement($element):void {
		array_push($this->Elements,(object) $element);

	}
    public function render():void {
	   echo "<div ",$this->renderAttrib(),">";
		if (isset($this->Elements)){
			foreach($this->Elements as $element){
				$element->render();
			}
		}
		echo "</div>";
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

Class HtmlDoc extends Attrib implements Element{
	
	private $Elements = array();
	public function __construct(){
		
	}
    public function AddElement($element){
		array_push($this->Elements,(object) $element);

	}
    public function render(){
	   
		echo "<html ",$this->renderAttrib(),">";
		
		if (isset($this->Elements)){
			foreach($this->Elements as $element){
				$element->render();
			}
		}
		echo "</html>";
	}	
}
Class Path extends Attrib implements Element{
	private $Elements = array();
	public function __construct(){
		
	}
    public function AddElement($element){
		array_push($this->Elements,(object) $element);

	}
    public function render(){
	   
		echo "<path ",$this->renderAttrib(),">";
		
		if (isset($this->Elements)){
			foreach($this->Elements as $element){
				$element->render();
			}
		}
		echo "</path>";
	}
}  
Class SVectorG extends Attrib implements Element{
	private $Elements = array();
	public function __construct(){
		
	}
    public function AddElement($element){
		array_push($this->Elements,(object) $element);

	}
    public function render(){
	   
		echo "<svg ",$this->renderAttrib(),">";
		
		if (isset($this->Elements)){
			foreach($this->Elements as $element){
				$element->render();
			}
		}
		echo "</svg>";
	}	
}
Class Script implements Element{
	private $Elements = array();
	private String $Script;
	public function __construct($script){
		$this->Script = $script;
	}
    public function AddElement($element){
		//array_push($this->Elements,(object) $element);

	}
    public function render(){
	   
		echo "<script>";
		
		if (isset($this->Elements)){
			foreach($this->Elements as $element){
				$element->render();
			}
		}
		echo $this->Script;
		echo "</script>";
	}	
}
Class DocHead extends Attrib implements Element{
	private $Elements = array();
	/*public string $ElementClass{ get; set; }*/
	public function render():void {
	   
		echo "<head>";
		if (isset($this->Elements)){
			foreach($this->Elements as $element){
				$element->render();
			}
		}
		include "class\scripts\headscript.php";
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

