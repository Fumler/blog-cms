<?php
if($user->loggedOn()) {
  $userPosts = $user->showPosts($user->getID());
  $userInfo = $user->showUser($user->getID());


  if(count($userPosts > 0)) {

    foreach($userPosts as $row) {
      echo '<div class="media">';
      echo '<a class="pull-left" href="#">';
      echo '<img class="media-object" src="'.$userInfo['pic'].'">';
      echo '</a>';
      echo '<div class="media-body">';
      echo '<h4 class="media-heading">'.$row['title'].'</h4>';
      echo '<p>'.$row['content'].'</p>';
      echo '</div>';
      echo '</div>';
    }
  } else {
    echo '<h4>You have no posts</h4>';
  }


} else {
  $posts = getAllPosts();


  if(count($posts) > 0) {

    foreach($posts as $row) {
      $pic = getUser($row['uid']);
      echo '<div class="media">';
      echo '<a class="pull-left" href="#">';
      echo '<img class="media-object" src="'.$pic['pic'].'">';
      echo '</a>';
      echo '<div class="media-body">';
      echo '<h4 class="media-heading">'.$row['title'].'</h4>';
      echo '<p>'.$row['content'].'</p>';
      echo '</div>';
      echo '</div>';
    }

  } else {
    echo '<h4>There are no posts</h4>';
  }
}

//   <div class="media">
//   <a class="pull-left" href="#">
//     <img class="media-object" src="$row['pic']">
//   </a>
//   <div class="media-body">
//     <h4 class="media-heading"></h4>
//     <p></p>
//   </div>
// </div>

?>


