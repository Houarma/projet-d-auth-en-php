<?php 
    class User{
		
		//attributs
		private $_pseudo;
		private $_email;
		private $_password;
		private $_secret;
		//constructeur
		public function __construct($pseudo,$email,$password,$secret){
			$this->setPseudo($pseudo);
			$this->setEmail($email);
			$this->setPassword($password);
			$this->setSecret($secret);
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
		public function setSecret($secret){
			$this->_secret=$secret;
		}
		//methodes
		public  function  enregistrer($bdd){

			
			$request=$bdd->prepare("INSERT INTO users(pseudo,email,password,secret) VALUES(:pseudo,:email,:password,:secret)");
			$request->execute([
				"pseudo" 	=> 	$this->getPseudo(),
				"email"		=> 	$this->getEmail(),
				"password"	=>	$this->getPassword(),
				"secret"  	=> 	$this->getSecret()
			]);
			while ($userInfo=$request->fetch()) {
				continue;
			}
		}
		public  function creerLesSessions(){
			
			$_SESSION["pseudo"]=$this->getPseudo();
			$_SESSION["email"]=$this->getEmail();
			$_SESSION["password"]=$this->getPassword();
			$_SESSION["connect"]=1;
		}
	}