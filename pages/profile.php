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

<?php 
	$uid = $user->getID(); 
	$user->showProfile($uid);
?>