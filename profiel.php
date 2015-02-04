<?php
	session_start();
	if (!isset($_SESSION['user']))
	{	
		header("Location:home.php");
	}
	else
	{
		include("tpl/class.TemplatePower.inc.php");
		include("functions/muursql.php");
		include("functions/config.php");
		$tpl = new TemplatePower( "tpl/profiel.tpl" );
		$tpl->prepare();
		$db = connectToDatabase($host, $database, $user, $pass);
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
		}else{
			$id = $_SESSION['user'];
		}
		if(isset($_GET['actie'])){
		$actie = $_GET['actie'];
		} else {
			$actie = null;
		}
		switch ($actie) {
			case 'sort':
				$tpl->newBlock("Header");
				$tpl->assign("USER", $_SESSION['user']);
				$admincheck = adminCheck($db, $_SESSION['user']);
				foreach ($admincheck as $row) {
					if($row == 1){
						$tpl->newBlock("admin");
					}
				}
				$tpl->newBlock("body");
				$result = findPostsById($db, $id);
				foreach ($result as $row) {
					$tpl->newBlock("sortpost");
					if ($row['post_status'] == 1) {
						$tpl->assign( "CONTENT", $row['content'] );
					}else{
						$tpl->assign( "CONTENT", "Deze post is verwijderd." );
					}
					if ($row['gebruiker_status'] == 1) {
						$tpl->assign( "POSTER", $row['voornaam'] );
						$tpl->assign( "POSTERID", $row['gebruiker_id'] );
					}else{
						$tpl->assign( "POSTER", "Unknown" );
						$tpl->assign( "POSTERID", '0' );
					}
					$tpl->assign( "DATUM",  strftime("%A %d %B %Y", $row['datum']) );
					$tpl->assign( "STATUS", $row['status'] );
					$tpl->assign( "AVATAR", $row['avatar'] );
					if ($row['gebruiker_id'] == $_SESSION['user'] and $row['post_status'] == 1) {
						$tpl->newBlock("delete");
						$tpl->assign( "POSTID", $row['post_id']);
					}
				}
				break;
			case 'newpass':
				if ($_POST['nieuwwachtwoord']==$_POST['nieuwwachtwoord2']) {
					$check = newPassCheck($db, $_SESSION['user'], $_POST['oudwachtwoord']);
					if ($check == TRUE) {
						changePass($db, $_SESSION['user'], $_POST['nieuwwachtwoord']);
						header('Location:profiel.php?id='.$id.'');
					}else{
						header('Location:profiel.php?id='.$id.'');
					}
				}else{
					header('Location:profiel.php?id='.$id.'');
				}
				break;
			case 'passedit':
				$tpl->newBlock("Header");
				$tpl->assign("USER", $_SESSION['user']);
				$tpl->newBlock("body");
				$tpl->newBlock("passedit");
				$tpl->assign("ID", $_SESSION['user']);
				break;
			case 'edit':
				changeUserInfo($db, $_SESSION['user'], $_POST['voornaam'], $_POST['achternaam'], $_POST['email'], $_POST['geslacht'], $_POST['adres'], $_POST['postcode'], $_POST['woonplaats'], $_POST['telefoon'], $_POST['mobiel']);
				header('location:profiel.php?id='.$id.'');
				break;
			default:
				$tpl->newBlock("Header");
				$tpl->assign("USER", $_SESSION['user']);
				$admincheck = adminCheck($db, $_SESSION['user']);
				foreach ($admincheck as $row) {
					if($row == 1){
						$tpl->newBlock("admin");
					}
				}
				$tpl->newBlock("body");
				if ($id == $_SESSION['user']) {
					$tpl->newBlock("bodyedit");
				}else{
					$tpl->newBlock("bodyander");
				}
				$row = findUserInfo($db, $id);
				$tpl->assign("ID",$row['id']);
				$tpl->assign("EMAIL",$row['email']);
				$tpl->assign("VOORNAAM", $row['voornaam']);
				$tpl->assign("ACHTERNAAM", $row['achternaam']);
				$tpl->assign("GESLACHT", $row['geslacht']);
				$tpl->assign("GEBOORTEDATUM", strftime("%d %B %Y", $row['geboortedatum']));
				$tpl->assign("ADRES", $row['adres']);
				$tpl->assign("POSTCODE", $row['postcode']);
				$tpl->assign("WOONPLAATS", $row['woonplaats']);
				$tpl->assign("TELEFOON", $row['telefoon']);
				$tpl->assign("MOBIEL", $row['mobiel']);
				$tpl->assign("AVATAR", $row['avatar']);
				break;
			}
		$tpl->printToScreen();
	}