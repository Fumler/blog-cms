<?php
if($user->checkAdmin()) { ?>
<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#pane1" data-toggle="tab">Posts</a></li>
    <li><a href="#pane2" data-toggle="tab">Comments</a></li>
    <li><a href="#pane3" data-toggle="tab">Users</a></li>
    <li><a href="#pane4" data-toggle="tab">Settings</a></li>
    <li><a href="#pane5" data-toggle="tab">Chat</a></li>
  </ul>
  <div class="tab-content">
    <div id="pane1" class="tab-pane active">
      <h4>Posts that needs your attention</h4>
      <!-- Do stuff here -->
    </div>
    <div id="pane2" class="tab-pane">
      <h4>Comments</h4>
      <?php
        $comments = getAllDisapprovedComments();

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
      <h4>Chat</h4>
      <p>Future feature, admin chat</p>
    </div>
  </div><!-- /.tab-content -->
</div><!-- /.tabbable -->

<?php } else { ?>
<p>What the <strong>heck</strong> are you doing here? You are not an admin!</p>
<?php } ?>