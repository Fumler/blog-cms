<?php $page = "contact";?>
<h1>Contact Us</h1>

<?php
	if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['details']))
	{
	    $name=$_POST['name'];
	    $email=$_POST['email'];
	    $details=$_POST['details'];
	    $to='fmaster@basketak.net';
	    $subject='Customer Enquiry';

	    $msg="Customer Enquiry:"." Name: $name".
	    " Email: $email"." Message: $details";
	    mail($to,$subject,$msg,'From:'.$email);

		?>
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php echo "<p><strong>Your e-mail have been sent</strong></p>" ?>
			</div> 
		<?php
	}
?>

<form action="index.php?id=contact" method="post">
	<fieldset>
		<legend>
			Your details
		</legend>
		<ol>
			<li>
				<label for="name"> Name </label>
				<input id="name" name="name" type="text"
					placeholder="First and last name" required autofocus>
			</li>
			<li>
				<label for="email"> Email </label>
				<input id="email" name="email" type="email"
				placeholder="example@domain.com" required>
			</li>
		</ol>
	</fieldset>
	<fieldset>
		<legend>
			Your Enquiry
		</legend>
		<ol>
			<li>
				<label for="address"> Details </label>
				<textarea id="address" name="details" class="input-xlarge span5" rows="5" required>
				</textarea>
			</li>
		</ol>
		<button type="submit" class="btn btn-primary">
			Send
		</button>
	</fieldset>
</form>
