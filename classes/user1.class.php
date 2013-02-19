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
	var $db = new PDO('mysql:host=localhost;dbname=blog', $_SERVER['DBUSER'], $_SERVER['DBPASS']);		// Handle to the database object

	/**
	 * Constructor for the class, handles login/logout and carry forward of login status.
	 * Uses global variables _POST and _SESSION, reads uname/pwd from _POST and writes uid to _SESSION
	 *
	 * @param PDO database handler $db
	 */
	function User ($db) {
		global $_POST, $_SESSION;
		$this->db = $db;										// Store a reference to the database handler
		if (isset ($_POST['uname'])) {							// Try to log in
			$this->uname = $_POST['uname'];
			$sql = 'SELECT * FROM users WHERE uname=:uname';
			$sth = $db->prepare ($sql);
			$sth->bindParam (':uname', $this->uname);
			$sth->execute ();
			if ($row = $sth->fetch()) {							// User name found, we can check the password
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
																// Password stored as sha512 hash
				$sth->bindParam (':pwd', hash_hmac('sha512', $pwd, SITEKEY));
				$sth->execute ();
				if ($row = $sth->fetch()) {						// Password found, set _SESSION value
					$this->uid = $row['uid'];
					$_SESSION['uid'] = $this->uid;
					return;
				}
			}
			$this->error = 'Ukjent brukernavn/passord';			// Display error message on login form
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
		$this->db->beginTransaction();							// Run in a transaction so that we can do a rollback
		$this->db->query ('LOCK TABLES users WRITE');			// Prevent others from creating a new user at the same time
		$sql = 'INSERT INTO users (uname) VALUES (:uname)';
		$sth = $this->db->prepare ($sql);
		$sth->bindParam (':uname', $uname);
		$sth->execute ();
		if ($sth->rowCount()==0) {								// No user created, probably because the user name is not unique
			$this->db->rollBack();								// Rollback (well, nothing has been done :)
			$this->db->query ('UNLOCK TABLES');					// Unlock the tables
			throw new Exception ('User name already taken');	// Throw exception
		}
		$sth->closeCursor();									// Prepare to find the id of the new user
		$sth = $this->db->prepare ('SELECT LAST_INSERT_ID() AS uid');
		$sth->execute();
		if ($row = $sth->fetch())								// uid found
			$uid = $row['uid'];
		else {													// uid not found
			$this->db->rollBack();								// Rollback, remove the user
			$this->db->query ('UNLOCK TABLES');
			throw new Exception ('Error getting new user id');	// Throw an exception
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
			throw new Exception ('Unable to set new password');	// Throw an exception
		}
		$this->db->commit();
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
}

$user = new User ($db);											// Create a new object of the User class
if (isset ($needLogin) && !$user->loggedOn())					// check login statuss
	die ('You need to be logged on to do this!');

?>
