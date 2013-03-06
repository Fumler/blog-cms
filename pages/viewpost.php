<?php
  	$pid = $_GET['pid'];
  	$post = getPostById($pid);

    $userInfo = getUser($post['uid']);

    if(count($post > 0)) // If a post exists with that ID. 
    {
?>     
       <div class="row">
            <div class="span8">
               <h1><strong><a href="#"><?php echo $post['title'];?></a></strong></h1>
            </div>
      </div>

      <div class="row">
        <div class="span2">
            <a href="#" class="thumbnail">
                <img src="<?php echo $userInfo['pic'];?>" alt="">
            </a>
        </div>

        <div class="span6">
          <p><?php echo $post['content'];?></p>
        </div>
      </div>

      <div class="row">
        <div class="span8">
          <p></p>
          <p>
            <i class="icon-calendar"></i>Posted <?php echo $post['created'];?>
             - <i class="icon-user"></i>Written by <?php echo $userInfo['uname'];?>
             - <i class="icon-comment"></i> <a href="#">Comments</a>
             - <i class="icon-thumbs-up"></i> <a href="#">Likes</a>
          </p>
        </div>
      </div>
    <?php
    }
    else
    {
      echo "We're sorry, but the post was not found!"; 
    }
?>