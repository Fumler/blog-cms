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

foreach($posts as $row) { ?>
      <div class="row">
        <div class="span8">
          <div class="row">
            <div class="span8">
              <h4><strong><a href="#"><?php echo $row['title'];?></a></strong></h4>
            </div>
          </div>
          <div class="row">
            <div class="span8">

            </div>
          </div>
          <div class="row">
            <div class="span2">
              <a href="#" class="thumbnail">
                  <img src="<?php echo $userInfo['pic'];?>" alt="">
              </a>
            </div>
            <div class="span6">
              <p><?php echo $row['content'];?></p>
            </div>
          </div>
          <div class="row">
            <div class="span8">
              <p></p>
              <p>
                <i class="icon-calendar"></i>Posted <?php echo $row['created'];?>
                 - <i class="icon-comment"></i> <a href="#">Comments</a>
                 - <i class="icon-thumbs-up"></i> <a href="#">Likes</a>
              </p>
            </div>
          </div>
        </div>
      </div>



<?php
      // echo '<div class="media">';
      // echo '<div class="media-body">';
      // echo '<h4 class="media-heading">'.$row['title'].'</h4>';
      // echo '<p>'.$row['content'].'</p>';
      // echo '</div>';
      // echo '</div>';
    }
}

?>