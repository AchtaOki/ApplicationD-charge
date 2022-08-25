<?php
	session_start();
	@$login=$_POST["login"];
	@$pass=$_POST["pass"];
	@$valider=$_POST["valider"];
	$message="";
	if(isset($valider)){
		include("connexion.php");
		$res=$pdo->prepare("select * from users where login=? and pass=? limit 1");
		$res->setFetchMode(PDO::FETCH_ASSOC);
		$res->execute(array($login,md5($pass)));
		$tab=$res->fetchAll();
		if(count($tab)==0)
			$message="<li>Mauvais login ou mot de passe!</li>";
		else{
			$_SESSION["autoriser"]="oui";
			$_SESSION["nomPrenom"]=strtoupper($tab[0]["nom"]." ".$tab[0]["prenom"]);
			header("location:Accueil.php");
		}
	}
?>
<!DOCYTPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body onLoad="document.fo.login.focus()" style="background-color:#FFFFF0;">
		<header style="background-color:cyan;">
			Authentification
			<a href="inscription.php">Ajouter un utilisateur</a>
		</header>
		<form name="fo" method="post" action="">
			<div class="label">Login</div>
			<input type="text" name="login" value="<?php echo $login?>" />
			<div class="label">Mot de passe</div>
			<input type="password" name="pass" />
			<input type="submit" name="valider" value="S'authentifier" />
		</form>
		<?php if(!empty($message)){ ?>
		<div id="message"><?php echo $message ?></div>
		<?php } ?>
	</body>
</html>