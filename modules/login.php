<?php

	class Login extends ModuleAbstrait {
		
		var $erreur;
		var $login;
		var $password;
		var $sault = 'B.R-E.C4ever';
		
		function __construct($baseDeDonnees) {
      $this->baseDeDonnees = $baseDeDonnees;
		}
		
		
		
		function preTraitement($action) {
			switch($action) {
				case 'login':
					if (isset($_POST['login']))
					{
						$login=$_POST['login'];
						$password=md5($this->sault.$_POST['password']);
						$buff = mysqli_query($this->baseDeDonnees->mysqli, 'SELECT id, login, password FROM utilisateurs');
						while($donnees = mysqli_fetch_array($buff))
						{
							if ($login==$donnees['login'] && $password==$donnees['password'])
							{
								$_SESSION['connect']=1;
								$_SESSION['admin']=1;
								header('Location: index.php?module=accueil');
							}
						}
					}
					break;
					
				case 'logout':
					$_SESSION['connect']=0;
					header('Location: admin.php?login=login&action=login');
					break;
					
				case 'media':
					if ($_SESSION['connect'])
					{
						$path="mediatheque";
						$extensions = array('jpg', 'jpeg', 'png', 'gif');
						
						if ( isset($_POST['delete']) )
						{
							$dossier=opendir($path);
							while ($file=readdir($dossier))
							{
								$nomFichier = explode('.', $file);
								if ( isset($_POST[$nomFichier[0]]) && $_POST[$nomFichier[0]]=='on' )
								{
									unlink($path.'/'.$file);
									if (file_exists($path.'/'.$nomFichier[0].'_petit.'.$nomFichier[1]))
									{
										unlink($path.'/'.$nomFichier[0].'_petit.'.$nomFichier[1]);
									}
								}
							}
							closedir($dossier);
						}
						elseif ( isset($_POST['upload']) )
						{
							$this->erreur = '';
							if (isset($_FILES['media']['error']))
							{
								$this->erreur = "Une erreur s'est produite";
								if ($_FILES['media']['error'] > 0)
									$this->erreur = "Erreur lors du tranfsert";
								else
								{
									$nomFichier = explode('.', strtolower($_FILES['media']['name']));
									if ( !empty($_POST['filename']) )
									{
										$nomPropre = $this->cleanName($_POST['filename']);
									}
									else
									{
										$nomPropre = $this->cleanName($nomFichier[0]);
									}
									$direction = $path.'/'.$nomPropre.'.'.$nomFichier[1];
									if ( in_array($nomFichier[1], $extensions) )
									{
										if (move_uploaded_file($_FILES['media']['tmp_name'],$direction))
										{
											$this->redimensionnement($path, $nomPropre, $nomFichier[1]);
											$this->erreur = "Transfert r�ussi";
										}
										else
											$this->erreur = "Erreur lors du tranfsert";
									}
									else
									{
										if (move_uploaded_file($_FILES['media']['tmp_name'],$direction))
										{
											$this->erreur = "Transfert r�ussi";
										}
										else
											$this->erreur = "Erreur lors du tranfsert";
									}
								}
							}
						}
					}
					break;
					
				case 'changeId':
					if ($_SESSION['connect'])
					{
						$buff = mysqli_query($this->baseDeDonnees->mysqli, "SELECT * FROM utilisateurs");
						$donnees = mysqli_fetch_array($buff);
						$id = $donnees['id'];
						if (isset($_POST['nouvelId']) && isset($_POST['nouvelId2']))
						{
							if ($_POST['nouvelId']==$_POST['nouvelId2'] && $_POST['nouvelId']!="")
							{
								$nouvelId=$_POST['nouvelId'];
								mysqli_query($this->baseDeDonnees->mysqli, "UPDATE utilisateurs SET login = '$nouvelId' WHERE id = $id") OR DIE (mysqli_error());
								$this->login="Le changement d'identifiant � bien �t� effectu�";
							}
						}
						if (isset($_POST['nouveauPass']) && isset($_POST['nouveauPass2']))
						{
							if ($_POST['nouveauPass']==$_POST['nouveauPass2'] && $_POST['nouveauPass']!="")
							{
								$nouveauPass=md5($this->sault.$_POST['nouveauPass']);
								mysqli_query($this->baseDeDonnees->mysqli, "UPDATE utilisateurs SET password = '$nouveauPass' WHERE id = $id") OR DIE (mysqli_error());
								$this->password="Le changement de mot de passe � bien �t� effectu�";
							}
						}
					}
					break;
				
				default:
					break;
			}
		}
		
		
		
		function afficherPage($action) {
			$this->navigation();
			echo '<div id="login" >';
			
			switch($action)
			{
				case 'login':
?>
		<form method="post" action="admin.php?module=login&action=login">
			<fieldset class="center" >
				<legend>Administration</legend>
				<p>
					identifiez-vous : 
					<input type="text" name="login" value="identifiant" class="inputText" />
				</p>
				<p>
					mot de passe : 
					<input type="password" name="password" class="inputText" /><br/>
				</p>
				<p>
					<input  type="submit" />
					<input  type="reset" />
				</p>
			</fieldset>
		</form>
<?php
					break;
					
				case 'media':
					if ($_SESSION['connect'])
					{
						echo '<div id="mediatheque">';
						
						$path='mediatheque';
						$extensions = array('jpg', 'jpeg', 'png', 'gif');
						
						$dossier=opendir($path);
						$j=0;
						$media=array();
						while ($file=readdir($dossier))
						{
							if ($file!='.' && $file!='..')
							{
								$nomFichier = explode('.', $file);
								$extensionPetit = substr($nomFichier[0], -6, 6);
								if ( $extensionPetit!='_petit' )
								{
									$media[$j]=$file;
									$j++;
								}
							}
						}
						closedir($dossier);
						
						$detail=0;
						if (isset($_GET['photo']))
						{
							if (is_file($path.'/'.$_GET['photo']))
							{
								$i=0;
								while ($media[$i]!=$_GET['photo'] && $i!=count($media))
								{
									$i++;
								}
								$nomFichier = explode('.', $media[$i]);
								if ($i!=count($media) || $media[$i]==$_GET['photo'] && in_array($nomFichier[1], $extensions))
								{
									echo '<p>';
									if ($i!=0)
										echo '<a href="?module=login&action=media&photo='.$media[$i-1].'" class="left" >image pr�c�dante </a>';
									if ($i!=(count($media)-1))
										echo '<a href="?module=login&action=media&photo='.$media[$i+1].'" class="right" > image suivante</a>';
									echo '</p>';
									
									$taille=getimagesize($path.'/'.$media[$i]);
									echo '<p class="center" >';
									if ($taille[0]<750)
										echo '<img src="'.$path.'/'.$media[$i].'" />';
									else
										echo '<img src="'.$path.'/'.$media[$i].'" width="750" />';
									echo '</p>';
									echo '<p>';
									if ($i!=0)
										echo '<a href="?module=login&action=media&photo='.$media[$i-1].'" class="left" >image pr�c�dante </a>';
									if ($i!=(count($media)-1))
										echo '<a href="?module=login&action=media&photo='.$media[$i+1].'" class="right" > image suivante</a>';
									echo '</p>';
								}
								$detail=1;
							}
							else
							{
								$detail=0;
							}
						}
						
						if ($detail==0)
						{
							echo '<form action="?module=login&action=media&action=media" method="post" enctype="multipart/form-data" >';
							echo '<fieldset><legend>Ajouter un fichier</legend>';
							echo '<input type="file" name="media" /><br/>';
							echo '<label for="filename" >Nom du fichier : </label><input type="text" name="filename" /><br/>';
							echo '<input type="submit" name="upload" /></fieldset>';
							
							/********affichage du choix des pages********/
							$imageParPage=8; //multiple de 4
							if (!isset($_GET['page']))
							{
								$image=0;
								$pageActuelle=1;
							}
							else
							{
								$image=$imageParPage*($_GET['page']-1);
								$pageActuelle=$_GET['page'];
							}
							if (count($media) > $imageParPage)
							{
								$pagesTotales=ceil(count($media)/$imageParPage);
								$pages=$pagesTotales;
								echo '<p class="pages" >';
								if ($pageActuelle!=1)
								{
									$pagePrec=$pageActuelle-1;
									echo "\n\t".'<a href="?module=login&action=media&page='.$pagePrec.'" title="page pr�c�dante"><</a>&nbsp&nbsp;';
								}
								echo "\n\t".'<a href="?module=login&action=media&page=1" title="premi�re page">1..</a>&nbsp&nbsp;';
								$i=2;
								if ($pageActuelle<=5)
								{
									$i=2;
									if ($pages>9)
										$pages=9;
								}
								elseif ($pageActuelle>=($pagesTotales-4) and $pageActuelle>5)
								{
									if ($pagesTotales>=6)
										$i=$pagesTotales-7;
								}
								else
								{
									$i=$pageActuelle-3;
									$pages=$pageActuelle+3;
								}
								for ($i;$i<$pages;$i++)
								{
									echo "\n\t".'<a href="?module=login&action=media&page='.$i.'">'.$i.'</a>&nbsp&nbsp;';
								}
								if ($pagesTotales!=1)
									echo "\n\t".'<a href="?module=login&action=media&page='.$pagesTotales.'" title="derni�re page">..'.$pagesTotales.'</a>&nbsp&nbsp;';
								if ($pageActuelle!=$pagesTotales)
								{
									$pageSuiv=$pageActuelle+1;
									echo "\n\t".'<a href="?module=login&action=media&page='.$pageSuiv.'" title="page suivante">></a>';
									}
								echo "\n".'</p>';
							}
							
							/********affichage des images********/
							if (!empty($media))
							{
								echo '<table>';
								$j=0;
								$k=0;
								for ($i=$image; $i<($image+$imageParPage); $i++)
								{
									if ($j==0 || $j==4 || $j==8 || $j==12)
									echo '<tr>';
									if (isset($media[$i]))
									{
										$nomFichier = explode('.', $media[$i]);
										echo '<td>'.$media[$i].'<br/>';
										if ( in_array($nomFichier[1], $extensions) )
											echo '<a href="?module=login&action=media&photo='.$media[$i].'"><img src="'.$path.'/'.$nomFichier[0].'_petit.'.$nomFichier[1].'" /></a>';
										else
											echo '<img src="logo/file.png" />';
										echo '<br/><input type="checkbox" name="'.$nomFichier[0].'"/> supprimer';
										echo '</td>';
									}
									if ($j==3 || $j==7 || $j==11 || $j==15)
										echo '</tr>';
									$j++;
								}
								echo '</table>';
							}
							
							/********r�-affichage du choix des pages********/
							if (count($media) > $imageParPage)
							{
								$pagesTotales=ceil(count($media)/$imageParPage);
								$pages=$pagesTotales;
								echo '<p class="pages" >';
								if ($pageActuelle!=1)
								{
									$pagePrec=$pageActuelle-1;
									echo "\n\t".'<a href="?module=login&action=media&page='.$pagePrec.'" title="page pr�c�dante"><</a>&nbsp&nbsp;';
								}
								echo "\n\t".'<a href="?module=login&action=media&page=1" title="premi�re page">1..</a>&nbsp&nbsp;';
								$i=2;
								if ($pageActuelle<=5)
								{
									$i=2;
									if ($pages>9)
										$pages=9;
								}
								elseif ($pageActuelle>=($pagesTotales-4) and $pageActuelle>5)
								{
									if ($pagesTotales>=6)
										$i=$pagesTotales-7;
								}
								else
								{
									$i=$pageActuelle-3;
									$pages=$pageActuelle+3;
								}
								for ($i;$i<$pages;$i++)
								{
									echo "\n\t".'<a href="?module=login&action=media&page='.$i.'">'.$i.'</a>&nbsp&nbsp;';
								}
								if ($pagesTotales!=1)
									echo "\n\t".'<a href="?module=login&action=media&page='.$pagesTotales.'" title="derni�re page">..'.$pagesTotales.'</a>&nbsp&nbsp;';
								if ($pageActuelle!=$pagesTotales)
								{
									$pageSuiv=$pageActuelle+1;
									echo "\n\t".'<a href="?module=login&action=media&page='.$pageSuiv.'" title="page suivante">></a>';
									}
								echo "\n".'</p>';
							}
							
							/********affichage bas du corps********/
							if (!empty($media))
								echo '<p class="submit" ><input type ="submit" value="supprimer les photos coch�es" name="delete" /></p>';
							echo '</form>';
							echo "\n".'<p>page '.$pageActuelle.'</p>'."\n";
						}
						
						echo '</div>';
					}
					break;
				
				default:
					break;
				
				case 'changeId':
					if ($_SESSION['connect'])
					{
?>
				<form method="post" action="?module=login&action=changeId">
					<fieldset class="center" >
						<legend>Changer l'identifiant</legend>
						<p>
							<label for="nouvelId"><strong>Nouvel identifiant de connexion (*2) :</strong></label><br/>
							<input type="text" name="nouvelId" class="inputText" /><br/>
							<input type="text" name="nouvelId2" class="inputText" /><br/>
							<span class="error"><?php echo $this->login; ?></span>
						</p>
					</fieldset>
					<fieldset class="center" >
						<legend>Changer le mot de passe</legend>
						<p>
							<label for="nouveauPass"><strong>Nouveau mot de passe (*2) :</strong></label><br/>
							<input type="password" name="nouveauPass" class="inputText" /><br/>
							<input type="password" name="nouveauPass2" class="inputText" /><br/>
							<span class="error"><?php echo $this->password; ?></span>
						</p>
					</fieldset>
						<p class="center" >
							<input type="submit" />
							<input type="reset" />
						</p>
				</form>
<?php
					}
					break;
			}
			echo '</div>';
		}
		
		
		
		function afficherMenuDroite() {
			if ($_SESSION['connect'])
			{

?>
				<a href="admin.php?module=login&action=media">m�diath�que</a><br/>
				<a href="admin.php?module=login&action=changeId">profil</a><br/>
				<a href="admin.php?module=login&action=logout">d�connexion</a>
<?php

			}
			else
			{

?>
				<a href="admin.php?module=login&action=login">connexion</a>
<?php

			}
		}
		
		
		
		function navigation() {
		}
		
		
		
		function redimensionnement($path, $filename, $extension) {
			$fond = imagecreatetruecolor(150, 150);
			$background = imagecolorallocate($fond, 76, 100, 40);
			imagefill($fond, 0, 0, $background);
			if ( $extension == 'jpg' )
				$endFunction = 'jpeg';
			else
				$endFunction = $extension;
			$functionName = 'imagecreatefrom'.$endFunction;
			$source = $functionName($path.'/'.$filename.'.'.$extension);
			$largeur_source = imagesx($source);
			$hauteur_source = imagesy($source);
			
			if($largeur_source>$hauteur_source)
			{
				$largeur_destination = 150;
				$hauteur_destination = ceil($largeur_destination*$hauteur_source/$largeur_source);
				$position_X=0;
				$position_Y=(150-$hauteur_destination)/2;
			}
			else
			{
				$hauteur_destination = 150;
				$largeur_destination = ceil($hauteur_destination*$largeur_source/$hauteur_source);
				$position_Y=0;
				$position_X=(150-$largeur_destination)/2;
			}
			$destination = imagecreatetruecolor($largeur_destination, $hauteur_destination);

			imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
			imagecopy($fond, $destination, $position_X, $position_Y, 0, 0, $largeur_destination, $hauteur_destination);
			$nom= $path.'/'.$filename.'_petit.'.$extension;
			$functionName = 'image'.$endFunction;
			$functionName($fond, $nom);
		}
		
		
		
		function cleanName($name) {
			$replacement = array(
			    'A' => '/&Agrave;|&Aacute;|&Acirc;|&Atilde;|&Auml;|&Aring;/',
			    'a' => '/&agrave;|&aacute;|&acirc;|&atilde;|&auml;|&aring;/',
			    'C' => '/&Ccedil;/',
			    'c' => '/&ccedil;/',
			    'E' => '/&Egrave;|&Eacute;|&Ecirc;|&Euml;/',
			    'e' => '/&egrave;|&eacute;|&ecirc;|&euml;/',
			    'I' => '/&Igrave;|&Iacute;|&Icirc;|&Iuml;/',
			    'i' => '/&igrave;|&iacute;|&icirc;|&iuml;/',
			    'N' => '/&Ntilde;/',
			    'n' => '/&ntilde;/',
			    'O' => '/&Ograve;|&Oacute;|&Ocirc;|&Otilde;|&Ouml;/',
			    'o' => '/&ograve;|&oacute;|&ocirc;|&otilde;|&ouml;/',
			    'U' => '/&Ugrave;|&Uacute;|&Ucirc;|&Uuml;/',
			    'u' => '/&ugrave;|&uacute;|&ucirc;|&uuml;/',
			    'Y' => '/&Yacute;/',
			    'y' => '/&yacute;|&yuml;/',
				'_' => '/\s/'
			);
			
			return preg_replace($replacement, array_keys($replacement), htmlentities($name, ENT_NOQUOTES));
		}
	}

?>