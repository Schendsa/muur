<?php
	function connectToDatabase($host, $database, $user, $pass){
	$db = new PDO('mysql:host='.$host.';dbname='.$database.'', ''.$user.'', ''.$pass.'');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $db;
	}
	function getLoggedInUserId($db, $email, $pass){
	$sql = "SELECT * FROM gebruiker WHERE email='$email' AND paswoord='$pass' AND status='1'";
	$result = $db->query($sql);
	if ($user = $result->fetch(PDO::FETCH_ASSOC))
		{
			return $user['id'];
		}
	return -1;
	}
	function getEmailId($db, $email){
	$sql = "SELECT * FROM gebruiker WHERE email='$email'";
	$result = $db->query($sql);
	if ($user = $result->fetch(PDO::FETCH_ASSOC))
		{
			return $user['id'];
		}
	return -1;
	}
	function registerPerson($db, $voornaam, $achternaam, $geslacht, $geboortedatum){
	$sth = $db->prepare("INSERT INTO persoon (voornaam, achternaam, geslacht, geboortedatum, avatar) VALUES (:voornaam, :achternaam, :geslacht, :geboortedatum, 'https://lh3.googleusercontent.com/-yTaEpRHgQpg/AAAAAAAAAAI/AAAAAAAAAIc/lpMIq_VxF7s/photo.jpg')");
	$sth->bindParam(':voornaam', $voornaam, PDO::PARAM_STR);
	$sth->bindParam(':achternaam', $achternaam, PDO::PARAM_STR);
	$sth->bindParam(':geslacht', $geslacht, PDO::PARAM_STR);
	$sth->bindParam(':geboortedatum', $geboortedatum, PDO::PARAM_STR);
	$sth->execute();
	$personid = $db->lastInsertId();
	return $personid;
	}
	function registerUser($db, $email, $password, $persoon_id){
	$sth = $db->prepare("INSERT INTO gebruiker (email, paswoord, status, groep_id, persoon_id) VALUES (:email, :paswoord, 1, 2, :persoon_id)");
	$sth->bindParam(':email', $email, PDO::PARAM_STR);
	$sth->bindParam(':paswoord', $password, PDO::PARAM_STR);
	$sth->bindParam(':persoon_id', $persoon_id, PDO::PARAM_INT);
	$sth->execute();
	}
	function findAllPosts($db){
	$sql = "SELECT *, post.id as post_id, post.status as post_status, gebruiker.status as gebruiker_status FROM post INNER JOIN gebruiker ON post.gebruiker_id=gebruiker.id INNER JOIN persoon ON gebruiker.persoon_id=persoon.id ORDER BY post.datum desc";
	$result = $db->query($sql);
	return $result;
	}
	function findPostsById($db, $id){
		$sql = "SELECT *, post.id as post_id, post.status as post_status, gebruiker.status as gebruiker_status FROM post INNER JOIN gebruiker ON post.gebruiker_id=gebruiker.id INNER JOIN persoon ON gebruiker.persoon_id=persoon.id where gebruiker.id = $id ORDER BY post.datum desc";
		$result = $db->query($sql);
		return $result;
	}
	function createPost($db, $id, $content, $time){
		$sth = $db->prepare("INSERT INTO post (content, datum, status, gebruiker_id) VALUES (:content, :datum, 1, :gebruiker_id)");
		$sth->bindParam(':content', $content, PDO::PARAM_STR);
		$sth->bindParam(':datum', $time, PDO::PARAM_STR);
		$sth->bindParam(':gebruiker_id', $id, PDO::PARAM_INT);
		$sth->execute();
	}
	function deletePost($db, $id){
		$sql = "UPDATE post SET status=0 WHERE id=$id";
		$result = $db->exec($sql);
	}
	function findUserInfo($db, $id){
		$sql = "SELECT * FROM gebruiker INNER JOIN persoon ON gebruiker.persoon_id=persoon.id where gebruiker.id=$id";
		$result = $db->query($sql);
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
	function findContentById($db, $id){
		$sql = "SELECT content FROM post WHERE id=$id";
		$result = $db->query($sql);
		return $result;
	}
	function changeUserInfo($db, $id, $voornaam, $achternaam, $email, $geslacht, $adres, $postcode, $woonplaats, $telefoon, $mobiel){
		$sth = $db->prepare("UPDATE gebruiker INNER JOIN persoon ON gebruiker.persoon_id=persoon.id SET voornaam=:voornaam, achternaam=:achternaam, email=:email, geslacht=:geslacht, adres=:adres, postcode=:postcode, woonplaats=:woonplaats, telefoon=:telefoon, mobiel=:mobiel WHERE gebruiker.id=$id");
		$sth->bindParam(':voornaam', $voornaam, PDO::PARAM_STR);
		$sth->bindParam(':achternaam', $achternaam, PDO::PARAM_STR);
		$sth->bindParam(':email', $email, PDO::PARAM_STR);
		$sth->bindParam(':geslacht', $geslacht, PDO::PARAM_STR);
		$sth->bindParam(':adres', $adres, PDO::PARAM_STR);
		$sth->bindParam(':postcode', $postcode, PDO::PARAM_STR);
		$sth->bindParam(':woonplaats', $woonplaats, PDO::PARAM_STR);
		$sth->bindParam(':telefoon', $telefoon, PDO::PARAM_INT);
		$sth->bindParam(':mobiel', $mobiel, PDO::PARAM_INT);
		$sth->execute();
	}
	function newPassCheck($db, $id, $oldpass){
		$sth = $db->prepare("SELECT * FROM gebruiker WHERE id=$id AND paswoord=:oldpass");
		$sth->bindParam(':oldpass', $oldpass, PDO::PARAM_STR);
		$sth->execute();
		if ($check = $sth->fetch(PDO::FETCH_ASSOC))
		{
			return TRUE;
		}
		return FALSE;
	}
	function changePass($db, $id, $newpass){
		$sth = $db->prepare("UPDATE gebruiker SET paswoord=:newpass WHERE id=$id");
		$sth->bindParam(':newpass', $newpass, PDO::PARAM_STR);
		$sth->execute();
	}
	function editPost($db, $id, $content){
		$sth = $db->prepare("UPDATE post SET content=:content WHERE id=$id");
		$sth->bindParam(':content', $content, PDO::PARAM_STR);
		$sth->execute();
	}
	function findNonBannedPosts($db){
		$sql = "SELECT *, post.id as post_id, post.status as post_status, gebruiker.status as gebruiker_status FROM post INNER JOIN gebruiker ON post.gebruiker_id=gebruiker.id INNER JOIN persoon ON gebruiker.persoon_id=persoon.id WHERE post.status=1 ORDER BY post.datum desc";
		$result = $db->query($sql);
		return $result;
	}
	function adminCheck($db, $id){
		$sql = "SELECT groep_id FROM gebruiker WHERE id=$id";
		$result = $db->query($sql);
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
	function findPostById($db, $id){
		$sql = "SELECT *, post.id as post_id, post.status as post_status, gebruiker.status as gebruiker_status FROM post INNER JOIN gebruiker ON post.gebruiker_id=gebruiker.id INNER JOIN persoon ON gebruiker.persoon_id=persoon.id where post.id = $id";
		$result = $db->query($sql);
		return $result;
	}
	function findCommentsById($db, $id){
		$sql = "SELECT *,comment.datum as comment_datum, comment.content as comment_content, comment.id as comment_id, comment.status as comment_status, gebruiker.status as gebruiker_status, gebruiker.id as gebruiker_id FROM comment INNER JOIN post ON post.id=comment.post_id INNER JOIN gebruiker ON comment.gebruiker_id=gebruiker.id INNER JOIN persoon ON gebruiker.persoon_id=persoon.id WHERE post_id = $id ORDER BY post.datum desc";
		$result = $db->query($sql);
		return $result;
	}
	function createComment($db, $id, $postid, $content, $date){
		$sth = $db->prepare("INSERT INTO comment (content, datum, status, post_id, gebruiker_id) VALUES (:content, :datum, 1, :post_id, :gebruiker_id)");
		$sth->bindParam(':content', $content, PDO::PARAM_STR);
		$sth->bindParam(':datum', $date, PDO::PARAM_STR);
		$sth->bindParam(':gebruiker_id', $id, PDO::PARAM_INT);
		$sth->bindParam(':post_id', $postid, PDO::PARAM_INT);
		$sth->execute();
	}
	function editComment($db, $id, $content){
		$sth = $db->prepare("UPDATE comment SET content=:content WHERE id=$id");
		$sth->bindParam(':content', $content, PDO::PARAM_STR);
		$sth->execute();
	}
	function deleteComment($db, $id){
		$sql = "UPDATE comment SET status=0 WHERE id=$id";
		$result = $db->exec($sql);
	}