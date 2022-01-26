<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: dashboard/dashboard.php?id=$id");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter Your Email.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: dashboard/dashboard.php?id=$id");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="description" content="TradeBtc. A place where traders can access real-world markets with
    crypto currencies and start trading instantly. We offer deposits and withdrawals via cryptos,
    overcoming the biggest hurdle letting traders instantly transact funds. By using cyrptos instead of
    fiat, we provide traders instant deposits, lightning fast execution, worldwide market access from around
    the globe, tight spreads and best client support.">
    <meta name="title" content="TradeBtc.com | Start trading instantly">
    <meta name="image" content="https://www.TradeBtc.com//static/home/img/bg1.jpg">
    <meta name="application-name" content="TradeBtc">

    <meta property="og:site_name" content="TradeBtc">
    <meta property="og:type" content="article">
    <meta property="og:title" content="TradeBtc.com | Start trading instantly">
    <meta property="og:image" content="https://www.TradeBtc.com//static/home/img/bg1.jpg">
    <meta property="og:description" content="TradeBtc. A place where traders can access real-world markets with
    crypto currencies and start trading instantly. We offer deposits and withdrawals via cryptos,
    overcoming the biggest hurdle letting traders instantly transact funds. By using cyrptos instead of
    fiat, we provide traders instant deposits, lightning fast execution, worldwide market access from around
    the globe, tight spreads and best client support.">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="TradeBtc.com | Start trading instantly">
    <meta property="twitter:image" content="https://www.TradeBtc.com//static/home/img/bg1.jpg">
    <meta name="twitter:description" content="TradeBtc. A place where traders can access real-world markets with
    crypto currencies and start trading instantly. We offer deposits and withdrawals via cryptos,
    overcoming the biggest hurdle letting traders instantly transact funds. By using cyrptos instead of
    fiat, we provide traders instant deposits, lightning fast execution, worldwide market access from around
    the globe, tight spreads and best client support.">
    <meta name="keywords" content="Cryptocurrency, bitcoin, bitcoin landing, blockchain, crypto trading ">

    <link rel="shortcut icon" href="img/favicon.png">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/magnific-popup.css" />
    <link rel="stylesheet" href="css/select2.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/orange.css" />
    <link rel="stylesheet" href="css/styles-extend.css">

    <script src="js/modernizr.js"></script>

    <link rel="stylesheet" type="text/css" href="https://widgets.bitcoin.com/widget.css?46" media="all">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <script src="https://widgets.bitcoin.com/widget.js" id="btcwdgt"></script>

    <title>TradeBtc.com | Start trading instantly and make up to 100% weekly profit</title>
</head>
<body>
    <div id="preloader">
      <div id="preloader-content">
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
          y="0px" width="150px" height="150px" viewBox="100 100 400 400" xml:space="preserve">
          <filter id="dropshadow" height="130%">
            <feGaussianBlur in="SourceAlpha" stdDeviation="5"></feGaussianBlur>
            <feOffset dx="0" dy="0" result="offsetblur"></feOffset>
            <feFlood flood-color="red"></feFlood>
            <feComposite in2="offsetblur" operator="in"></feComposite>
            <feMerge>
              <feMergeNode></feMergeNode>
              <feMergeNode in="SourceGraphic"></feMergeNode>
            </feMerge>
          </filter>
          <path class="path" fill="#000000" d="M446.089,261.45c6.135-41.001-25.084-63.033-67.769-77.735l13.844-55.532l-33.801-8.424l-13.48,54.068
                      c-8.896-2.217-18.015-4.304-27.091-6.371l13.568-54.429l-33.776-8.424l-13.861,55.521c-7.354-1.676-14.575-3.328-21.587-5.073
                      l0.034-0.171l-46.617-11.64l-8.993,36.102c0,0,25.08,5.746,24.549,6.105c13.689,3.42,16.159,12.478,15.75,19.658L208.93,357.23
                      c-1.675,4.158-5.925,10.401-15.494,8.031c0.338,0.485-24.579-6.134-24.579-6.134l-9.631,40.468l36.843,9.188
                      c8.178,2.051,16.209,4.19,24.098,6.217l-13.978,56.17l33.764,8.424l13.852-55.571c9.235,2.499,18.186,4.813,26.948,6.995
                      l-13.802,55.309l33.801,8.424l13.994-56.061c57.648,10.902,100.998,6.502,119.237-45.627c14.705-41.979-0.731-66.193-31.06-81.984
                      C425.008,305.984,441.655,291.455,446.089,261.45z M368.859,369.754c-10.455,41.983-81.128,19.285-104.052,13.589l18.562-74.404
                      C306.28,314.65,379.774,325.975,368.859,369.754z M379.302,260.846c-9.527,38.187-68.358,18.781-87.442,14.023l16.828-67.489
                      C327.767,212.14,389.234,221.02,379.302,260.846z"></path>
        </svg>
      </div>
    </div>
    <div class="wrapper">
        
    
