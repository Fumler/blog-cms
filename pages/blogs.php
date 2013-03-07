<?php $page = "blogs";
  $posts = getAllPosts();


  if(count($posts) > 0) {

    foreach($posts as $row) {
      $numPosts = getNumberOfComments($row['pid']);
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
          <p><i class="icon-calendar"></i> Posted <?php echo $row['created'];?> | <i class="icon-user"></i> Written by <a href="<?php echo '?id=profile&prid='.$row['uid']; ?>"> <?php echo $pic['uname'];?> </a> | <i class="icon-comment"></i> <a href="<?php echo '?id=viewpost&pid='.$row['pid'];?>">Comments</a> (<?php if($numPosts['amount']) { echo $numPosts['amount']; } else { echo "0"; } ?>) | <i class="icon-thumbs-up"></i> <a href="<?php echo 'http://www.facebook.com/share.php?u=http://basketak.net/blog-cms/index.php?id=viewpost&pid='.$row['pid'];?>"> Like </a> | <i class="icon-plus"></i> <a href="<?php echo 'https://plusone.google.com/_/+1/confirm?hl=en&url=http://basketak.net/blog-cms/index.php?id=viewpost&pid='.$row['pid'];?>"> Google+ </a> </p>
        </div>
      </div>


      <?php
    }

  } 
  else 
  {
    echo '<h4>There are no posts</h4>';
  }

?>