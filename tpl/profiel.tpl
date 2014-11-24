<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="./style/profiel.css">
	</head>
	<body>
		<!-- START BLOCK : Header -->
		<div class="header">
			<h1>De Muur</h1>
			<a href='muur.php?actie=uitloggen'>Uitloggen</a>
			<a href='profiel.php?id={USER}'>Profiel</a>
			<a href='muur.php'>Muur</a>
			<!-- START BLOCK : admin -->
			<a href='admin.php'>Admin</a>
			<!-- END BLOCK : admin -->
		</div>
		<!-- END BLOCK : Header -->

		<!-- START BLOCK : body -->
		<div class="body">
			<h1>Profiel</h1><br>
			<!-- START BLOCK : bodyander -->
			<a href="profiel.php?actie=sort&id={ID}" class="veranderen">Alle posts van deze user.</a>
			<img src="{AVATAR}">
			<p>Naam: {VOORNAAM} {ACHTERNAAM}</p>
			<p>E-mail: {EMAIL}</p>
			<p>Geslacht: {GESLACHT}</p>
			<p>Geboortedatum: {GEBOORTEDATUM}</p>
			<p>Adres: {ADRES}</p>
			<p>Postcode: {POSTCODE}</p>
			<p>Woonplaats: {WOONPLAATS}</p>
			<p>Telefoon: {TELEFOON}</p>
			<p>Mobiel: {MOBIEL}</p>
			<!-- END BLOCK : bodyander -->
			<!-- START BLOCK : passedit -->
			<form method="Post" action="profiel.php?actie=newpass">
				<h2>Wachtwoord veranderen</h2>
				<label>Oude wachtwoord: </label>
				<input type="paswoord" name="oudwachtwoord"><br>
				<label>Nieuw wachtwoord: </label>
				<input type="password" name="nieuwwachtwoord"><br>
				<label>Nieuw wachtwoord opnieuw: </label>
				<input type="password" name="nieuwwachtwoord2"><br>
				<input type="submit" value="Verander wachtwoord"><a href="profiel.php?id={ID}" class="veranderen" style="margin-left:5px;">Terug</a>
			</form>
			<!-- END BLOCK : passedit -->
			<!-- START BLOCK : bodyedit -->
			<img src="{AVATAR}"><a href="" class="veranderen">Nieuwe avatar uploaden</a><br>
			<a href="profiel.php?actie=passedit" class="veranderen">Wachtwoord veranderen</a><br>
			<a href="profiel.php?actie=sort&id={ID}" class="veranderen">Alle posts van deze user.</a>
			<form method="post" action="profiel.php?actie=edit">
				<label>Naam: </label>
				<input type="text" value="{VOORNAAM}" style="width:75px;margin-right:10px;" name="voornaam" required><input type="text" value="{ACHTERNAAM}" name="achternaam" required><br>
				<label>E-Mail: </label>
				<input type="text" value="{EMAIL}" name="email" required><br>
				
				<label>Geslacht: </label>
				<select name="geslacht" value="{GESLACHT}" required>
					<option value="-">Geslacht</option>
					<option value="Man">Man</option>
					<option value="Vrouw">Vrouw</option>
				</select><br>
				<label>Adres: </label>
				<input type="text" value="{ADRES}" name="adres"><br>
				<label>Postcode: </label>
				<input type="text" value="{POSTCODE}" name="postcode"><br>
				<label>Woonplaats: </label>
				<input type="text" value="{WOONPLAATS}" name="woonplaats"><br>
				<label>Telefoon: </label>
				<input type="text" value="{TELEFOON}" name="telefoon"><br>
				<label>Mobiel: </label>
				<input type="text" value="{MOBIEL}" name="mobiel"><br>
				<input type="submit" value="Opslaan" class="registreer"/>
			</form>
			<!-- END BLOCK : bodyedit -->
			<!-- START BLOCK : sortpost -->
			<img src="{AVATAR}" width="32px" height="32px" class="avatar">
			<div class="post">
				<p><a href='profiel.php?id={POSTERID}'>{POSTER}</a> heeft gepost op {DATUM}</p>
				<p>{CONTENT}</p>
				<p><a href=''>Like</a>
				<a href=''>Comments</a>
				<a href=''>Reageer</a>
				<!-- START BLOCK : delete -->
				<form name="delete" method="post" action="muur.php?actie=edit">
					<input type="hidden" value="{POSTID}" name="postid">
					<input type="submit" value="Edit">
				</form>
				<form name="delete" method="post" action="muur.php?actie=delete">
					<input type="hidden" value="{POSTID}" name="postid">
					<input type="submit" value="Delete">
				</form>
				<!-- END BLOCK : delete -->
			</div>
			<!-- END BLOCK : sortpost -->
		</div>
		<!-- END BLOCK : body -->
	</body>
</html>	