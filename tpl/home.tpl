<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="./style/home.css">
	</head>
	<body>
		<!-- START BLOCK : Header -->
		<div class="header">
			<h1>De Muur</h1>
			<form method="post" action="home.php?actie=inloggen">
				<p>
					<label>E-mail: </label>
					<input type="text" name="E-mail" placeholder="E-mail" value="{EMAIL}" required/>
					<label>Wachtwoord: </label>
					<input type="password" name="Password" placeholder="Password" value="{PASSWORD}" required/>
					<input type="submit" value="Inloggen" class="login"/>
					<br>
					<p>{LOGINWARNING}</p>
				</p>
			</form>
		</div>
		<!-- END BLOCK : Header -->
		<!-- START BLOCK : body -->
		<div class="body">
			<h1>Registreren</h1>
			<form method="post" action="home.php?actie=registreren" class="registreer">
				<p>
					<input type="text" name="Voornaam" placeholder="Voornaam" class="voornaam" required/>
					<input type="text" name="Achternaam" placeholder="Achternaam" class="achternaam" required/><br>
					<input type="text" name="E-mail" placeholder="E-mail" required/><br>
					<input type="password" name="Password" placeholder="Password" required/><br>
					<input type="password" name="Password2" placeholder="Password" required/><br>
					<select name="Geslacht">
						<option value="-">Geslacht</option>
						<option value="Man">Man</option>
						<option value="Vrouw">Vrouw</option>
					</select><br>
					<label>Geboortedatum:</label><br>
					<input type="date" name="Date"/><br>
					<p>{REGISTREERWARNING}</p>
					<input type="submit" value="Registreren" class="registreer"/><br>
					
				</p>
			</form>
		</div>
		<!-- END BLOCK : body -->
	</body>
</html>