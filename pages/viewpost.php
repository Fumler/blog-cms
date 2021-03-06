
<?php
    $pid = $_GET['pid'];
    $post = getPostById($pid);

    $userInfo = getUser($post['uid']);

    if(isset($_GET['pid'])) {
      updatePostViews($pid);
    }

  if(isset($_GET['delcom']))
  {
    $cid = $_GET['delcom'];
    $admin = $_GET['admin'];

    removeComment($cid, $admin);
  }

  if(isset($_GET['repcom']))
  {
    $cid = $_GET['repcom'];

    reportCommentById($cid);
  }
  if(isset($_POST['newcomment']))
  { 
    $privatekey = "6Lfc-N0SAAAAAPXPbstwKGqFcJj6gf0P2qK6xQHU";
    $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

    if (!$resp->is_valid) { 
      ?>
        <div class="alert alert-error">
          <button type="button" class="close" data-dismiss="success">&times;</button>
        <?php echo "<p><strong>Captcha failed!</strong></p>" ?>
        </div>
      <?php
    } else {
      $content = $_POST['newcomment'];
      createComment($content);
      $url = 'index.php?id=viewpost&pid=' .  $_GET['pid'];
      header( "Location: $url");
    }
  }
?>

<?php
    $owner = $userInfo['uid'] === $user -> getID();
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
            <?php if($post['updated'] != "0000-00-00 00:00:00")
            {
              ?>| <i class="icon-calendar"></i>Updated <?php echo $post['updated']; 
            }?>
             | <i class="icon-user"></i>Written by <a href="<?php echo '?id=profile&prid='.$userInfo['uid']; ?>"> <?php echo $userInfo['uname'];?> </a>
             <?php if($owner)
             {
                echo "| <i class='icon-pencil'></i><a href='?id=editpost&pid=$pid'>Edit post</a>";
                echo " | <i class='icon-trash'></i><a href='?removepost=$pid'>Remove post</a>";
             }
             else
             {
              echo " | <i class='icon-exclamation-sign'></i><a href='?reportpost=$pid'>Report post as innapropriate</a>";
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
              <h4><strong><a href="<?php echo '?id=profile&prid='.$tempUser['uid']; ?>"> <?php echo $tempUser['uname'];?> </a></strong></h4>
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
            <?php 
                $cid = $comment['cid'];
                $admin = $user -> checkAdmin();

                if($comment['approved'] == 1)
                {
                    if($owner || $user -> checkAdmin())
                    {
                      echo "<div class='span2'><i class='icon-trash'></i><a href='?id=viewpost&pid=$pid&delcom=$cid&admin=$admin'>Remove comment</a></div>";
                    }
                    else
                    {
                      echo "<div class='span2'><i class='icon-exclamation-sign'></i><a href='?id=viewpost&pid=$pid&repcom=$cid'>Report comment as innapropriate</a></div>";
                    }
                }
            ?>
          </div>
          <hr>
<?php
      }

      global $user;

      if($post['approved'] == 1)
      {
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
          echo "Comments have been disabled for this post!";
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