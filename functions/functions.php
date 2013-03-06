<?php

function getAllPosts() { // gets every post
    global $db;
    $sql = 'SELECT * FROM posts ORDER BY created desc';
    $sth = $db->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll();
    $sth->closeCursor();
    return $result;
}

function getApprovedPosts($uid) { // gets all approved posts by specific user
    global $db;
    $sql = 'SELECT * FROM posts WHERE approved = "1" AND uid=:uid ORDER BY created desc';
    $sth = $db->prepare($sql);
    $sth->bindParam(':uid', $uid);
    $sth->execute();
    $result = $sth->fetchAll();
    $sth->closeCursor();
    return $result;
}

function getDisapprovedPosts($uid) { // gets all disapproved posts by specific user
    global $db;
    $sql = 'SELECT * FROM posts WHERE approved = "0" AND uid=:uid ORDER BY created desc';
    $sth = $db->prepare($sql);
    $sth->bindParam(':uid', $uid);
    $sth->execute();
    $result = $sth->fetchAll();
    $sth->closeCursor();
    return $result;
}

function getAllReportedPosts() { // gets all disapproved posts
    global $db;
    $sql = 'SELECT * FROM posts WHERE reports > "0"';
    $sth = $db->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll();
    $sth->closeCursor();
    return $result;
}

function deleteComment($commentId) { // set content of comment to "Deleted by admin"
    global $db;
    $sql = 'UPDATE posts SET content = "Deleted by admin", approved = "0" WHERE cid = :commentId';
    $sth = $db->prepare($sql);
    $sth->bindParam(':cid', $commentId);
    $sth->execute();
    $sth->closeCursor();
}

function getAllReportedComments() { // gets all disapproved comments
    global $db;
    $sql = 'SELECT * FROM comments WHERE reports > "0"';
    $sth = $db->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll();
    $sth->closeCursor();
    return $result;
}

function getUser($uid) { // gets info about a specific user
    global $db;
    $sql = 'SELECT * FROM users WHERE uid=:uid';
    $sth = $db->prepare($sql);
    $sth->bindParam(':uid', $uid);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    $sth->closeCursor();
    return $result;
}

function getPosts($uid) // gets all posts from a specific user, sorted by date
{
    global $db;
    $sql = 'SELECT * FROM posts WHERE uid=:uid ORDER BY created desc';
    $sth = $db->prepare($sql);
    $sth->bindParam(':uid', $uid);
    $sth->execute();
    $result = $sth->fetchAll();
    $sth->closeCursor();
    return $result;
}

function getPostById($pid) // gets a blogpost based on the unique post ID. 
{
    global $db;
    $sql = 'SELECT * FROM posts WHERE pid=:pid';
    $sth = $db -> prepare($sql);
    $sth -> bindParam(':pid', $pid);
    $sth -> execute();
    $result = $sth -> fetch( PDO::FETCH_ASSOC );
    $sth -> closeCursor();
    return $result;
}

function getCommentsByPostId($pid) // gets all comments on a certain blog post. 
{
    global $db;
    $sql = 'SELECT * from comments WHERE approved=1 AND pid=:pid';
    $sth = $db -> prepare($sql);
    $sth -> bindParam(':pid', $pid);
    $sth -> execute();
    $result = $sth -> fetchAll();
    $sth -> closeCursor();
    return $result;
}

function deletePostById($pid)   // Removes a blog post (Used to delete own posts)
{
    global $db;
    $sql = 'DELETE FROM posts WHERE pid=:pid';
    $sth = $db -> prepare($sql);
    $sth -> bindParam(':pid', $pid);
    $sth -> execute();
    $sth -> closeCursor();
}

function reportPostById($pid)  // Reports a pos (increments the counter). 
{
    global $db;
    $sql = 'UPDATE posts SET reports=reports + 1 WHERE pid=:pid';
    $sth = $db -> prepare($sql);
    $sth -> bindParam(':pid', $pid);
    $sth -> execute();
    $sth -> closeCursor();
}

function makeAdmin($uid) 
{
    global $db;
    global $user;
    
    $db->beginTransaction();
    $db->query ('LOCK TABLES users WRITE');
    $sql = 'UPDATE users SET admin="1" WHERE uid=:uid';
    $sth = $db->prepare($sql);
    $sth->bindParam(':uid', $uid);
    $sth->execute();
    
    if($sth->rowCount() == 0) 
    {
        $db->rollBack();
        $db->query('UNLOCK TABLES');
        $user->error = "<strong>Oh snap!</strong> He simply cannot be an admin! (He probably is one already?)";
    }
    
    $result = $sth->fetchAll();
    $sth->closeCursor();
    $db->commit();
    $user->success = "<strong>Success!</strong> Your pal is now an admin!";
}

// function getBlog($uid) {
//     global $db;
//     $sql = 'SELECT * FROM users, posts WHERE users.uid=:uid AND users.uid = posts.uid';
//     $sth = $db->prepare($sql);
//     $sth->bindParam(':uid', $uid);
//     $sth->execute();
//     $result = $sth->fetchAll();
//     $sth->closeCursor();
//     return $result;
// }

?>