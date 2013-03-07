<?php $page = "newcomment";?>

<form action="index.php?id=viewpost&pid=<?php echo $_GET['pid'];?>" method="post">
	<fieldset>
		<legend>
			New Comment
		</legend>
		<ul>
			<li style="list-style: none;">
				<label class="control-label" for="newcomment"> Post </label>
				<textarea id="newcomment" name="newcomment" rows="10" class="input-xlarge span8" required>
				</textarea>
			</li>
		</ul>
		<?php 
			$publickey = "6Lfc-N0SAAAAACuHV0gwOlPBpCLJWdJrJ9wpSuOa";
			echo recaptcha_get_html($publickey);
		?>
		<button type="submit" name="captchaSubmit" class="btn btn-primary">
			Post
		</button>
	</fieldset>
</form>