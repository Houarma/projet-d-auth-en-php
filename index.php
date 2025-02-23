<?php 
	//debut de la session
	session_start();

	//connexion a la bdd
	require_once("src/connexion.php");
	
	//introduction des classe correspondantes
	spl_autoload_register(function ($classe)  {
		require_once('classes/'.$classe.'.php');
	});
	
	//detection du form
	if (!empty($_POST["pseudo"]) && !empty($_POST["password"]) && !empty($_POST["email"])) {
		$pseudo=htmlspecialchars($_POST["pseudo"]);
		$email=htmlspecialchars($_POST["email"]);
		$password=htmlspecialchars($_POST["password"]);
		$secret=time().rand().rand();

		//verification de l email
		if (!Inscription::syntaxeEmail($email)) {
			header("location:index.php?error=true&message=votre email n est pas valide");
			exit();
		}

		//verification des doublons
		if (Inscription::doublonEmail($email,$bdd)) {
			header("location:index.php?error=true&message=cette adresse mail existe deja ");
			exit();
		}

		//chiffrement du mot de passe
		$password=Inscription::chiffer($password);
		
		//add users
		$user= new User($pseudo,$email,$password,$secret);
		$user->enregistrer($bdd);
		$user->creerLesSessions();
		// redirection 
		header("location:index.php?success=true");
		exit();
		
	}


?> 






<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/default.css">
	<title>Mon Site PHP</title>
</head>
<body>

	<section class="container">
		
		<form method="post" action="index.php">

			<p>Incription</p>

			<?php if(isset($_GET['success'])) {
				echo '<p class="alert success">Inscription réalisée avec succès.</p>';
			}
			else if(isset($_GET['error']) && !empty($_GET['message'])) {
				echo '<p class="alert error">'.htmlspecialchars($_GET['message']).'</p>';
			} ?>

			<input type="text" name="pseudo" id="pseudo" placeholder="Pseudo"><br>
			<input type="email" name="email" id="email" placeholder="Email"><br>
			<input type="password" name="password" id="password" placeholder="Mot de passe"><br>
			<input type="submit" value="Inscription">
		
		</form>

		<div class="drop drop-1"></div>
		<div class="drop drop-2"></div>
		<div class="drop drop-3"></div>
		<div class="drop drop-4"></div>
		<div class="drop drop-5"></div>
	</section>

</body>
</html>