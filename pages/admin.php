<?php
  if(isset($_POST['delete']))
  {
    $delete = $_POST['delete'];
    if($delete == "delete")
    {
      if(isset($_GET['cid']))
      {
        deleteComment($_GET['cid']);
        ?>
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <?php echo "<p><strong>Comment have been deleted</strong></p>" ?>
        </div>
        <?php
      }
      else if(isset($_GET['pid']))
      {
        deletePost($_GET['pid']);
        ?>
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <?php echo "<p><strong>Post have been deleted</strong></p>" ?>
        </div>
        <?php
      }
    }
  }

 if(isset($_POST['reset'])) {
  if(isset($_GEt['cid'])) {
    resetReportsOnComment($_GET['cid']);
     ?>
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <?php echo "<p><strong>Comment have been reset</strong></p>" ?>
        </div>
        <?php

  } else if(isset($_POST['pid'])) {
    resetReportsOnPost($_GET['pid']);
     ?>
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <?php echo "<p><strong>Post have been reset</strong></p>" ?>
        </div>
        <?php

  }
}
?>

<?php
if($user->checkAdmin()) { ?>
<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#pane1" data-toggle="tab">Posts</a></li>
    <li><a href="#pane2" data-toggle="tab">Comments</a></li>
    <li><a href="#pane3" data-toggle="tab">Users</a></li>
    <li><a href="#pane4" data-toggle="tab">Settings</a></li>
    <li><a href="#pane5" data-toggle="tab">Ban appeals</a></li>
  </ul>
  <div class="tab-content">
    <div id="pane1" class="tab-pane active">
      <?php
        $posts = getAllReportedPosts();

        foreach($posts as $post)
        {
          $tempUser = getUser($post['uid']);
          ?>
          <div class="row">
            <div class="span4">
              <h4><strong><a href="?id=profile&prid=<?php echo $tempUser['uid'];?>"><?php echo $tempUser['uname'];?></a></strong></h4>
            </div>
          </div>

          <div class="row">
            <div class="span1">
              <a href="#" class="thumbnail">
                <img src="<?php echo $tempUser['pic'];?>" alt="">
              </a>
            </div>
            <div class="span6">
              <p><h4><strong><a href="?id=viewpost&pid=<?php echo $post['pid'];?>">View post</a></strong></h4></p>
            </div>
          </div>
            </br>
            <form action="index.php?id=admin&pid=<?php echo $post['pid'];?>" method="post">
              <li style="list-style: none;">
                <label class="control-label" for="delete"></label>
                <input id="delete" name="delete" type="text"
                placeholder="Type 'delete' to delete post" required autofocus>
              </li>
              <button type="submit" class="btn btn-primary">
                Delete
              </button>

            </form>
            <form method="post" action="index.php?id=admin&pid=<?php echo $post['pid'];?>">
            <input name="reset" class="robotic" value="reset"></input>
            <button type="submit" class="btn">Reset reports</button>
            </form>
          <hr>
          <?php
        }
      ?>
    </div>
    <div id="pane2" class="tab-pane">
      <?php
        $comments = getAllReportedComments();

        foreach($comments as $comment)
        {
          $tempUser = getUser($comment['uid']);
          ?>
          <div class="row">
            <div class="span4">
              <h4><strong><a href="#"><?php echo $tempUser['uname'];?></a></strong></h4>
            </div>
          </div>

          <div class="row">
            <div class="span1">
              <a href="#" class="thumbnail">
                <img src="<?php echo $tempUser['pic'];?>" alt="">
              </a>
            </div>
            <div class="span6">
              <p><?php echo $comment['content'];?></p>
            </div>
          </div>
            </br>
            <form action="index.php?id=admin&cid=<?php echo $comment['cid'];?>" method="post">
              <li style="list-style: none;">
                <label class="control-label" for="delete"></label>
                <input id="delete" name="delete" type="text"
                placeholder="Type 'delete' to delete post" required autofocus>
              </li>
              <button type="submit" class="btn btn-primary">
                Delete
              </button>
            </form>
            <form method="post" action="index.php?id=admin&cid=<?php echo $comment['cid'];?>">
            <input name="reset" class="robotic" value="reset"></input>
            <button type="submit" class="btn">Reset reports</button>
            </form>
          <hr>
          <?php
        }
      ?>

    </div>
    <div id="pane3" class="tab-pane">
    <h4>Users</h4>

    <?php $user->showUsers(); ?>


    </div>
    <div id="pane4" class="tab-pane">
      <h4>Settings</h4>
    </div>
    <div id="pane5" class="tab-pane">
      <h4>Ban appeals</h4>
      <div class="fb-comments" data-href="http://basketak.net/blog-cms/index.php?id=admin" data-width="970" data-num-posts="20"></div>
    </div>
  </div><!-- /.tab-content -->
</div><!-- /.tabbable -->

<?php } else { ?>
<p>What the <strong>heck</strong> are you doing here? You are not an admin!</p>
<?php } ?>
