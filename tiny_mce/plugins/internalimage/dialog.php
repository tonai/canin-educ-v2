<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Image interne</title>
	<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
	<script type="text/javascript" src="js/dialog.js"></script>
	<link rel="stylesheet" media="screen" type="text/css" title="Style" href="css/embed.css" />
</head>
	<body>
		<div id="internalImageList">
			<?php
			$path = '../../../mediatheque';
			$extensions = array('jpg', 'jpeg', 'png', 'gif');
			$media = array();
			$i = 0;
			
			$dossier=opendir($path);
			while ($file=readdir($dossier))
			{
				if ($file!='.' && $file!='..')
				{
					$nomFichier = explode('.', $file);
					$extensionPetit = substr($nomFichier[0], -6, 6);
					if ( $extensionPetit!='_petit' )
					{
						$media[$i]=$file;
						$i++;
					}
				}
			}
			closedir($dossier);
			
			/********affichage des images********/
			if (!empty($media))
			{
				echo '<ul>';
				for ($i=0; $i<count($media); $i++)
				{
					if (isset($media[$i]))
					{
						$nomFichier = explode('.', $media[$i]);
						echo '<li><a href="#" onclick="InternalImageDialog.insert(\''.$media[$i].'\');return false;" onmouseover="InternalImageDialog.preview(\''.$media[$i].'\');" >'.$media[$i].'</a></li>';
					}
				}
				echo '</ul>';
			}
			
			$i=0;
			$nomFichier = explode('.', $media[$i]);
			while ( !in_array($nomFichier[1], $extensions) )
			{
				$i++;
				$nomFichier = explode('.', $media[$i]);
			}
			?>
		</div>
		<div id="InternalImagePreview" >
			<img src="<?php echo $path.'/'.$nomFichier[0].'_petit.'.$nomFichier[1]; ?>" name="preview" />
		</div>
		<div class="clearer"></div>
	</body>
</html>
