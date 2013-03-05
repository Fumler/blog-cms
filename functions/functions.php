<?php

function getAllPosts() {
    global $db;
    $sql = 'SELECT * FROM posts ORDER BY created desc';
    $sth = $db->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll();
    $sth->closeCursor();
    return $result;
}

function getApprovedPosts($uid) {
    global $db;
    $sql = 'SELECT * FROM posts WHERE approved = "1" AND uid=:uid ORDER BY created desc';
    $sth = $db->prepare($sql);
    $sth->bindParam(':uid', $uid);
    $sth->execute();
    $result = $sth->fetchAll();
    $sth->closeCursor();
    return $result;
}

function getDisapprovedPosts($uid) {
    global $db;
    $sql = 'SELECT * FROM posts WHERE approved = "0" AND uid=:uid ORDER BY created desc';
    $sth = $db->prepare($sql);
    $sth->bindParam(':uid', $uid);
    $sth->execute();
    $result = $sth->fetchAll();
    $sth->closeCursor();
    return $result;
}

function getUser($uid) {
    global $db;
    $sql = 'SELECT * FROM users WHERE uid=:uid';
    $sth = $db->prepare($sql);
    $sth->bindParam(':uid', $uid);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    $sth->closeCursor();
    return $result;
}

?>