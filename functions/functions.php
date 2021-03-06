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
    $sql = 'SELECT * FROM posts WHERE reports > "0" AND approved = "1"';
    $sth = $db->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll();
    $sth->closeCursor();
    return $result;
}

function deleteComment($commentId) { // set content of comment to "Deleted by admin"
    global $db;
    $sql = 'UPDATE comments SET approved = "0", content = "<strong>Deleted by admin</strong>" WHERE cid = :cid';
    $sth = $db->prepare($sql);
    $sth->bindParam(':cid', $commentId);
    $sth->execute();
    $sth->closeCursor();
}

function deletePost($postId) { // set content of post to "Deleted by admin"
    global $db;
    $sql = 'UPDATE posts SET approved = "0", title = "<em>Deleted by admin</em>", content = "<strong>Deleted by admin</strong>" WHERE pid = :pid';
    $sth = $db->prepare($sql);
    $sth->bindParam(':pid', $postId);
    $sth->execute();
    $sth->closeCursor();
}

function getAllReportedComments() { // gets all disapproved comments
    global $db;
    $sql = 'SELECT * FROM comments WHERE reports > "0" AND approved = "1"';
    $sth = $db->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll();
    $sth->closeCursor();
    return $result;
}

function resetReportsOnComment($commentId) {
    global $db;
    $sql = 'UPDATE comments SET reports = "0" WHERE cid = :cid';
    $sth = $db->prepare($sql);
    $sth->bindParam(':cid', $commentId);
    $sth->execute();
    $sth->closeCursor();
}

