<?php

	class EditeurTexte {
	
		function __construct($baseDeDonnees) {
      $this->baseDeDonnees = $baseDeDonnees;
		}
		
		
		
		function preTraitement($module, $action) {
			switch($action)
			{
				case 'store':
					if ($_SESSION['connect'])
					{
						if (isset($_POST['elm1']))
						{
              /*
							$texte = htmlentities($_POST['elm1'], ENT_QUOTES);
							$buff = mysqli_query($this->baseDeDonnees->mysqli, "SELECT id FROM tinymce WHERE module='$module'");
							$donnees = mysqli_fetch_array($buff);
							if(empty($donnees))
							{
								mysqli_query($this->baseDeDonnees->mysqli, "INSERT INTO tinymce VALUES('', '$module', '$texte')") OR DIE (mysqli_error());
							}
							else
							{
								$id = $donnees['id'];
								mysqli_query($this->baseDeDonnees->mysqli, "UPDATE tinymce SET texte = '$texte' WHERE id = $id") OR DIE (mysqli_error());
							}
              */
						}
					}
					break;
				
				default:
					break;
			}
		}
		
		
		
		function afficherPage($module) {
			/*
      $buff = mysqli_query($this->baseDeDonnees->mysqli, "SELECT texte FROM tinymce WHERE module='$module'");
			$donnees = mysqli_fetch_array($buff);
      */
      $donnees = ['texte' => ''];
			if ($_SESSION['connect'])
			{

?>
				<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
				<script type="text/javascript">
	tinyMCE.init({
		// General options
		language : "fr", 
		mode : "textareas",
		theme : "advanced",
		skin : "o2k7",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,internalimage",

		// Theme options
		theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,|,sub,sup,|,charmap,emotions,media,advhr,|,print,|,fullscreen,|,internalimage",
		theme_advanced_blockformats : "h1,h2,h3,h4,h5,h6",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		theme_advanced_styles : "Gauche=left;Droite=right",
		
		// Replace values for the template plugin
		template_replace_values : {}
		
	});
				</script>
				<form method="post" action="?module=<?php echo $module; ?>&action=store" enctype="multipart/form-data" id="editeur" >
					<textarea id="elm1" name="elm1"><?php echo $donnees['texte']; ?></textarea>
					<input type="submit" />
					<input type ="reset" />
				</form>
<?php
			}
			else
			{
				echo html_entity_decode($donnees['texte']);
			}
		}
		
	}

?>