<?php
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
        <style>
            body {
                padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
            }
        </style>
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
                    <a class="brand" href="/">Bloggyderp</a>
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
