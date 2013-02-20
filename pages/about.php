<?php $page = "about";?>

<h1>Login form</h1>
<?php

$passwordderp = "1"."test".SALT;
$passwordsalted = hash_hmac('sha512', $passwordderp, SITEKEY);
echo $passwordsalted;
?>