<?php 
	require_once("src/connexion.php");
	//detection du form
	if (!empty($_POST["pseudo"]) && !empty($_POST["password"]) && !empty($_POST["email"])) {
		$speudo=htmlspecialchars($_POST["pseudo"]);
		$email=htmlspecialchars($_POST["email"]);
		$password=htmlspecialchars($_POST["password"]);
		$secret=time().rand().rand();
		
	}
	class Inscription{
		//methodes statics 
		public static function chiffer($password){
			return "aq1".sha1($password."123")."125";
		}
		public static function syntaxeEmail($email){
			if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
				return false;
			}
			else{
				return true;
			}
		}
		public static function doublonEmail($email){
			$emailInfo=$bdd->prepare("SELECT COUNT(*) AS emailNumber FROM users WHERE email=:email");
			$emailInfo->execute([
				"email"=>$email
			]);
			while ($userMail=$emailInfo->fetch()) {
				if ($userMail["email"]!=0) {
					return true;
				}
				else{
					return false;
				}
			}
		}
	}
	class User{
		//attributs
		private $_pseudo;
		private $_email;
		private $_password;
		private $_secret;
		//constructeur
		public function __construct($pseudo,$email,$password){
			$this->setPseudo($pseudo);
			$this->setEmail($email);
			$this->setPassword($password);
		}
		//getters
		public function getPseudo(){
			return $this->_pseudo;
		}
		public function getEmail(){
			return $this->_email;
		}
		public function getPassword(){
			return $this->_password;
		}
		public function getSecret(){
			return $this->_secret;
		}
		//setters
		public function setPseudo($newPseudo){
			$this->_pseudo=$newPseudo;
		}
		public function setEmail($newEmail){
			$this->_email=$newEmail;
		}
		public function setPassword($newPassword){
			$this->_password=$newPassword;
		}
		//methodes
		public function enregistrer(){
			
			$request=$bdd->prepare("INSERT INTO users(pseudo,email,password,secret) VALUES(:pseudo,:email,:password,:secret)");
			$request->execute([
				"pseudo"=>$this->getPseudo();
				"email"=>$this->getEmail();
				"pasword"=>$this->getPassword();
				"secret"=>$this->getSecret()
			]);
			while ($userInfo=$request->fetch()) {
				continue;
			}
		}
		public function creerLesSessions(){
			session_start();
			$_SESSION["pseudo"]=$this->getPseudo();
			$_SESSION["email"]=$this->getEmail();
			$_SESSION["password"]=$this->getPassword();
			$_SESSION["connect"]=1;
		}
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