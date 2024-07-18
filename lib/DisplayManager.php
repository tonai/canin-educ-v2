<?php

	class DisplayManager {
	
		var $enteteHTML;
		var $header;
		var $menu;
		var $footer;
		var $moduleManager;
		
		var $mode;
		var $module;
		var $action;
		
		function __construct($baseDeDonnees, $mode = false ) {
      $this->baseDeDonnees = $baseDeDonnees;

			require_once("EnteteHTML.php");
			require_once("Header.php");
			require_once("Menu.php");
			require_once("Footer.php");
			require_once("lib/ModuleManager.php");
			
			$this->enteteHTML = new EnteteHTML();
			$this->header = new Header();
			$this->menu = new Menu();
			$this->footer = new Footer();
			$this->moduleManager = new ModuleManager($baseDeDonnees);
			
			$this->mode = $mode;
			$this->module = ((isset($_POST['module']))? $_POST['module']: ((isset($_GET['module']))? $_GET['module']: false)); 
			$this->action = ((isset($_GET['action']))? $_GET['action']: false);
			
			if ( $this->mode=='admin' && empty($this->module) )
			{
				$this->module = 'login';
				if ($_SESSION['connect'])
					$this->action = 'logout';
				else
					$this->action = 'login';
			}
			
			if( !empty($this->module) ) {
				$this->moduleManager->loadModulesFromDb($this->module);
			}
			else {
				$this->moduleManager->loadModulesFromDb("accueil");
			}
			
			if( !empty($this->module) && !empty($this->action) )
			{
				$this->moduleManager->preTraitement($this->module, $this->action);
			}
		}
	
		function display() {
			if ( $this->mode == 'ajax' )
			{
				header('Content-Type: text/html; charset=ISO-8859-1');
				if ( !empty($this->module) )
					$this->moduleManager->modules[$this->module]->afficherPage($this->action);
				else
			        $this->moduleManager->modules['accueil']->afficherPage($this->action);
			}
			else
			{
				$this->enteteHTML->afficher($this->moduleManager->modules);
	
?>
	<body>
		<div id="page">
<?php

			$this->header->afficher();

?>
			<div id="colonne_droite">
<?php

			$this->menu->afficher();
			if ( $_SESSION['admin'] )
			{
				$this->moduleManager->modules['login']->afficherMenuDroite();
			}

?>
			</div>
			<div id="corps">
<?php

			if ( !empty($this->module) )
				$this->moduleManager->modules[$this->module]->afficherPage($this->action);
			else
		        $this->moduleManager->modules['accueil']->afficherPage($this->action);

?>
			</div>
<?php

			$this->footer->afficher();

?>
		</div>
	</body>
</html>
<?php

			}
		}
		
	}