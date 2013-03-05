<?php
if($user->loggedOn()) {
  $userPosts = $user->showPosts($user->getID());
  $userInfo = $user->showUser($user->getID());


  if(count($userPosts > 0)) {

    foreach($userPosts as $row) { ?>
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
                 -  <i class="icon-user"></i>Written by <?php echo $pic['uname'];?>
                 - <i class="icon-comment"></i> <a href="#">Comments</a>
                 - <i class="icon-thumbs-up"></i> <a href="#">Likes</a>
              </p>
            </div>
          </div>
        </div>
      </div>

    <?php
    }
  } else {
    echo '<h4>You have no posts</h4>';
  }


} else {
  $posts = getAllPosts();


  if(count($posts) > 0) {

    foreach($posts as $row) {
      $pic = getUser($row['uid']); ?>
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
                  <img src="<?php echo $pic['pic'];?>" alt="">
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
                 -  <i class="icon-user"></i>Written by <?php echo $pic['uname'];?>
                 - <i class="icon-comment"></i> <a href="#">Comments</a>
                 - <i class="icon-thumbs-up"></i> <a href="#">Likes</a>
              </p>
            </div>
          </div>
        </div>
      </div>


      <?php
      // echo '<div class="media">';
      // echo '<a class="pull-left" href="#">';
      // echo '<img class="media-object" src="'.$pic['pic'].'">';
      // echo '</a>';
      // echo '<div class="media-body">';
      // echo '<h4 class="media-heading">'.$row['title'].'</h4>';
      // echo '<p>'.$row['content'].'</p>';
      // echo '</div>';
      // echo '</div>';
    }

  } else {
    echo '<h4>There are no posts</h4>';
  }
}

?>


