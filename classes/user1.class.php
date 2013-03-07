<?php
define ('SALT', 'abc!"#$%&kjhG');
define ('SITEKEY', 'ASiteSpecificArbitraryLengthStringThatIsUsedToSeedTheHashingAlgorithm');

/**
 * This class handles all user handling operations, login state, login/logout, new user creation, changing password.
 * This class also provides login status, and for logged in users you can query userid and username.
 *
 * @author oivindk
 *
 */
class User {
	var $uname = '';											// User name for currently logged in user
	var $uid = -1;												// User ID for currently logged in user
	var $error = '';											// Error in login
	var $db;													// Handle to the database object
	var $success = '';										// Success messages

	/**
	 * Constructor for the class, handles login/logout and carry forward of login status.
	 * Uses global variables _POST and _SESSION, reads uname/pwd from _POST and writes uid to _SESSION
	 *
	 * @param PDO database handler $db
	 */
	function User ($db) {
		global $_POST, $_SESSION;
		$this->db = $db;										// Store a reference to the database handler
		if (isset ($_POST['uname'])) 
		{														// Try to log in
			$this->uname = $_POST['uname'];
			$sql = 'SELECT * FROM users WHERE uname=:uname';
			$sth = $db->prepare ($sql);
			$sth->bindParam (':uname', $this->uname);
			$sth->execute ();

			if ($row = $sth->fetch()) // User name found, we can check the password
			{							
				$uid = $row['uid'];
				$sth->closeCursor();
				$sql = 'SELECT * FROM users WHERE uid=:uid AND pwd=:pwd';
				$sth = $db->prepare ($sql);
				$sth->bindParam (':uid', $uid);
				$pwd = $uid.$_POST['pwd'].SALT;					// Create password with uid and SALT value
				// Show possible hash algorithms
				// print_r(hash_algos());
				// Output the hash value, usefull for debuging
				// echo hash_hmac('sha512', $pwd, SITEKEY);
				
				$hash = hash_hmac('sha512', $pwd, SITEKEY);
				//echo $hash;

				if(isset($_POST['remember']) && $_POST['uname'] == $_COOKIE['uname'])
				{
					if(isset($_COOKIE['pwd']))
					{
						$hash = $_COOKIE['pwd'];
					}
				}												// Password stored as sha512 hash

				$sth->bindParam (':pwd', $hash);
				$sth->execute ();

				$_POST['remember'] = (int)$_POST['remember'];

				if ($row = $sth->fetch())  // Password found, set _SESSION value
				{
					$hour = time() + (60 * 60); // 2 weeks
					$this->uid = $row['uid'];
					$_SESSION['uid'] = $this->uid;
					$_SESSION['remember'] = $_POST['remember'];

					if(isset($_POST['remember']))
					{
						setcookie('uname', $_POST['uname'], $hour);
						setcookie('pwd', $hash, $hour);
						setcookie('blogRemember', $_POST['uname'], $hour * 24 * 7 * 52); // year.. 
					}
					else
					{
						if(isset($_COOKIE['blogRemember']))
						{
							$past = time() - 100;
							setcookie(blogRemember, gone, $past);
						}
					}
					
					return;
				}
			}
			$this->error = '<strong>Oh snap!</strong> Your username or password seems to be wrong, try again.';			// Display error message on login form
		} else if (isset ($_POST['logout'])) {					// Log out
			unset ($_SESSION['uid']);
		} else if (isset ($_SESSION['uid'])) {					// A user is logged in, find the username
			$this->uid = $_SESSION['uid'];
			$sql = 'SELECT * FROM users WHERE uid=:uid';
			$sth = $db->prepare ($sql);
			$sth->bindParam (':uid', $_SESSION['uid']);
			$sth->execute ();
			$row = $sth->fetch();
			$this->uname = $row['uname'];
		}
	}

