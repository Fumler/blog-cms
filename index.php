<?php
// vars
$db = new PDO('localhost', 'dbname=oblig;charset=UTF8', $_SERVER['DBUSER'], $_SERVER['DBPASS']);

// includes
include('classes/user1.class.php');

// if id has a value, get it, if not set to home
$id = isset($_GET['id']) ? $_GET['id'] : 'home';
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
    </head>
    <body>
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
                            <li class="<?php echo ($id == "about" ? "active" : "")?>"><a href="?id=about">About
                            <li class="<?php echo ($id == "blogs" ? "active" : "")?>"><a href="?id=blogs">Blogs</a></li>
                            <li class="<?php echo ($id == "contact" ? "active" : "")?>"><a href="?id=contact">Contact</a></li>
                        </ul>
                        <ul class='nav nav-collapse collapse pull-right'>
                            <li class="">
                                <form class="navbar-search">
                                    <i class="icon-user icon-white"></i>
                                    <input type="text" class="span2" placeholder="Username">
                                    <input type="text" class="span2" placeholder="Password">
                                    <input type="submit" value="Login" class="btn btn-primary"/>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    <div class="container">

        <?php
        switch($id) {
            case "home"     : include('pages/home.php');       break;
            case "about"    : include('pages/about.php');      break;
            case "blogs"    : include('pages/blogs.php');      break;
            case "contact"  : include('pages/contact.php');    break;
            default         : include('pages/home.php');       break;
        }
        ?>

    </div>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="js/bootstrap.min.js"></script>

    </body>
</html>