<style>
    body {
        background-color: #f2f2f2;
    }
</style>
<ul class="contact-info" style="list-style: none;">
    <li>
        <div class="container-fluid user-auth">
            <div class="hidden-xs col-sm-4 col-md-4 col-lg-4">
                <!-- Logo Starts -->
                <a class="logo" href="index.php">
                        <img src="img/btclogo.png" alt="logo">
                </a>
                <!-- Logo Ends -->
                <!-- Slider Starts -->
                <div id="carousel-testimonials" class="carousel slide carousel-fade" data-ride="carousel">
                    <!-- Indicators Starts -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-testimonials" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-testimonials" data-slide-to="1"></li>
                        <li data-target="#carousel-testimonials" data-slide-to="2"></li>
                    </ol>
                    <!-- Indicators Ends -->
                    <!-- Carousel Inner Starts -->
                    <div class="carousel-inner">
                        <!-- Carousel Item Starts -->
                        <div class="item active item-1">
                            <div>
                                <blockquote>
                                    <p>
                                        This is a realistic program for anyone looking for site to
                                        invest. Paid to me regularly, keep up good work!
                                    </p>
                                    <footer><span>Lucy Smith</span>, England</footer>
                                </blockquote>
                            </div>
                        </div>
                        <!-- Carousel Item Ends -->
                        <!-- Carousel Item Starts -->
                        <div class="item item-2">
                            <div>
                                <blockquote>
                                    <p>
                                        Bitcoin doubled in 7 days. You should not expect anything
                                        more. Excellent customer service!
                                    </p>
                                    <footer><span>Slim Hamdi</span>, Tunisia</footer>
                                </blockquote>
                            </div>
                        </div>
                        <!-- Carousel Item Ends -->
                        <!-- Carousel Item Starts -->
                        <div class="item item-3">
                            <div>
                                <blockquote>
                                    <p>
                                        I want to thank you for helping me find a great
                                        opportunity to make money online. Very happy with how
                                        things are going!
                                    </p>
                                    <footer><span>Rawia Chniti</span>, Russia</footer>
                                </blockquote>
                            </div>
                        </div>
                        <!-- Carousel Item Ends -->
                    </div>
                    <!-- Carousel Inner Ends -->
                </div>
                <!-- Slider Ends -->
            </div>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <!-- Logo Starts -->
                <a id="llogo" class="visible-xs" href="index.php">
                        <img src="img/btclogo.png" alt="logo">
                </a>
                <!-- Logo Ends -->
                <div class="form-container">
                    <div>
                        <!-- Section Title Starts -->
                        <div class="row text-center">
                            <h2 class="title-head hidden-xs">member <span>login</span></h2>
                            <p class="info-form">
                                Send, receive and securely store your coins in your wallet
                            </p>
                        </div>
                        <!-- Section Title Ends -->
                        <!-- Form Starts -->

                        <form id="login" action="login.php" method="POST" autocomplete="off">
                            
                            
                            <br>
                            <!-- Input Field Starts -->
                            <div class="form-group">
                                <input class="form-control" name="username" id="email" placeholder="EMAIL" type="text"
                                    required="">
                                <small id="e_error" class="form-text text-muted"></small>
                            </div>
                            <!-- Input Field Ends -->
                            <!-- Input Field Starts -->
                            <div class="form-group">
                                <input class="form-control" name="password" id="password" placeholder="PASSWORD"
                                    type="password" required="">
                            </div>
                            <!-- Input Field Ends -->
                            <!-- Submit Form Button Starts -->
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">login</button>
                                <p class="text-center">
                                    don't have an account ?
                                    <a href="signup.php">register now</a>
                                </p>
                            </div>

                            <!-- Submit Form Button Ends -->
                        </form>
                        <!-- Form Ends -->
                    </div>
                </div>
                <!-- Copyright Text Starts -->
                <p class="text-center copyright-text">
                    Copyright ©
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    TradeBtc All Rights Reserved
                </p>
                <!-- Copyright Text Ends -->
            </div>
        </div>
    </li>
</ul>


    
    </div>
    <script src="js/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/select2.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/custom.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <!-- GetButton.io widget -->
<script type="text/javascript">
    (function () {
        var options = {
            whatsapp: "+19199129791", // WhatsApp number
            call_to_action: "Message us", // Call to action
            position: "left", // Position may be 'right' or 'left'
        };
        var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script>
<!-- /GetButton.io widget -->
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/61a398069099530957f700e2/1fljgjmvj';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>
<script src="https://widgets.bitcoin.com/widget.js" id="btcwdgt"></script>
<script>
  (function(b,i,t,C,O,I,N) {
    window.addEventListener('load',function() {
      if(b.getElementById(C))return;
      I=b.createElement(i),N=b.getElementsByTagName(i)[0];
      I.src=t;I.id=C;N.parentNode.insertBefore(I, N);
    },false)
  })(document,'script','https://widgets.bitcoin.com/widget.js','btcwdgt');
</scr