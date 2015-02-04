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
		$tpl = new TemplatePower( "tpl/admin.tpl" );
		$tpl->prepare();
		$db = connectToDatabase($host, $database, $user, $pass);
		setlocale(LC_ALL, "nld_nld");
		$admincheck = adminCheck($db, $_SESSION['user']);
		foreach ($admincheck as $row) {
			if($row != 1){
				header("Location:muur.php");
			}else{
			if(isset($_GET['actie'])){
			$actie = $_GET['actie'];
			} else {
				$actie = null;
			}
			switch ($actie) {
				case 'banpost':
					deletePost($db, $_GET['id']);
					header("Location:admin.php");
					break;
				case 'bancomment':
					deleteComment($db, $_GET['id']);
					header("Location:admin.php?actie=comments");
					break;
				case 'banuser':
					deleteUser($db, $_GET['id']);
					header("Location:admin.php?actie=users");
					break;
				case 'unbanpost':
					unDeletePost($db, $_GET['id']);
					header("Location:admin.php");
					break;
				case 'unbancomment':
					unDeleteComment($db, $_GET['id']);
					header("Location:admin.php?actie=comments");
					break;
				case 'unbanuser':
					unDeleteUser($db, $_GET['id']);
					header("Location:admin.php?actie=users");
					break;
				case 'users':
				$tpl->newBlock("Header");
				$tpl->assign("USER",$_SESSION['user']);
				$tpl->newBlock("usertable");
					$result = findAllUserInfo($db);
					foreach ($result as $row) {
						$tpl->newBlock("userrow");
						$tpl->assign("ID", $row['gebruiker_id']);
						$tpl->assign("VOORNAAM", $row['voornaam']);
						$tpl->assign("ACHTERNAAM", $row['achternaam']);
						$tpl->assign("EMAIL", $row['email']);
						$tpl->assign("GESLACHT", $row['geslacht']);
						$tpl->assign("ADRES", $row['adres']);
						$tpl->assign("POSTCODE", $row['postcode']);
						$tpl->assign("WOONPLAATS", $row['woonplaats']);
						$tpl->assign("TELEFOON", $row['telefoon']);
						$tpl->assign("MOBIEL", $row['mobiel']);
						if ($row['gebruiker_status'] == 1) {
							$tpl->assign("BAN", "Niet gebanned");
							$tpl->assign("ACTIE", "banuser");
						}else{
							$tpl->assign("BAN", "Gebanned");
							$tpl->assign("ACTIE", "unbanuser");
						}
						if ($row['groep_id'] == 1) {
							$tpl->assign("ADMIN", "Geen admin");
							$tpl->assign("ADMINACTIE", "adminuser");
						}else{
							$tpl->assign("ADMIN", "Admin");
							$tpl->assign("ADMINACTIE", "unadminuser");
						}
					}
					break;
				case 'comments':
				$tpl->newBlock("Header");
				$tpl->assign("USER",$_SESSION['user']);
				$tpl->newBlock("table");
					$result = findAllComments($db);
					foreach ($result as $row) {
						$tpl->newBlock("row");
						$tpl->assign("ID", $row['comment_id']);
						$tpl->assign("VOORNAAM", $row['voornaam']);
						$tpl->assign("ACHTERNAAM", $row['achternaam']);
						$tpl->assign("CONTENT", $row['content']);
						$tpl->assign("DATUM", strftime("%A %d %B %Y", $row['datum']) );
						if ($row['comment_status'] == 1) {
							$tpl->assign("BAN", "Niet gebanned");
							$tpl->assign("ACTIE", "bancomment");
						}else{
							$tpl->assign("BAN", "Banned");
							$tpl->assign("ACTIE", "unbancomment");
						}
					}
					break;
				case 'adminuser':
					adminUser($db,$_GET['id']);
					header("Location:admin.php?actie=users");
					break;
				case 'unadminuser':
					unAdminUser($db,$_GET['id']);
					header("Location:admin.php?actie=users");
					break;

				default:
				$tpl->newBlock("Header");
				$tpl->assign("USER",$_SESSION['user']);
				$tpl->newBlock("table");
					$result = findAllPosts($db);
					foreach ($result as $row) {
						$tpl->newBlock("row");
						$tpl->assign("ID", $row['post_id']);
						$tpl->assign("VOORNAAM", $row['voornaam']);
						$tpl->assign("ACHTERNAAM", $row['achternaam']);
						$tpl->assign("CONTENT", $row['content']);
						$tpl->assign("DATUM", strftime("%A %d %B %Y", $row['datum']) );
						if ($row['post_status'] == 1) {
							$tpl->assign("BAN", "Niet gebanned");
							$tpl->assign("ACTIE", "banpost");
						}else{
							$tpl->assign("BAN", "Banned");
							$tpl->assign("ACTIE", "unbanpost");
						}
					}
					break;
				}
			}
			$tpl->printToScreen();
		}
	}