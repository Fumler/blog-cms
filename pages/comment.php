<?php $page = "newcomment";?>


<form action="index.php?id=viewpost&pid=<?php echo $_GET['pid'];?>" method="post">
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
