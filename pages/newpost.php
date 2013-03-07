<?php $page = "newpost";?>
<h1>Create a new blog post!</h1>

<?php
	$success = false;

	if (isset($_POST['captchaSubmit'])) {
		$privatekey = "6Lfc-N0SAAAAAPXPbstwKGqFcJj6gf0P2qK6xQHU";
		$resp = recaptcha_check_answer ($privatekey,
		                            $_SERVER["REMOTE_ADDR"],
		                            $_POST["recaptcha_challenge_field"],
		                            $_POST["recaptcha_response_field"]);

		if (!$resp->is_valid) { 
			?>
		      <div class="alert alert-error">
		        <button type="button" class="close" data-dismiss="success">&times;</button>
		      <?php echo "<p><strong>Captcha failed!</strong></p>" ?>
		      </div>
	      	<?php

	      	$success = false;
		} else {
	      	$success = true;
		}
	}
?>

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
	if(isset($_POST['title']) && isset($_POST['newpost']) && $success)
	{
		$title = $_POST['title'];
		$content = $_POST['newpost'];
		createPost($title, $content);
	}
?>

<form action="index.php?id=newpost" method="post">
	<fieldset>
				<input id="title" style="width: 600px;" name="title" type="text"
					placeholder="The title of your post" required autofocus>
				<textarea rows="10" style="width: 600px;" id="newpost" name="newpost" placeholder="Enter text ..."></textarea>
				<script type="text/javascript">
					$('#newpost').wysihtml5();
				</script>





			<!-- <li style="list-style: none;">
				<label class="control-label" for="newpost"> Post </label>
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
			</li> -->
		<br>

		<?php 
			$publickey = "6Lfc-N0SAAAAACuHV0gwOlPBpCLJWdJrJ9wpSuOa";
			echo recaptcha_get_html($publickey);
		?>
		<button type="submit" name="captchaSubmit" class="btn btn-primary">
			Post
		</button>
	</fieldset>
</form>
