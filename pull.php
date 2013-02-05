<?php
ini_set('display_errors', 'On');

$projectName	= 'blog-cms'; // Your project name
$email			= 'fredrik.fumler@gmail.com'; // Email address you want pull notifcations to go to

// Copy and paste the results from `passgen` here
$pass = '61d5df9c5c71b1e2e0a000fad2b66f41';
$salt = '1984595830';
// End copy and paste


// Don't need to edit these lines
$remoteIP	= $_SERVER['REMOTE_ADDR'];
$msg		= 'Request came form '.$remoteIP.' - http://whois.arin.net/rest/ip/'.$remoteIP;



if (isset($_GET['update'])) {

	// We want to update the folder with the latest from the repo

	$check = md5(crypt($_GET['update'], $salt));

	if ($pass === $check) {

		// what does the pull, don't change the backticks (`) as it tells PHP to execute a shell command
		`git pull --rebase`;
		echo "Pass is okay";

		// Email to say it's successful
		mail($email, '['.$projectName.'] `GIT PULL` successful', $msg);

	} else {

		// Email to say the pull failed (due to wrong pass)
		mail($email, '['.$projectName.'] `GIT PULL` password fail', $msg);

	}

} elseif (isset($_GET['passgen'])) {

	// We want to generate a salt and password

	$password	= $_GET['passgen'];
	$randSalt	= (string)rand();
	$generate	= crypt($password, $randSalt);
	$genPass	= md5($generate);

	$html = '<body style="width: 70%; margin: 20px auto; text-align: center; font-family: arial; line-height: 3em">';

	$html .= '<p><label>Add the following code to <code>'.$_SERVER['SCRIPT_FILENAME'].'</code><br /><textarea cols="50" rows="2" style="padding: 10px">';
	$html .= '$salt = \''.$randSalt.'\';'."\n";
	$html .= '$pass = \''.$genPass.'\';';
	$html .= '</textarea></label></p>';

	$callURL = 'http';
	if (isset($_SERVER['HTTPS']))	$callURL .= 's';
	$callURL .= '://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'].'?update='.$_GET['passgen'];

	$html .= '<p><label>Add this URL your project\'s "Post-Recieve URLs"<br /><input type="text" value="'.$callURL.'" style="width: 500px; text-align: center;" /></label></p>';

	echo $html;

} else {
	mail($email, '['.$projectName.'] `GIT PULL` failed', $msg);
}