function resetReportsOnPost($postId) {
    global $db;
    $sql = 'UPDATE posts SET reports = "0" WHERE pid = :pid';
    $sth = $db->prepare($sql);
    $sth->bindParam(':pid', $postId);
    $sth->execute();
    $sth->closeCursor();
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
    $sql = 'SELECT * from comments WHERE pid=:pid';
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

function removeComment($cid, $admin) // changes the content to "Deleted by blog author / administrator"
{
    global $db;
    $sql = 'UPDATE comments SET content=:content, approved = 0 WHERE cid=:cid';
    $sth = $db -> prepare($sql);
    $sth -> bindParam(':cid', $cid);

    if($admin)
    {
        $content = '<em>Comment removed by administrator</em>';
    }
    else
    {
        $content = '<em>Comment removed by blog author</em>';
    }

    $sth -> bindParam(':content', $content);
    $sth -> execute();
    $sth -> closeCursor();
}

function reportCommentById($cid)    // Flags a comment as reported (incrementing the number of reports)
{
    global $db;
    $sql = 'UPDATE comments SET reports=reports + 1 WHERE cid=:cid';
    $sth = $db -> prepare($sql);
    $sth -> bindParam(':cid', $cid);
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


function updatePostViews($pid) {
    global $db;

    $sql = 'UPDATE posts SET visits=visits+1 WHERE pid=:pid';
    $sth = $db->prepare($sql);
    $sth->bindParam(':pid', $pid);
    $sth->execute();
    $sth->closeCursor();
}

function getTopPosts($weeks, $sort) {
    global $db;

    if($weeks == "1") {
        if($sort == "comments") {
            $sql = 'SELECT comments.pid, count(*), posts.title FROM comments JOIN posts on comments.pid = posts.pid WHERE posts.created >= ( CURDATE() - INTERVAL 7 DAY ) GROUP BY comments.pid ORDER BY count(*) desc, posts.title LIMIT 0,10';


        } else {
            $sql = 'SELECT title, pid FROM posts WHERE created >= ( CURDATE() - INTERVAL 7 DAY ) ORDER BY visits desc, title LIMIT 0,10';

        }

    } else if($weeks == "2") {
        if($sort == "comments") {
            $sql = 'SELECT comments.pid, count(*), posts.title FROM comments JOIN posts on comments.pid = posts.pid WHERE posts.created >= ( CURDATE() - INTERVAL 14 DAY ) GROUP BY comments.pid ORDER BY count(*) desc, posts.title LIMIT 0,10';

        } else {
            $sql = 'SELECT title, pid FROM posts WHERE created >= ( CURDATE() - INTERVAL 14 DAY ) ORDER BY visits desc, title LIMIT 0,10';

        }

    } else if($weeks == "3") {
        if($sort == "comments") {
            $sql = 'SELECT comments.pid, count(*), posts.title FROM comments JOIN posts on comments.pid = posts.pid WHERE posts.created >= ( CURDATE() - INTERVAL 21 DAY ) GROUP BY comments.pid ORDER BY count(*) desc, posts.title LIMIT 0,10';

        } else {
            $sql = 'SELECT title, pid FROM posts WHERE created >= ( CURDATE() - INTERVAL 21 DAY ) ORDER BY visits desc, title LIMIT 0,10';

        }

    } else if($weeks == "4") {
        if($sort == "comments") {
            $sql = 'SELECT comments.pid, count(*), posts.title FROM comments JOIN posts on comments.pid = posts.pid WHERE posts.created >= ( CURDATE() - INTERVAL 30 DAY ) GROUP BY comments.pid ORDER BY count(*) desc, posts.title LIMIT 0,10';

        } else {
            $sql = 'SELECT title, pid FROM posts WHERE created >= ( CURDATE() - INTERVAL 30 DAY ) ORDER BY visits desc LIMIT, title 0,10';

        }

    } else if($weeks == "all") {
        if($sort == "comments") {
            $sql = 'SELECT comments.pid, count(*), posts.title FROM comments JOIN posts on comments.pid = posts.pid GROUP BY comments.pid ORDER BY count(*) desc, posts.title LIMIT 0,10';

        } else {
            $sql = 'SELECT title, pid FROM posts ORDER BY visits desc, title LIMIT 0,10';

        }

    }

    $sth = $db -> prepare($sql);
    $sth -> execute();
    $result = $sth -> fetchAll();
    $sth -> closeCursor();
    return $result;
}

function getTopUsers($weeks, $sort) {
global $db;

    if($weeks == "1") {
        if($sort == "comments") {
            $sql = 'SELECT users.uid, count(*), uname FROM comments, posts, users WHERE comments.pid = posts.pid AND users.uid = posts.uid AND posts.created >= ( CURDATE() - INTERVAL 7 DAY ) GROUP BY users.uid ORDER BY count(*) desc, uname LIMIT 0,10';


        } else {
            $sql = 'SELECT visits,title, users.uid, uname FROM posts JOIN users ON posts.uid = users.uid WHERE created >= ( CURDATE() - INTERVAL 7 DAY ) GROUP BY users.uid ORDER BY visits desc, uname LIMIT 0,10';

        }

    } else if($weeks == "2") {
        if($sort == "comments") {
            $sql = 'SELECT users.uid, count(*), uname FROM comments, posts, users WHERE comments.pid = posts.pid AND users.uid = posts.uid AND posts.created >= ( CURDATE() - INTERVAL 14 DAY ) GROUP BY users.uid ORDER BY count(*) desc, uname LIMIT 0,10';

        } else {
            $sql = 'SELECT visits,title, users.uid, uname FROM posts JOIN users ON posts.uid = users.uid WHERE created >= ( CURDATE() - INTERVAL 14 DAY ) GROUP BY users.uid ORDER BY visits desc, uname LIMIT 0,10';

        }

    } else if($weeks == "3") {
        if($sort == "comments") {
            $sql = 'SELECT users.uid, count(*), uname FROM comments, posts, users WHERE comments.pid = posts.pid AND users.uid = posts.uid AND posts.created >= ( CURDATE() - INTERVAL 21 DAY ) GROUP BY users.uid ORDER BY count(*) desc, uname LIMIT 0,10';

        } else {
            $sql = 'SELECT visits,title, users.uid, uname FROM posts JOIN users ON posts.uid = users.uid WHERE created >= ( CURDATE() - INTERVAL 21 DAY ) GROUP BY users.uid ORDER BY visits desc, uname LIMIT 0,10';

        }

    } else if($weeks == "4") {
        if($sort == "comments") {
            $sql = 'SELECT users.uid, count(*), uname FROM comments, posts, users WHERE comments.pid = posts.pid AND users.uid = posts.uid AND posts.created >= ( CURDATE() - INTERVAL 30 DAY ) GROUP BY users.uid ORDER BY count(*) desc, uname LIMIT 0,10';

        } else {
            $sql = 'SELECT visits,title, users.uid, uname FROM posts JOIN users ON posts.uid = users.uid WHERE created >= ( CURDATE() - INTERVAL 30 DAY ) GROUP BY users.uid ORDER BY visits desc, uname LIMIT 0,10';

        }

    } else if($weeks == "all") {
        if($sort == "comments") {
            $sql = 'SELECT users.uid, count(*), uname FROM comments, posts, users WHERE comments.pid = posts.pid AND users.uid = posts.uid GROUP BY users.uid ORDER BY count(*) desc, uname LIMIT 0,10';

        } else {
            $sql = 'SELECT visits,title, users.uid, uname FROM posts JOIN users ON posts.uid = users.uid GROUP BY users.uid ORDER BY visits desc, uname LIMIT 0,10';

        }

    }

    $sth = $db -> prepare($sql);
    $sth -> execute();
    $result = $sth -> fetchAll();
    $sth -> closeCursor();
    return $result;

}

function getNumberOfComments($pid) {
    global $db;
    $sql = 'SELECT COALESCE(count(*), 0) as amount FROM comments, posts WHERE comments.pid = posts.pid AND comments.pid = :pid GROUP BY comments.pid';
   // $sql = 'SELECT count(*) as derp FROM comments, posts WHERE comments.pid = posts.pid AND comments.pid = :pid GROUP BY comments.pid';
    $sth = $db->prepare($sql);
    $sth->bindParam(':pid', $pid);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    $sth->closeCursor();
    return $result;
}

function setBanState($uid, $state) {
    global $db;
    $sql = 'UPDATE users SET banned=:state WHERE uid=:uid';
    $sth = $db->prepare($sql);
    $sth->bindParam(':uid', $uid);
    $sth->bindParam(':state', $state);
    $sth->execute();
    $sth->closeCursor();
}

function getBanState($uid) {
    global $db;
    $sql = 'SELECT banned FROM users WHERE uid=:uid';
    $sth = $db->prepare($sql);
    $sth->bindParam(':uid', $uid);
    $sth->execute();
    $result = $sth->fetchAll();
    $sth->closeCursor();

    return $result;
}

?>
