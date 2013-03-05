<h1><?php
	$user->getName();
?></h2>

<div class="row">
	<div class="span8">
		<h1>Profile</h1>
	</div>
</div>

<?php
	$uid = $_GET['prid'];
    echo $uid;
	$posts = getPosts($uid);
    $userInfo = getUser($uid);
    ?>
    <form method="post" action="index.php?id=profile">
            <label>Username</label>
            <input type="text" value="<?php echo $userInfo['uname']; ?>" class="input-xlarge" disabled>
            <label>First Name</label>
            <input type="text" value="<?php echo $userInfo['fname']; ?>" class="input-xlarge">
            <label>Last Name</label>
            <input type="text" value="<?php echo $userInfo['lname']; ?>" class="input-xlarge">
            <label>Email</label>
            <input type="text" value="<?php echo $userInfo['email']; ?>" class="input-xlarge">
            <label>Address</label>
            <textarea value="<?php echo $userInfo['info']; ?>" rows="3" class="input-xlarge"><?php echo $userInfo['info']; ?>
            </textarea>
            <div>
            <button class="btn btn-primary" type="submit">Update</button>
        </div>
    </form>
<?php
if($user->checkAdmin()) { ?>
    <div class="row">
    <div class="span8">
        <h1>Posts</h1>
    </div>
</div>


<?php

foreach($posts as $row) {
      echo '<div class="media">';
      echo '<div class="media-body">';
      echo '<h4 class="media-heading">'.$row['title'].'</h4>';
      echo '<p>'.$row['content'].'</p>';
      echo '</div>';
      echo '</div>';
    }
}

?>