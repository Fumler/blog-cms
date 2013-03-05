<?php $page = "newpost";?>
<h1>Create a new blog post!</h1>

<?php
	function createPost($title, $content) 
	{
		global $db, $user;
		$sql = 'INSERT INTO posts (title, content, created, uid) '
			. 'VALUES (:title, :content, now(), :uid)';
		$sth =  $db -> prepare ($sql);
		$sth -> bindParam (':title', $title);
		$sth -> bindParam (':content', $content);
		$sth -> bindParam (':uid', $user -> getId());

		$sth -> execute();
		$sth -> closeCursor();

		?>
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php echo "<p><strong>Your blog post have been created</strong></p>" ?>
			</div> 
		<?php
	}
?>

<?php
	if(isset($_POST['title']) && isset($_POST['newpost']))
	{
		$title = $_POST['title'];
		$content = $_POST['newpost'];
		createPost($title, $content);
	}
?>

<form action="index.php?id=newpost" method="post">
	<fieldset>
		<legend>
			Information
		</legend>
		<ul>
			<li>
				<label for="title"> Title </label>
				<input id="title" name="title" type="text"
					placeholder="The title of your post" required autofocus>
			</li>

			<li>
				<label for="newpost"> Post </label>
				<div class="btn-toolbar">
				  <div class="btn-group">
				      <button class="btn" data-original-title="Bold - Ctrl+B"><i class="icon-bold"></i></button>
				      <button class="btn" data-original-title="Italic - Ctrl+I"><i class="icon-italic"></i></button>
				      <button class="btn" data-original-title="List"><i class="icon-list"></i></button>
				      <button class="btn" data-original-title="Img"><i class="icon-picture"></i></button>
				      <button class="btn" data-original-title="URL"><i class="icon-globe"></i></button>
				  </div>
				  <div class="btn-group">
				      <button class="btn" data-original-title="Align Right"><i class="icon-align-right"></i></button>
				      <button class="btn" data-original-title="Align Center"><i class="icon-align-center"></i></button>
				      <button class="btn" data-original-title="Align Left"><i class="icon-align-left"></i></button>
				  </div>
				  <div class="btn-group">
				      <button class="btn" data-original-title="Preview"><i class="icon-eye-open"></i></button>
				      <button class="btn" data-original-title="Save"><i class="icon-ok"></i></button>
				      <button class="btn" data-original-title="Cancel"><i class="icon-trash"></i></button>
				  </div>
				</div>
				<textarea id="newpost" name="newpost" rows="15" class="input-xlarge span8"  required>
				</textarea>
			</li>
		</ul>
		<button type="submit" class="btn btn-primary">
			Send
		</button>
	</fieldset>
</form>
