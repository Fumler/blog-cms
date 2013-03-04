<h1><?php 
	$user->getName();
?></h2>

<div class="row">
	<div class="span8">
		<h1>Profile - <?php echo $user->getName() ?></h1>
	</div>
	<div class="span2">
		<button class="btn btn-warning" type="button">Edit Profile</button>
	</div>
</div>

<dl class="dl-horizontal">
	<dt>First name: </dt>

	<dt>Last name: </dt>
	
	<dt>Email: </dt>

	<dt>Address: </dt>

	<dt>Info: </dt>
</dl>