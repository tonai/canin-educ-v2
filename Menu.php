<?php

	class Menu {
	
		function __construct() {
		}
		
		
		
		function afficher() {
			if ($_SESSION['connect'])
				$autostart=0;
			else
				$autostart=1;

?>
			<object type="application/x-shockwave-flash" data="dewplayer-mini.swf?mp3=son/fond_musique_site.mp3&amp;autostart=<?php echo $autostart; ?>&amp;autoreplay=1&amp;showtime=1" width="150" height="20"><param name="wmode" value="transparent"><param name="movie" value="dewplayer-mini.swf?mp3=son/fond_musique_site.mp3&amp;autostart=<?php echo $autostart; ?>&amp;autoreplay=1&amp;showtime=1" /></object>
			<div id="menu">
<?php

			if ( $_SESSION['connect'] )
			{

?>
				<a href="index.php?module=accueil"><b>Accueil</b></a>
				<a href="index.php?module=education"><b>L'Education</b></a>
				<a href="index.php?module=sportcanin"><b>Sport canin</b></a>
				<a href="index.php?module=pistage"><b>Le pistage</b></a>
				<a href="index.php?module=boutique"><b>La boutique</b></a>
				<a href="index.php?module=qui_suis_je"><b>Qui suis-je ?</b></a>
				<a href="index.php?module=woodenpark"><b>Woodenpark</b></a>
				<a href="index.php?module=contact"><b>Contacts</b></a>
			</div>
<?php

			}
			else
			{

?>
				<script language="javascript">
					var menu='';
					menu+='<a href="javascript:ajax(\'accueil\')"><b>Accueil</b></a>';
					menu+='<a href="javascript:ajax(\'education\')"><b>L��ducation</b></a>';
					menu+='<a href="javascript:ajax(\'sportcanin\')"><b>Sport canin</b></a>';
					menu+='<a href="javascript:ajax(\'pistage\')"><b>Le pistage</b></a>';
					menu+='<a href="javascript:ajax(\'boutique\')"><b>La boutique</b></a>';
					menu+='<a href="javascript:ajax(\'qui_suis_je\')"><b>Qui suis-je ?</b></a>';
					menu+='<a href="javascript:ajax(\'woodenpark\')"><b>Woodenpark</b></a>';
					menu+='<a href="javascript:ajax(\'contact\')"><b>Contacts</b></a>';
					document.write(menu);
				</script>
				<noscript>
					<a href="index.php?module=accueil"><b>Accueil</b></a>
					<a href="index.php?module=education"><b>L'Education</b></a>
					<a href="index.php?module=sportcanin"><b>Sport canin</b></a>
					<a href="index.php?module=pistage"><b>Le pistage</b></a>
					<a href="index.php?module=boutique"><b>La boutique</b></a>
					<a href="index.php?module=qui_suis_je"><b>Qui suis-je ?</b></a>
					<a href="index.php?module=woodenpark"><b>Woodenpark</b></a>
					<a href="index.php?module=contact"><b>Contacts</b></a>
				</noscript>
			</div>
<?php

			}
			$adresse_ip=$_SERVER['REMOTE_ADDR'];
			$timestamp=time();
      /*
			$reponse=mysqli_query("SELECT COUNT(*) AS existe FROM visiteur WHERE ip='$adresse_ip'");
			//$reponse=mysqli_query('SELECT COUNT  AS existe FROM visiteur WHERE ip='.$adresse_ip);
			$nombre=mysqli_fetch_array($reponse);
			$reponse=mysqli_query("SELECT * FROM visiteur WHERE ip='$adresse_ip'");
			$donnees=mysqli_fetch_array($reponse);
			$ancien_temp=$donnees['timestamp'];
			if ($nombre['existe']==0)
			{
				mysqli_query("INSERT INTO visiteur VALUES('','$adresse_ip', '$timestamp')");
			}
			else
			{
				while ($donnees=mysqli_fetch_array($reponse))
				{
					$ancien_temp=$donnees['timestamp'];
				}
				if ($ancien_temp<$timestamp-10*60)
				{
					mysqli_query("INSERT INTO visiteur VALUES('','$adresse_ip','$timestamp')");
				}
				else
				{
					mysqli_query("UPDATE visiteur SET timestamp='$timestamp' WHERE (ip='$adresse_ip') AND (timestamp='$ancien_temp')");
				}
			}
			$reponse=mysqli_query('SELECT COUNT(*) AS visites FROM visiteur');
			$donnees=mysqli_fetch_array($reponse);
			echo '<p>Nombre de visiteurs : <br/>'.$donnees['visites'].'</p>';
      */
			echo '<p>Nombre de visiteurs : <br/>0</p>';
		}
	}

?>