	/**
	 * Method to create a new user
	 *
	 * @param String $uname must be unique for all users
	 * @param String $pwd no restrictions on the password
	 * @throws Exception if not unique password, if unable to get the id of the new user or if the password can not be changed
	 * Only the first should occure.
	 */
	function newUser ($uname, $pwd) {
		try {
		$this->db->beginTransaction();							// Run in a transaction so that we can do a rollback
		$this->db->query ('LOCK TABLES users WRITE');			// Prevent others from creating a new user at the same time
		$sql = 'INSERT INTO users (uname) VALUES (:uname)';
		$sth = $this->db->prepare ($sql);
		$sth->bindParam (':uname', $uname);
		$sth->execute ();
		if ($sth->rowCount()==0) {							// No user created, probably because the user name is not unique
			$this->db->rollBack();								// Rollback (well, nothing has been done :)
			$this->db->query ('UNLOCK TABLES');					// Unlock the tables
			throw new Exception('<strong>Oh snap!</strong> User name is taken! Try again.');	// Throw exception
		}
		$sth->closeCursor();									// Prepare to find the id of the new user
		$sth = $this->db->prepare ('SELECT LAST_INSERT_ID() AS uid');
		$sth->execute();
		if ($row = $sth->fetch())								// uid found
			$uid = $row['uid'];
		else {													// uid not found
			$this->db->rollBack();								// Rollback, remove the user
			$this->db->query ('UNLOCK TABLES');
			throw new Exception('<strong>Oh snap!</strong> Something went wrong. Try again.');	// Throw an exception
		}
		$sth->closeCursor ();
		$sql = 'UPDATE users SET pwd=:pwd WHERE uid=:uid';		// Set the password for the new user
		$sth = $this->db->prepare ($sql);
		$sth->bindParam (':uid', $uid);
		$pwd = $uid.$pwd.SALT;									// Create the password and create the hash value
		$sth->bindParam (':pwd', hash_hmac('sha512', $pwd, SITEKEY));
		$sth->execute();										// Run the query
		if ($sth->rowCount()==0) {								// No password set
			$this->db->rollBack();								// Remove the user
			$this->db->query ('UNLOCK TABLES');
			throw new Exception('<strong>Oh snap!</strong> Something went wrong. Try again.');	// Throw an exception
		}
		$this->db->commit();
		$this->success = "<strong>Congrats!</strong> You are now registered as " . $uname . ". Please log in.";
	} catch(Exception $e) {
				$this->error = $e->getMessage();
			}

	}

	/**
	 * Change the password for the currently logged in user, need both the old and the new password.
	 * No checks are made on the passwords, ie. you can set a blank password.
	 *
	 * @param String $oldpwd the current password
	 * @param String $pwd the new password
	 * @throws Exception thrown if the current password doesn´t match the one given
	 */
	function changePassword ($oldpwd, $pwd) {
		$sql = 'UPDATE users SET pwd=:pwd WHERE uid=:uid AND pwd=:oldpwd';
		$sth = $this->db->prepare ($sql);
		$sth->bindParam (':uid', $this->getID());				// Change the password for the currently logged in user
		$pwd = $this->getID().$pwd.SALT;						// The new password
		$sth->bindParam ('pwd', hash_hmac('sha512', $pwd, SITEKEY));
		$oldpwd = $this->getID().$oldpwd.SALT;					// The old/current password
		$sth->bindParam ('oldpwd', hash_hmac('sha512', $oldpwd, SITEKEY));
		$sth->execute ();
		if ($sth->rowCount()==0) {								// If no rows affected then the old password was probably wrong
			throw new Exception ('Unable to change password');
		}
		$sth->closeCursor();									// Always close all cursors
	}

	/**
	 * Method used to check if a user is logged in.
	 *
	 * @return boolean true if a user is logged in, otherwise returns false
	 */
	function loggedOn () {
		if ($this->uid > -1)									// User ID > -1 means a user is logged in
			return true;
		else
			return false;
	}

	/**
	 * Method used to get the user name for the currently logged in user
	 *
	 * @return string|NULL return a string with the username if a user is logged in, otherwise NULL is returned
	 */
	function getName () {
		if ($this->loggedOn())									// Check to see if a user is logged in
			return $this->uname;
		else
			return null;
	}

	/**
	 * Method used to get the user id for the currently logged in user
	 *
	 * @return number|NULL return the user id if a user is logged in, otherwise NULL is returned
	 */
	function getID () {
		if ($this->loggedOn())									// Check to see if a user is logged in
			return $this->uid;
		else
			return null;
	}

	/**
	 * Return a textstring with the HTML code for creating a log in/log out form.
	 * If no user is logged in, a log in form is returned (with an error message if a previous
	 * login attempt failed.)
	 * If a user is logged in a log out form (with just a log out button) is returned.
	 *
	 * @return string a log in/log out form created with HTML. Use CSS to style the form.
	 */
	function getLoginForm () {
		if ($this->loggedOn())									// Is a user logged in
			return "<form method='post' action='{$_SERVER['REQUEST_URI']}'>\n
			<input type='hidden' name='logout' value='true'/>\n
			<input type='submit' value='Logg av'/>\n</form>";
		else													// No user is logged in
			return "<form method='post' action='{$_SERVER['REQUEST_URI']}'>$this->error\n
			<label for='uname'>Brukernavn</label><input type='text' name='uname'><br/>\n
			<label for='pwd'>Passord</label><input type='password' name='pwd'><br/>\n
			<input type='submit' value='Logg på'/>\n</form>";
	}

