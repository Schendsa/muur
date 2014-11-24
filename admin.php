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
		if($admincheck == 1){
			if(isset($_GET['actie'])){
			$actie = $_GET['actie'];
			} else {
				$actie = null;
			}
			switch ($actie) {
				case 'banpost':
					
					break;
				case 'banuser':
					
					break;
				case 'unbanpost':
					
					break;
				case 'unbanuser':
					
					break;
				case 'users':
					
					break;
				case 'adminuser':
					
					break;
				case 'unadminuser':
					
					break;

				default:
					$result = findAllPosts($db);
					foreach ($result as $row) {
						
					}
					break;
			}
		}
	}