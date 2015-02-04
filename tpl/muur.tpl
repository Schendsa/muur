<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="./style/muur.css">
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
			<!-- START BLOCK : newpost -->
			<div class="newpost">
				<img src="{USERAVATAR}" width="32px" height="32px" class="avatar">
				<form class="newpost" method="post" action="muur.php?actie=createpost">
					<textarea type="text" name="newpost" class="newpost" placeholder="Make a new post!" required></textarea>
					<input type="hidden" name="id" value="{USERID}"/>
					<input type="submit" value="Create post" class="createpost"/>
				</form>
			</div>
			<!-- END BLOCK : newpost -->
			<!-- START BLOCK : edit -->
			<div class="edit">
				<h1>Post editen</h1>
				<img src="{USERAVATAR}" width="32px" height="32px" class="avatar">
				<form class="edit" method="post" action="muur.php?actie={EDITTYPE}">
					<textarea type="text" name="content" class="newpost" placeholder="Change your post!" required>{CONTENT}</textarea>
					<input type="hidden" name="id" value="{POSTID}"/>
					<input type="hidden" name="postid" value="{COMMENTID}">
					<input type="submit" value="Edit post" class="createpost"/>
				</form>
			</div>
			<!-- END BLOCK : edit -->
			<!-- START BLOCK : row -->
			<img src="{AVATAR}" width="32px" height="32px" class="avatar">
			<div class="post">
				<p><a href='profiel.php?id={POSTERID}'>{POSTER}</a> heeft gepost op {DATUM}</p>
				<p>{CONTENT}</p>
				<a href='muur.php?actie=comments&id={POSTID}'>Comments</a>
				<a href='muur.php?actie={NAMELIKE}&liketype={TYPELIKE}&id={POSTID}'>{NAMELIKE}</a>
				<!-- START BLOCK : delete -->
				<form name="edit" method="post" action="muur.php?actie=edit">
					<input type="hidden" value="{POSTID}" name="postid">
					<input type="hidden" value="{CONTENT}" name="content">
					<input type="submit" value="Edit">
				</form>
				<form name="delete" method="post" action="muur.php?actie=delete">
					<input type="hidden" value="{POSTID}" name="postid">
					<input type="submit" value="Delete">
				</form>
				<!-- END BLOCK : delete -->
			</div>
			<!-- END BLOCK : row -->
			<!-- START BLOCK : newcomment -->
			<div class="newpost">
				<img src="{USERAVATAR}" width="32px" height="32px" class="avatar">
				<form class="newpost" method="post" action="muur.php?actie=newcomment">
					<textarea type="text" name="newpost" class="newcomment" placeholder="Make a new comment!" required></textarea>
					<input type="hidden" name="id" value="{USERID}"/>
					<input type="hidden" name="postid" value="{POSTID}"/>
					<input type="submit" value="Create comment" class="createpost"/>
				</form>
			</div>
			<!-- END BLOCK : newcomment -->
			<!-- START BLOCK : comment -->
			<div class="comment">
				<p><a href='profiel.php?id={POSTERID}'>{POSTER}</a> heeft gecomment op {DATUM}</p>
				<p>{CONTENT}</p>
				<!-- START BLOCK : commentdelete -->
				<form name="edit" method="post" action="muur.php?actie=commentedit">
					<input type="hidden" value="{COMMENTID}" name="postid">
					<input type="hidden" value="{CONTENT}" name="content">
					<input type="submit" value="Edit">
				</form>
				<form name="delete" method="post" action="muur.php?actie=commentdelete">
					<input type="hidden" value="{COMMENTID}" name="postid">
					<input type="submit" value="Delete">
				</form>
				<!-- END BLOCK : commentdelete -->
			</div>
			<!-- END BLOCK : comment -->
		</div>
		<!-- END BLOCK : body -->
	</body>
</html>