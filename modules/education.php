<?php

	class Education extends ModuleAbstrait {
		
		var $erreur = "";	
		var $editeurTexte;
		
		function __construct($baseDeDonnees) {
			include_once("lib/EditeurTexte.php");
			$this->editeurTexte = new EditeurTexte($baseDeDonnees);
		}
		
		
		
		function preTraitement($action) {
			$this->erreur = $this->editeurTexte->preTraitement($this->getName(), $action);
		}
		
		
		
		function afficherPage($action) {
			$this->navigation();
			echo '<div id="accueil" >';
			echo '<h1>L\'�ducation canine</h1>';
			$this->editeurTexte->afficherPage($this->getName());
			echo '</div>';
		}
		
		
		
		function afficherMenuDroite() {
		}
		
		
		
		function navigation() {
		}
		
		
	}

?>