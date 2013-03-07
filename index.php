<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<?php
session_start();
// vars
try {
$indexDb = new PDO('mysql:host=localhost;dbname=blog;charset=UTF8', $_SERVER['DBUSER'], $_SERVER['DBPASS']);
$db = $indexDb;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

// includes
require_once('classes/user1.class.php');
include('functions/functions.php');
require_once('functions/recaptchalib.php');

// if id has a value, get it, if not set to home
$id = isset($_GET['id']) ? $_GET['id'] : 'home';

// logout
if(isset($_GET['logout'])) {
    session_unset();
    session_destroy();

    header('Location: '.$_SERVER['PHP_SELF']);
}

// set top lists sorting
if(!isset($_POST['weeks']) && !isset($_POST['sort'])) {
    $_POST['weeks'] = "2";
    $_POST['sort'] = "views";
}

// make admin
if(isset($_GET['setAdmin'])) {
    makeAdmin($_GET['setAdmin']);
}

// remove post
if(isset($_GET['removepost']))
{
    $pid = $_GET['removepost'];

    deletePostById($pid);
}

// report post
if(isset($_GET['reportpost']))
{
    $pid = $_GET['reportpost'];

    reportPostById($pid);
}

// register a new user
if(isset($_POST['regUser']) && isset($_POST['regPwd']) && isset($_POST['regConfirmPwd']))
{
    if($_POST['regPwd'] == $_POST['regConfirmPwd'] )
    {
        $robotest = $_POST['robotest'];
        if(!$robotest)
        {
            $user->newUser($_POST['regUser'], $_POST['regPwd']);
        }
        else
        {
            $user->error = "ROBOT";
        }
    }
    else
    {
        $user->error = "<strong>Oh snap!</strong> The passwords don't match!";
    }
}

// checks user login
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Open source blogging system (CMS)">
        <meta name="keywords" content="cms blog content managment system blogging">
        <title>Blog CMS</title>
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/custom.css" media="all">
        <link rel="stylesheet" type="text/css" href="css/bootstrap-wysihtml5-0.0.2.css">
        <?php
        if($_SESSION['style'] == 'option2') {
           echo  '<link rel="stylesheet" href="css/dark.min.css" media="screen">';
        } else if($_SESSION['style'] == 'option3') {
            echo  '<link rel="stylesheet" href="css/journal.min.css" media="screen">';
        } else {

        }

        ?>
    </head>
    <body>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/dropdown.js"></script>
        <script src="js/wysihtml5-0.3.0.js"></script>
        <script src="js/bootstrap-wysihtml5-0.0.2.js"></script>
        <script src="js/prettify.js"></script>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/nb_NO/all.js#xfbml=1&appId=141152019365116";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="/blog-cms">Bloggyderp</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="<?php echo ($id == 'home' ? 'active' : '')?>"> <a href="?id=home">Home</a> </li>
                            <li class="divider-vertical"></li>
                            <li class="<?php echo ($id == "about" ? "active" : "")?>"><a href="?id=about">About</a></li>
                            <li class="divider-vertical"></li>
                            <li class="<?php echo ($id == "blogs" ? "active" : "")?>"><a href="?id=blogs">Blogs</a></li>
                            <li class="divider-vertical"></li>
                            <li class="<?php echo ($id == "contact" ? "active" : "")?>"><a href="?id=contact">Contact</a></li>
                        </ul>
                        <ul class="nav pull-right">
                            <?php if($user->loggedOn()) { ?>
                                <li class="<?php echo($id == "newpost" ? "active" : "")?>"><a href="?id=newpost">Create Post</a></li>
                                <li class="divider-vertical"></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, <?php echo $user->getName();?> <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li class="<?php echo ($id == "profile" ? "active" : "")?>"><a href="?id=profile<?php echo '&prid='.$user->getID();?>"><i class="icon-user"></i> Profile</a></li>
                                        <li class="<?php echo ($id == "settings" ? "active" : "")?>"><a href="?id=settings"><i class="icon-cog"></i> Settings</a></li>
                                        <?php if($user->checkAdmin()) { ?>
                                        <li class="<?php echo ($id == "admin" ? "active" : "")?>"><a href="?id=admin"><i class="icon-lock"></i> Admin</a></li>

                                        <?php } ?>

                                        <li class="divider"></li>
                                        <li><a href="?logout"><i class="icon-off"></i> Log out</a></li>

                            <?php } else {

                                include('pages/signup.php');

                                ?>

                                <li class="dropdown">
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon-lock"></i> Sign In <strong class="caret"></strong></a>
                                <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
                                <form action="index.php" method="post" accept-charset="UTF-8">
                                    <legend>Please Sign In</legend>
                                    <input style="margin-bottom: 15px;" type="text" name="uname" size="30" placeholder="Username" />
                                    <input style="margin-bottom: 15px;" type="password" name="pwd" size="30" placeholder="Password" />
                                    <input id="user_remember_me" style="float: left; margin-right: 10px;" type="checkbox" name="remember" value="1" />
                                    <label class="string optional" for="user_remember_me">Remember me</label>

                                    <input class="btn btn-primary" style="clear: left; width: 100%; height: 32px; margin-bottom: 15px; font-size: 13px;" type="submit" value="Sign In" />
                                    <input class="btn btn-primary" style="clear: left; width: 100%; height: 32px; font-size: 13px;" type="submit" value="Sign in with Facebook" />
                                </form>
                                </div>
                                </li>
                                <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    <div class="container">
        <?php if($user->error) {?>
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $user->error; ?>
            </div> <?php } ?>

        <?php if($user->success) {?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $user->success; ?>
            </div> <?php } ?>

        <?php
        $profilederp = 'profile&'.$_GET['prid'];
        switch($id) {
            case "home"     : include('pages/home.php');       break;
            case "about"    : include('pages/about.php');      break;
            case "blogs"    : include('pages/blogs.php');      break;
            case "contact"  : include('pages/contact.php');    break;
            case "settings" : include('pages/settings.php');   break;
            case "profile"  : include('pages/profile.php');    break;
            case "signup"   : include('pages/signup.php');     break;
            case "admin"    : include('pages/admin.php');      break;
            case "newpost"  : include('pages/newpost.php');    break;
            case "viewpost" : include('pages/viewpost.php');   break;
            case "editpost" : include('pages/editpost.php');   break;
            default         : include('pages/home.php');       break;
        }
        ?>

    </div>


    </body>
</html>
