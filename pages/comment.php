<?php $page = "newcomment";?>
<?php
	function createComment($title, $content)
	{
		global $db, $user, $pid;
		$sql = 'INSERT INTO comments (content, created, pid, uid) '
			. 'VALUES ( :content, now(), :pid , :uid)';
		$sth =  $db -> prepare ($sql);
		$sth -> bindParam (':content', $content);
		$sth -> bindParam (':uid', $user -> getId());
		$sth -> bindParam (':pid', $pid);

		$sth -> execute();
		$sth -> closeCursor();

		?>
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php echo "<p><strong>Your comment have been created</strong></p>" ?>
			</div>
		<?php
	}
?>

<?php
	if(isset($_POST['title']) && isset($_POST['newcomment']))
	{
		$title = $_POST['title'];
		$content = $_POST['newcomment'];
		createComment($content);
	}
?>

<form action="index.php?id=viewpost&pid=".$_GET['pid'] method="post">
	<fieldset>
		<legend>
			New Comment
		</legend>
		<ul>
			<li style="list-style: none;">
				<label class="control-label" for="newcomment"> Post </label>
				<textarea id="newcomment" name="newcomment" rows="10" class="input-xlarge span8"  required>
				</textarea>
			</li>
		</ul>
		<button type="submit" class="btn btn-primary">
			Send
		</button>
	</fieldset>
</form>
