<?php

	class EnteteHTML {
		var $titre = "Benoît RENOU - Educateur canin";
		var $charset = "charset=iso-8859-1";
		var $auteur = "Tony CABAYE";
		var $description = "Benoît Renou, Educateur canin dans le Nord (59)";
		var $keywords = "Benoît Renou, éducateur, canin, chien, élever, éduquer, wooden park, nord, lille, pistage, agility, sport canin, 59, dresser";
		var $path = "style/";
		var $css = "style.css";
	
		function EnteteHTML() {
		}
		
		
		
		function afficher($modules) {

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
	<head>
		<title><?php echo $this->titre; ?></title>
		<meta http-equiv="Content-Type" content="text/html; <?php echo $this->charset; ?>" />
		<meta name="author" content="<?php echo $this->auteur; ?>" />
		<meta name="description" content="<?php echo $this->description; ?>" />
		<meta name="keywords" content="<?php echo $this->keywords; ?>" />
		<link rel="stylesheet" media="screen" type="text/css" title="Style" href="<?php echo $this->path.$this->css; ?>" />
		<!--[if lte IE 7]>
			<style type="text/css">
				#header div > ul {
					margin-top: 27px;
				}
			</style>
		<![endif]-->
		<script type="text/javascript" src="script/ajax.js"></script>
	</head>
<?php
		}
	}

?>