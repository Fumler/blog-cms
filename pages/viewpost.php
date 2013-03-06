
<?php
    $pid = $_GET['pid'];
    $post = getPostById($pid);

    $userInfo = getUser($post['uid']);

    if(isset($_GET['pid'])) {
      updatePostViews($pid);
    }


  if(isset($_POST['newcomment']))
  {
    $content = $_POST['newcomment'];
    createComment($content);
    $url = 'index.php?id=viewpost&pid=' .  $_GET['pid'];
    header( "Location: $url");
  }
?>

<?php
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
             <?php if($userInfo['uid'] === $user -> getID())
             {
                echo "- <i class='icon-trash'></i><a href='?removepost=$pid'>Remove post</a>";
             }
             else
             {
              echo "- <i class='icon-exclamation-sign'></i><a href='?reportpost=$pid'>Report post innapropriate</a>";
             }
             ?>
          </p>
        </div>
      </div>


      <legend>
          Comments
      </legend>
    <?php

      $comments = getCommentsByPostId($pid);

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
          <hr>
<?php
      }

      global $user;

      if($user -> loggedOn())
      {
          include('pages/comment.php');
      }
      else
      {
        echo "Please log in to comment!";
      }

    }
    else
    {
      echo "We're sorry, but the post was not found!";
    }
?>

<?php
  function createComment($content)
  {
    global $db, $user, $pid;
    $sql = 'INSERT INTO comments (content, created, pid, uid) '
      . 'VALUES ( :content, now(), :pid , :uid)';
    $sth =  $db -> prepare ($sql);
    $sth -> bindParam (':content', $content);
    $sth -> bindParam (':uid', $user -> getId());
    $sth -> bindParam (':pid', $pid);

    $sth -> execute();
    $sth -> closeCursor();

    ?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo "<p><strong>Your comment have been created</strong></p>" ?>
      </div>
    <?php
  }
?>