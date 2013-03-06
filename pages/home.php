<?php error_reporting(E_ALL ^ E_NOTICE); ?>

<div class="row">
  <div class="span8">
<?php
if($user->loggedOn()) {
  $userPosts = $user->showPosts($user->getID());
  $userInfo = $user->showUser($user->getID());


  if(count($userPosts > 0)) {

    foreach($userPosts as $row) { ?>
      <div class="row">
        <div class="span8">
          <a href="<?php echo '?id=viewpost&pid=' . $row["pid"];?>">
          <h3><?php echo $row['title'];?></h3>
        </div>
      </div>
      <div class="row">
        <div class="span1">
          <a href="#" class="thumbnail">
            <img src="<?php echo $userInfo['pic'];?>">
          </a>
        </div>
        <div class="span7">
          <p><?php echo $row['content'];?></p>
        </div>
      </div>
      <div class="row">
        <div class="span8">
          <p></p>
          <p><i class="icon-calendar"></i> Posted <?php echo $row['created'];?> | <i class="icon-user"></i> Written by <?php echo $userInfo['uname'];?> | <i class="icon-comment"></i> Comments | <i class="icon-thumbs-up"></i> Likes</p>
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
          <a href="<?php echo '?id=viewpost&pid=' . $row["pid"];?>">
          <h3><?php echo $row['title'];?></h3>
        </div>
      </div>
      <div class="row">
        <div class="span1">
          <a href="#" class="thumbnail">
            <img src="<?php echo $pic['pic'];?>">
          </a>
        </div>
        <div class="span7">
          <p><?php echo $row['content'];?></p>
        </div>
      </div>
      <div class="row">
        <div class="span8">
          <p></p>
          <p><i class="icon-calendar"></i> Posted <?php echo $row['created'];?> | <i class="icon-user"></i> Written by <?php echo $pic['uname'];?> | <i class="icon-comment"></i> Comments | <i class="icon-thumbs-up"></i> Likes</p>
        </div>
      </div>


      <?php
    }

  } else {
    echo '<h4>There are no posts</h4>';
  }
}

?>
  </div>
  <div class="span3">
    <h4>Sort by</h4>

      <form action="index.php?id=home" method="post">
        <label>Time span</label>
        <select name="weeks">
          <option value="1">1 week</option>
          <option value="2">2 weeks</option>
          <option value="3">3 weeks</option>
          <option value="4">4 weeks</option>
          <option value="all">All time</option>
        </select>
        <label>Sort by</label>
        <select name="sort">
          <option value="comments">Comments</option>
          <option value="views">Views</option>
        </select>
        <br>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <h4>Top posts</h4>
    <div class="well" style="width: 300px;">
      <?php
      if(isset($_POST['weeks']) && isset($_POST['sort'])) {
          $posts = getTopPosts($_POST['weeks'], $_POST['sort']);
          foreach($posts as $row) {
            echo '<ul>';
            echo '<li>';
            echo '<a href="?viewpost&pid='.$row['pid'].'">'.$row['title'].'</a>';
            echo '</li>';
            echo '</ul>';
        }
      }
      ?>


    </div>
    <h4>Top users</h4>
    <div class="well" style="width: 300px;">

    </div>
  </div>
</div>

  <!-- <div class="row">

        <div class="span8">
            asdadsasddasdasd
        </div>
        <div class="span3">
            asdasdasdasdasd
        </div>
    </div> -->