	// Functions added by us
	function showUsers() {


	echo '<table class="table table-hover">';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Username</th>';
    echo '<th>First Name</th>';
    echo '<th>Last Name</th>';
    echo '<th>Email</th>';
    echo '<th>Approved Posts</th>';
    echo '<th>Disapproved posts</th>';
    echo '<th>Admin</th>';
    echo '<th>Status</th>';
    echo '</tr>';

    $result = $this->db->query('SELECT * FROM users');


		foreach($result->fetchAll() as $row) {
			$aPosts = getApprovedPosts($row['uid']);
    		$dPosts = getDisapprovedPosts($row['uid']);
			echo "<tr>";
			echo "<td>".$row['uid']."</td>";
			echo '<td><a href="?id=profile&prid='.$row['uid'].'">'.$row['uname'].'</a></td>';
			echo "<td>".$row['fname']."</td>";
			echo "<td>".$row['lname']."</td>";
			echo "<td>".$row['email']."</td>";
			echo "<td>".count($aPosts)."</td>";
			echo "<td>".count($dPosts)."</td>";
			if($row['admin'] == 1) {
				echo '<td>Yes</td>';
			} else {
				echo '<td>No <a href="?setAdmin='.$row['uid'].'">(Make admin)</a></td>';
			}
			if($row['banned'] == 0) {
				echo '<td>No <a href="?banUser='.$row['uid'].'">(Ban)</a></td>';
			} else {
				echo '<td>Yes <a href="?unbanUser='.$row['uid'].'">(Unban)</a></td>';
			}
			echo "</tr>";

		}
		$result->closeCursor();

     //  echo '</tr>';
     //  echo '<tr>';
     //  echo '<td>row 1, cell 1</td>';
     //  echo '<td>row 1, cell 2</td>';
     //  echo '</tr>';
     //  echo '<tr>';
     //  echo '<td>row 2, cell 1</td>';
     //  echo '<td>row 2, cell 2</td>';
     //  echo '</tr>';
    echo '</table>';

	}

	function updatePic($uid, $pic) {
		$sql = 'UPDATE users SET pic=:pic WHERE uid=:uid';
		$sth = $this->db->prepare($sql);
		$sth->bindParam(':uid', $uid);
		$sth->bindParam(':pic', $pic);
		$sth->execute();

		if ($sth->rowCount() == 0) {
			throw new Exception('Query failed');
		}

		$sth->closeCursor();
	}

	function updateUser($uid, $fname, $lname, $email, $address, $info) {
		$sql = 'UPDATE users SET fname=:fname, lname=:lname, email=:email, address=:address, info=:info WHERE uid=:uid';
		$sth = $this->db->prepare($sql);
		$sth->bindParam(':uid', $uid);
		$sth->bindParam(':fname', $fname);
		$sth->bindParam(':lname', $lname);
		$sth->bindParam(':email', $email);
		$sth->bindParam(':address', $address);
		$sth->bindParam(':info', $info);
		$sth->execute();

		if ($sth->rowCount() == 0) {
			throw new Exception('Query failed');
		}

		$sth->closeCursor();
	}

	function showUser($uid) {
		$sql = 'SELECT * FROM users WHERE uid=:uid';
    	$sth = $this->db->prepare($sql);
    	$sth->bindParam(':uid', $uid);
    	$sth->execute();
    	$result = $sth->fetch(PDO::FETCH_ASSOC);
    	$sth->closeCursor();
    	return $result;
	}



	function checkAdmin () { // Checks if user is admin
		$sql = 'SELECT * FROM users WHERE uid=:uid AND admin="1"';
		$sth = $this->db->prepare ($sql);
		$sth->bindParam (':uid', $this->getID());
		$sth->execute ();
		if ($sth->rowCount()==0) {
			return false;
		} else {
			return true;
		}
		$sth->closeCursor();
	}

	function showPosts($uid)
	{
		$sql = 'SELECT * FROM posts WHERE uid=:uid ORDER BY created desc';
		$sth = $this->db->prepare($sql);
		$sth->bindParam(':uid', $uid);
		$sth->execute();
		$result = $sth->fetchAll();
		$sth->closeCursor();

		return $result;
	}



}

$user = new User ($db);											// Create a new object of the User class
if (isset ($needLogin) && !$user->loggedOn())					// check login statuss
	die ('You need to be logged on to do this!');


?>
