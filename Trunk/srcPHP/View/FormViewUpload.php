<?php
include_once "FormView.php";

class FormViewUpload extends FormView{
	function FormViewUpload($action){
		parent::FormView($action);
	}

	function linkCSS(){ }

	function linkJS(){ }

	function onLoadJS(){ return ""; }

	function execute(){

	}

	function draw(){
		echo "<div class=\"frame2\">";
		echo "<form id=\"upload\" action=\"".$this->action."\" method=\"post\">";
		echo "<label> test </label>";
		echo "</form>";
		echo "</div>";
	}
}

?>
