<?php
include_once "srcPHP/Model/ResearchModel.php";
include_once "srcPHP/View/View.php";
include_once "srcPHP/View/Player/PlayerView.php";

class ListPatientView implements View{

	var $patientList = NULL;
	var $videoList = NULL;
	var $player = NULL;

	function ListPatientView($id_doctor){
		try{
			if(is_numeric($id_doctor)){
				$tmp = new ResearchModel("dbserver", "xjouveno", "xjouveno", "pdp");
				$this->patientList = $tmp->getListOfPatients($id_doctor);

				if(isset($_GET) && isset($_GET["patient"]) && !empty($_GET["patient"]) && is_numeric($_GET["patient"]))
					$this->videoList = $tmp->getVideosPatient($_GET["patient"]);
				if(isset($_GET) && isset($_GET["play"]) && !empty($_GET["play"]))
					$this->player = new PlayerView($_GET["play"]);
				else
					$this->player = new PlayerView();
			}
			else
				throw new Exception("ERREUR - Fonction ListPatientView(...) - Verifier les types des parametres");
		}catch(Exception $e){
			$e->getMessage();
		}
	}

	function linkCSS(){
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/list_patient.css\">";
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/tag.css\">";
		$this->player->linkCSS();
	}

	function linkJS(){
		echo "<script src=\"js/listPatient.js\"> </script>";
		$this->player->linkJS();
	}

	function onLoadJS(){ return "adaptCSSSection();".$this->player->onLoadJS(); }

	function draw(){
		echo "<nav id=\"ListOfPatients\">";
		echo "<label>Vos Patients</label>";
		if(count($this->patientList) > 0){
			echo "<ul id=\"PatientList\" type=none;>";
			for($i=0; $i<count($this->patientList); $i++){
				echo "<li onclick=\"showVideoOfPatient(".$this->patientList[$i]["Id"].")\" onmouseOver=\"onMouseOver(this);\" onmouseout=\"onMouseOut(this);\">".$this->patientList[$i]["Name"]."</li>";
				if(isset($_GET) && isset($_GET["patient"]) && !empty($_GET["patient"]) && is_numeric($_GET["patient"]) && $this->patientList[$i]["Id"] == $_GET["patient"]){
					if(count($this->videoList) > 0){
						echo "<li>";
						echo "<ul id=\"VideoList\" type=none>";
						for($j=0; $j<count($this->videoList); $j++){
//							echo "<li onclick=\"showVideo(".$_GET["patient"].",'".$this->videoList[$j]["Filename"]."');\" onmouseover=\"onMouseOver(this);\" onmouseout=\"onMouseOut(this);\">".$this->videoList[$j]["Title"]."</li>";
							echo "<li><span onclick=\"showVideo(".$_GET["patient"].",'".$this->videoList[$j]["Id"]."');\" onmouseover=\"onMouseOver(this);\" onmouseout=\"onMouseOut(this);\"><label>".$this->videoList[$j]["Title"]."</label></span><a href=\"index.php?form=sendXML&video=".$this->videoList[$j]["Id"]."\" ><img src=\"azer\"/></a></li>";
						}
						echo "</ul>";
						echo "</li>";
					}
					else
						echo "<label>Aucune Video Associe a ce patient</label>";
				}
			}
			echo "</ul>";
		}
		else
			echo "<label>Aucun patient ne vous est associe</label>";
		echo "</nav>";
		$this->player->draw();
	}
}
?>
