<?php $page = "editpost";?>
<h1>Edit a blog post</h1>
<?php
	function updatePost($title, $content)
	{
		global $db, $user;
		$sql = 'UPDATE posts SET title = :title, content = :content, updated = now() WHERE pid=:pid';
		$sth =  $db -> prepare ($sql);
		$sth -> bindParam (':title', $title);
		$sth -> bindParam (':content', $content);
		$sth -> bindParam (':pid', $_GET['pid']);

		$sth -> execute();
		$sth -> closeCursor();

		?>
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php echo "<p><strong>Your blog post have been updated</strong></p>" ?>
			</div>
		<?php
	}
?>

<?php
	if(isset($_POST['editpost']) && isset($_POST['title']))
	{
		$editPost = $_POST['editpost'];
		$title = $_POST['title'];
		updatePost($title, $editPost);
	}
	else if(isset($_GET['pid']))
	{
		$pid = $_GET['pid'];
		$post = getPostById($pid);
		
		if($post['uid'] == $user -> getID())
		{?>

<form action="?id=editpost&pid=<?php echo($pid) ?>" method="post">
	<fieldset>
				<input id="title" style="width: 600px;" name="title" type="text" value="<?php echo($post['title']) ?>" required>
				<textarea rows="10" style="width: 600px;" id="editpost" name="editpost"> <?php echo($post['content']) ?> </textarea>
				<script type="text/javascript">
					$('#editpost').wysihtml5();
				</script>
		<br>
			<button type="submit" name="submit" class="btn btn-primary">
				Edit
			</button>
	</fieldset>
</form>
		<?php
		}
	}
	?>
