<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="./style/admin.css">
	</head>
	<body>
		<!-- START BLOCK : Header -->
		<div class="header">
			<h1>De Muur</h1>
			<a href='muur.php?actie=uitloggen'>Uitloggen</a>
			<a href='profiel.php?id={USER}'>Profiel</a>
			<a href='muur.php'>Muur</a>
			<a href='admin.php'>Admin</a>
		</div>
		<!-- END BLOCK : Header -->
		<!-- START BLOCK : table -->
		<div class="header">
			<a href='admin.php?actie=users'>Users</a>
			<a href='admin.php?actie=comments'>Comments</a>
			<a href='admin.php'>Posts</a>
		</div>
		<table border="1">
			<tr>
				<th style="width:30px;">ID</th>
				<th style="width:200px;">Poster</th>
				<th>Content</th>
				<th style="width:200px;">Postdatum</th>
				<th style="width:100px;">Banstatus</th>
			</tr>
				<!-- START BLOCK : row -->
				<tr>
					<td>{ID}</td>
					<td>{VOORNAAM} {ACHTERNAAM}</td>
					<td>{CONTENT}</td>
					<td>{DATUM}</td>
					<td><a href="admin.php?actie={ACTIE}&id={ID}">{BAN}</a></td>
				</tr>
				<!-- END BLOCK : row -->
		</table>
		<!-- END BLOCK : table -->
		<!-- START BLOCK : usertable -->
		<div class="header">
			<a href='admin.php?actie=users'>Users</a>
			<a href='admin.php?actie=comments'>Comments</a>
			<a href='admin.php'>Posts</a>
		</div>
		<table border="1">
			<tr>
				<th style="width:30px;">ID</th>
				<th>Naam</th>
				<th>E-mail</th>
				<th>Geslacht</th>
				<th>Adres</th>
				<th>Postcode</th>
				<th>Woonplaats</th>
				<th>Telefoon</th>
				<th>Mobiel</th>
				<th>Admin status</th>
				<th>Ban status</th>
			</tr>
				<!-- START BLOCK : userrow -->
				<tr>
					<td>{ID}</td>
					<td>{VOORNAAM} {ACHTERNAAM}</td>
					<td>{EMAIL}</td>
					<td>{GESLACHT}</td>
					<td>{ADRES}</td>
					<td>{POSTCODE}</td>
					<td>{WOONPLAATS}</td>
					<td>{TELEFOON}</td>
					<td>{MOBIEL}</td>
					<td><a href="admin.php?actie={ADMINACTIE}&id={ID}">{ADMIN}</a></td>
					<td><a href="admin.php?actie={ACTIE}&id={ID}">{BAN}</a></td>
				</tr>
				<!-- END BLOCK : userrow -->
		</table>
		<!-- END BLOCK : usertable -->
	</body>
</html>	