<?php
	session_start();
	if (isset($_SESSION['user']))
	{	
		header("Location:muur.php");
	}
	else
	{
		include("tpl/class.TemplatePower.inc.php");
		include("functions/muursql.php");
		include("functions/config.php");
		$tpl = new TemplatePower( "tpl/home.tpl" );
		$tpl->prepare();
		$db = connectToDatabase($host, $database, $user, $pass);
		
		if(isset($_GET['actie'])){
			$actie = $_GET['actie'];
		} else {
			$actie = null;
		}
		switch ($actie) {

			case 'inloggen':
				$email = $_POST['E-mail'];
				$password = $_POST['Password'];
				$result = getLoggedInUserId($db, $email, $password);
				if ($result == -1) {
					$warning = "Warning: E-mail of Wachtwoord niet goed.";
					$tpl->newBlock("Header");
					$tpl->assign("EMAIL", $email);
					$tpl->assign("PASSWORD", $password);
					$tpl->assign("LOGINWARNING", $warning);
					$tpl->newBlock("body");
				}else{
					$_SESSION['user'] = $result;
					header('location:muur.php');
				}
				break;

			case 'registreren':
			if($_POST['Password'] == $_POST['Password2']){
				$email = $_POST['E-mail'];
				$result = getEmailId($db, $email);
				if ($result == -1) {
					$voornaam = $_POST['Voornaam'];
					$achternaam = $_POST['Achternaam'];
					$password = $_POST['Password'];
					$password2 = $_POST['Password2'];
					$geslacht = $_POST['Geslacht'];
					$date = $_POST['Date'];
					$timestamp = strtotime($date);
					$personid = registerPerson($db, $voornaam, $achternaam, $geslacht, $timestamp);
					registerUser($db, $email, $password, $personid);
					header('location:home.php');
				}else{
					$tpl->newBlock("Header");
					$tpl->newBlock("body");
					$warning = "E-mail is al in gebruik.<br>";
					$tpl->assign("REGISTREERWARNING", $warning);
				}	
			}else{
				$tpl->newBlock("Header");
				$tpl->newBlock("body");
				$warning = "Wachtwoord is niet correct.<br>";
				$tpl->assign("REGISTREERWARNING", $warning);
			}
				break;

			default:
				$email = "";
				$password = "";
				$tpl->assign("EMAIL", $email);
				$tpl->assign("PASSWORD", $password);
				$tpl->newBlock("Header");
				$tpl->newBlock("body");
				break;
		}
		$tpl->printToScreen();
}