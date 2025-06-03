<?php
	try{
		$user = "webuser";
		$pass = "motdepassefort";
        $nomBdd = "escapegame";
		$bdd = new PDO('mysql:host=localhost;dbname='.$nomBdd, $user, $pass);
		
	}catch(PDOException $e){
		print "Erreur! :" . $e->getMessage() .
		"<br/>";
		die();
	}

?>
