<?php
/**
 *\file		AdminMenu.php
 *\author	Antoine Laumond, Romain Fontaine, Tom Solacroup, Xavier Jouvenot
 *\version	2.0
 *\date		08 Avril 2014
 *\brief	Defini la classe de la vue du menu des Administrateurs de cette application.
 *
 *\details	Cette classe permet de gerer les diff�rents menus et d'afficher le bon, au bon moment
 *			C'est la classe qui g�re les divers �tats du menu.
 */
include_once "srcPHP/View/Menu/MenuInterface.php";

class AdminMenu implements MenuInterface{
	var $name = "";
	var $id = -1;

	function AdminMenu($id, $name){
		try{
			if(is_numeric($id) && is_string($name)){
				$this->id = $id;
				$this->name = $name;
			}
			else
				throw new Exception("Erreur - Fonction AdminMenu(...) - Verifier les types des parametres");
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}

	function isLogged(){ return true; }

	function disconnect(){
		$_SESSION = array();
		session_destroy();
	}

	function linkCSS(){ echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/menu_admin.css\">"; }

	function linkJS(){ }

	function onLoadJS(){ return ""; }

	function draw(){
		echo "<header>";
		echo "<label id=\"welcome\">Bonjour ".$this->name."</label>";
		echo "<a id=\"deconnexion\" class=\"btn btn-default\" href=\"index.php?disconnect=true\"><span class='glyphicon glyphicon-off'></span> Deconnexion</a>";
		echo "</header>";
		echo "<nav>";
		echo "<a href=\"index.php?form=add_doctor\"><label>Ajouter un Docteur</label></a>";
		echo "</nav>";
	}
}

?>
