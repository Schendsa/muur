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
		$tpl = new TemplatePower( "tpl/muur.tpl" );
		$tpl->prepare();
		$db = connectToDatabase($host, $database, $user, $pass);
		setlocale(LC_ALL, "nld_nld");
		if(isset($_GET['actie'])){
		$actie = $_GET['actie'];
		} else {
			$actie = null;
		}
		switch ($actie) {
			case 'editsave':
				$id = $_POST['id'];
				$content = $_POST['content'];
				editPost($db, $id, $content);
				header("Location:muur.php");
				break;

			case 'editcomment':
				$id = $_POST['id'];
				$content = $_POST['content'];
				if (isset($_POST['postid'])) {
					$postid = $_POST['postid'];	
				}
				editComment($db, $id, $content);
				header("Location:muur.php?actie=comments&id=".$postid."");
				break;

			case 'uitloggen':
				unset($_SESSION['user']);
				header("Location:home.php");
				break;

			case 'edit':
				$tpl->newBlock("Header");
				$tpl->assign("USER", $_SESSION['user']);
				$tpl->newBlock("body");
				$tpl->newBlock("edit");
				$tpl->assign("EDITTYPE", "editsave");
				$id = $_POST['postid'];
				$tpl->assign("POSTID", $id);
				$result = findPostById($db, $id);
				$tpl->assign("POSTCONTENT", $_POST['content']);
				break;

			case 'delete':
				$id = $_POST['postid'];
				$sql = deletePost($db, $id);
				header("Location:muur.php");
				break;

			case 'commentedit':
				$tpl->newBlock("Header");
				$tpl->assign("USER", $_SESSION['user']);
				$tpl->newBlock("body");
				$tpl->newBlock("edit");
				$tpl->assign("EDITTYPE", "editcomment");
				$id = $_POST['postid'];
				$tpl->assign("POSTID", $id);
				$result = findPostById($db, $id);
				foreach ($result as $row) {
				$tpl->assign("COMMENTID", $row['']);
				$tpl->assign("POSTCONTENT", $row['content']);
				}
				break;

			case 'commentdelete':
				$id = $_POST['postid'];
				$sql = deleteComment($db, $id);
				header("Location:muur.php");
				break;

			case 'createpost':
				$id = $_POST['id'];
				$content = $_POST['newpost'];
				$date = time();
				createPost($db, $id, $content, $date);
				header("Location:muur.php");
				break;

			case 'newcomment':
				$id = $_POST['id'];
				$postid = $_POST['postid'];
				$content = $_POST['newpost'];
				$date = time();
				createComment($db, $id, $postid, $content, $date);
				header("Location:muur.php?actie=comments&id=".$postid."");
				break;

			case 'comments':
				$tpl->newBlock("Header");
				$tpl->assign("USER", $_SESSION['user']);
				$tpl->newBlock("body");
				$tpl->newBlock("row");
				$id = $_GET['id'];
				$result = findPostById($db, $id);
				foreach ($result as $row) {
					if ($row['gebruiker_status'] == 1) {
						$tpl->assign( "POSTER", $row['voornaam'] );
						$tpl->assign( "POSTERID", $row['gebruiker_id'] );
					}else{
						$tpl->assign( "POSTER", "Unknown" );
						$tpl->assign( "POSTERID", '0' );
					}
					$content = $row['content'];
					$tpl->assign("CONTENT", $content);
					$tpl->assign( "DATUM",  strftime("%A %d %B %Y", $row['datum']) );
					$tpl->assign( "STATUS", $row['status'] );
					if ($row['gebruiker_id'] == $_SESSION['user'] and $row['post_status'] == 1) {
						$tpl->newBlock("delete");
						$tpl->assign("CONTENT", $content);
						$tpl->assign( "POSTID", $row['post_id']);
					}
					$result = 'NULL';
					$row = 'NULL';
				}
				$tpl->newBlock("newcomment");
				$tpl->assign("USERID",$_SESSION['user']);
				$tpl->assign("POSTID",$_GET['id']);
				$result = findCommentsById($db, $id);
				foreach ($result as $row) {
					$tpl->newBlock("comment");
					if ($row['gebruiker_status'] == 1) {
						$tpl->assign( "POSTER", $row['voornaam'] );
						$tpl->assign( "POSTERID", $row['gebruiker_id'] );
					}else{
						$tpl->assign( "POSTER", "Unknown" );
						$tpl->assign( "POSTERID", '0' );
					}
					$tpl->assign("CONTENT", $row['comment_content']);
					$tpl->assign( "DATUM",  strftime("%A %d %B %Y", $row['comment_datum']) );
					$tpl->assign( "STATUS", $row['comment_status'] );
					$tpl->assign( "AVATAR", $row['avatar'] );
					if ($row['gebruiker_id'] == $_SESSION['user'] and $row['comment_status'] == 1) {
						$tpl->newBlock("commentdelete");
						$tpl->assign( "COMMENTID", $row['comment_id']);
					}
				}
				
				break;

			default:
				$tpl->newBlock("Header");
				$tpl->assign("USER", $_SESSION['user']);
				adminCheck($db, $_SESSION['user']);
				$tpl->newBlock("body");
				$tpl->assign( "USERID", $_SESSION['user'] );
				$tpl->newBlock("newpost");
				$tpl->assign("USERID", $_SESSION['user']);
				$result = findNonBannedPosts($db);
				foreach ($result as $row) {
					$tpl->newBlock("row");
					if ($row['gebruiker_status'] == 1) {
						$tpl->assign( "POSTER", $row['voornaam'] );
						$tpl->assign( "POSTERID", $row['gebruiker_id'] );
					}else{
						$tpl->assign( "POSTER", "Unknown" );
						$tpl->assign( "POSTERID", '0' );
					}
					$content = $row['content'];
					$tpl->assign("CONTENT", $content);
					$tpl->assign( "POSTID", $row['post_id']);
					$tpl->assign( "DATUM",  strftime("%A %d %B %Y", $row['datum']) );
					$tpl->assign( "STATUS", $row['status'] );
					$tpl->assign( "AVATAR", $row['avatar'] );
					if ($row['gebruiker_id'] == $_SESSION['user'] and $row['post_status'] == 1) {
						$tpl->newBlock("delete");
						$tpl->assign("CONTENT", $content);
						$tpl->assign( "POSTID", $row['post_id']);
					}
				}
				break;
			}
		$tpl->printToScreen();
	}