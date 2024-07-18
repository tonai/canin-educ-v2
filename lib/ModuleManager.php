<?php

	class ModuleManager {
	
		var $modules;
		
		function __construct($baseDeDonnees) {
      $this->baseDeDonnees = $baseDeDonnees;

			require_once("lib/ModuleAbstrait.php");
		}
	
		function loadModule ($name) {
	        include_once('modules/'.$name.'.php');
	        $this->modules[$name]=new $name($this->baseDeDonnees);
	    }
	    
	    function loadModulesFromDb ($module) {
	        // TODO : G�rer les d�pendances des modules si besoin
          /*
			    $buff = mysqli_query($this->baseDeDonnees->mysqli, "SELECT * FROM modules WHERE (type='load' OR module='".$module."') ORDER BY id");
			    while($donnees = mysqli_fetch_array($buff)) {
	            $this->loadModule($donnees['module']);
	        }
	        */
					$buff = array('accueil', 'boutique', 'contact', 'education', 'login', 'pistage', 'qui_suis_je', 'sportcanin', 'woodenpark');
          foreach ($buff as &$value) {
            $this->loadModule($value);
          }
	    }    
	    
	    function preTraitement ($module, $action) {
			if(is_object($this->modules[$module])) {
	                $this->modules[$module]->preTraitement($action);
	        }
	    }
		
	}

?>