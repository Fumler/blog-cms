<div>
 <legend>Profile</legend>
</div>

<?php
  $uid = $_GET['prid'];
  $posts = getPosts($uid);
  $userInfo = getUser($uid);
  $edit = false;

  // Maximum filesize - 300kb
  define ("MAX_SIZE","300");

  // returns the extension of a file.
  function getExtension($str) {
    $i = strrpos($str,".");
    if (!$i) { return ""; }
    $l = strlen($str) - $i;
    $ext = substr($str,$i+1,$l);
    return $ext;
  }

  if ($uid == $user->uid) {
    $edit = true;
  }

  $errors = 0;
  $newname = "";

  if(isset($_POST['Submit'])) {
    $image=$_FILES['image']['name'];

    if ($image) {
      $filename = stripslashes($_FILES['image']['name']);
      $extension = getExtension($filename);
      $extension = strtolower($extension);

      if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
        ?>
        <div class="alert alert-error">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <?php echo "<p><strong>Invalid extension!</strong></p>" ?>
        </div>
        <?php
        $errors=1;
      }
      else {
        $size=filesize($_FILES['image']['tmp_name']);

        if ($size > MAX_SIZE*1024) {
          ?>
          <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo "<p><strong>Filesize has been exceeded!</strong></p>" ?>
          </div>
          <?php
          $errors=1;
        }

        $image_name=time().'.'.$extension;
        $newname="img/".$image_name;
        $copied = copy($_FILES['image']['tmp_name'], $newname);

        if (!$copied) {
          ?>
          <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo "<p><strong>Copying was unsuccessful. Try again</strong></p>" ?>
          </div>
          <?php
          $errors=1;
        }
      }
    }
  }

  if(isset($_POST['Submit']) && !$errors)  {
    ?>
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <?php echo "<p><strong>Upload successful!</strong></p>" ?>
    </div>
    <?php

    $user->updatePic($uid, $newname);

  }


  if (isset($_POST['oldPwd']) && strlen($_POST['oldPwd']) != 0) {
    if ((isset($_POST['newPwd']) && isset($_POST['newPwdA'])) && strlen($_POST['newPwd']) != 0) {
      if ($_POST['newPwd'] === $_POST['newPwdA']) {
        $user->changePassword($_POST['oldPwd'], $_POST['newPwd']);
      } else {
        ?>
          <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
          <?php echo "<p><strong>Your passwords do not match</strong></p>" ?>
          </div>
        <?php
      }
    }
  }

  if (isset($_POST['fname']) || isset($_POST['lname']) || isset($_POST['email']) || isset($_POST['address']) || isset($_POST['info'])) {
    $user->updateUser($uid, $_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['address'], $_POST['info']);
  }

  ?>

  <label>Picture</label>
  <img src=<?php echo $userInfo['pic']; ?> width="150">

  <?php if($edit) 
  {
    ?>
    <form name="newad" method="post" enctype="multipart/form-data" action="">
      <table>
        <tr><td><input type="file" name="image"></td></tr>
        <tr><td><input class="btn btn-primary" name="Submit" type="submit" value="Upload image"></td></tr>
      </table>
    </form>

    <?php
  }
 ?>

  <!-- every form except username checks to see if they can be edited -->
  <form method="post" action=<?php echo "index.php?id=profile" . "&prid=$uid" ?>>
    <label>Username</label>
    <input type="text" value="<?php echo $userInfo['uname']; ?>" class="input-xlarge" disabled>
    <label>First Name</label>
    <input name="fname" type="text" value="<?php echo $userInfo['fname']; ?>" class="input-xlarge" <?php if (!$edit && !($user->checkAdmin())) { ?> disabled <?php } ?>>
    <label>Last Name</label>
    <input name="lname" type="text" value="<?php echo $userInfo['lname']; ?>" class="input-xlarge" <?php if (!$edit && !($user->checkAdmin())) { ?> disabled <?php } ?>>
    <label>Email</label>
    <input name="email" type="text" value="<?php echo $userInfo['email']; ?>" class="input-xlarge" <?php if (!$edit && !($user->checkAdmin())) { ?> disabled <?php } ?>>
    <label>Address</label>
    <input name="address" type="text" value="<?php echo $userInfo['address']; ?>" class="input-xlarge" <?php if (!$edit && !($user->checkAdmin())) { ?> disabled <?php } ?>>
    <label>Info</label>
    <input name="info" type="text" value="<?php echo $userInfo['info']; ?>" class="input-xlarge" <?php if (!$edit && !($user->checkAdmin())) { ?> disabled <?php } ?>>
  </form>

  <form method="post" action=<?php echo "index.php?id=profile" . "&prid=$uid" ?>>
    <!-- Check to see if the user can change password-->
    <?php if ($edit) { ?>
      <legend>Password</legend>
      <label>Old password</label>
      <input name="oldPwd" type="password" class="input-xlarge">
      <label>New password</label>
      <input name="newPwd" type="password" class="input-xlarge">
      <label>Again</label>
      <input name="newPwdA" type="password" class="input-xlarge">
    <?php } ?>

    <?php if ($edit || $user->checkAdmin()) { ?>
      <div>
        <button class="btn btn-primary" type="submit">Update</button>
      </div>
    <?php } ?>
  </form>

    <div class="row">
    <div class="span8">
        <legend><br />Posts</legend>
    </div>
</div>


<?php

foreach($posts as $row) { ?>
      <div class="row">
        <div class="span8">
          <div class="row">
            <div class="span8">
              <h4><strong><a href="<?php echo '?id=viewpost&pid=' . $row["pid"];?>"><?php echo $row['title'];?></a></strong></h4>
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
              </p>
            </div>
          </div>
        </div>
      </div>
<?php } ?>