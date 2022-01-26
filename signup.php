<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $fullname = $country = $phone =  $confirm_password = "";
$username_err = $password_err = $fullname_err = $country_err = $phone_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter your email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This email already exist in our database.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    //  Validate full name
    if(empty(trim($_POST["fullname"]))){
        $fullname_err = "Please enter your fullname.";
    } elseif(strlen(trim($_POST["fullname"])) < 3){
        $fullname_err = "Name must have atleast 3 characters.";
    } else{
        $fullname = trim($_POST["fullname"]);
    }

    //  Validate country
    if(empty(trim($_POST["country"]))){
        $country_err = "Please enter your country.";
    } else{
        $country = trim($_POST["country"]);
    }

    //  Validate phone
    if(empty(trim($_POST["phone"]))){
        $phone_err = "Please enter your phone number.";
    } else{
        $phone = trim($_POST["phone"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($country_err) && empty($phone_err) && empty($fullname_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, fullname, country, phone) VALUES (?,?,?,?,?)";
          

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_username, $param_password, $param_fullname, $param_country, $param_phone);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_fullname = $fullname;
            $param_country = $country;
            $param_phone = $phone;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
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
                <a class="logo" href="#">
                        <img src="img/btclogo.png" alt="logo">
                </a>
                <!-- Logo Ends -->
                <!-- Slider Starts -->
                <div id="carousel-testimonials" class="carousel slide carousel-fade" data-ride="carousel">
                    <!-- Indicators Starts -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-testimonials" data-slide-to="0" class=""></li>
                        <li data-target="#carousel-testimonials" data-slide-to="1" class="active"></li>
                        <li data-target="#carousel-testimonials" data-slide-to="2" class=""></li>
                    </ol>
                    <!-- Indicators Ends -->
                    <!-- Carousel Inner Starts -->
                    <div class="carousel-inner">
                        <!-- Carousel Item Starts -->
                        <div class="item item-1">
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
                        <div class="item item-2 active">
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
                                    <footer><span>Dalel Boubaker</span>, Russia</footer>
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
                <!-- <img src="img/btclogo.png" alt="logo" > -->
                <!-- Logo Ends -->
                <div class="form-container">
                    <div>
                        <!-- Section Title Starts -->
                        <div class="row text-center">
                            <h2 class="title-head hidden-xs">get <span>started</span></h2>
                            <p class="info-form">
                                Open account for free and start trading Bitcoins now!
                            </p>
                        </div>
                        <!-- Section Title Ends -->
                        <!-- Form Starts -->

                        <form id="register" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <!-- <input id="csrf_token" name="csrf_token" type="hidden" value="ImY0NTllNjJhYzRhMWQyZjhkN2M3ZTU5NDdjZDUwMmVmNWZiMjYyZWYi.Yc3CGQ.hV9tm0sG3g5J_nGUCqukQqguBE8"> -->
                            
                            
                            <br>
                            <!-- Input Field Starts -->
                            <div class="form-group">
                                <input class="form-control <?php echo (!empty($fullname_err)) ? 'is-invalid' : ''; ?>" id="fullname" name="fullname" placeholder="Full Name" required type="text" value="<?php echo $fullname; ?>">
                                <span class="invalid-feedback"><?php echo $fullname_err; ?></span>
                            </div>
                            <!-- Input Field Ends -->
                            <!-- Input Field Starts -->
                            <div class="form-group">
                                <input class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" id="email" name="username" placeholder="Email" required type="text" value="<?php echo $username; ?>">
                                <span class="invalid-feedback"><?php echo $username_err; ?></span>
                            </div>
                            <!-- Input Field Ends -->
                            <!-- Input Field Starts -->
                            <div class="form-group <?php echo (!empty($country_err)) ? 'is-invalid' : ''; ?>">
                                <select name="country" id="country" required="" class="form-control">
                                    <option value="<?php echo $country; ?>" disabled="" selected="">
                                        Select your Country
                                    </option>
                                    <option value="Afghanistan">Afghanistan</option>
                                    <option value="Åland Islands">Åland Islands</option>
                                    <option value="Albania">Albania</option>
                                    <option value="Algeria">Algeria</option>
                                    <option value="American Samoa">American Samoa</option>
                                    <option value="Andorra">Andorra</option>
                                    <option value="Angola">Angola</option>
                                    <option value="Anguilla">Anguilla</option>
                                    <option value="Antarctica">Antarctica</option>
                                    <option value="Antigua and Barbuda">
                                        Antigua and Barbuda
                                    </option>
                                    <option value="Argentina">Argentina</option>
                                    <option value="Armenia">Armenia</option>
                                    <option value="Aruba">Aruba</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Austria">Austria</option>
                                    <option value="Azerbaijan">Azerbaijan</option>
                                    <option value="Bahamas">Bahamas</option>
                                    <option value="Bahrain">Bahrain</option>
                                    <option value="Bangladesh">Bangladesh</option>
                                    <option value="Barbados">Barbados</option>
                                    <option value="Belarus">Belarus</option>
                                    <option value="Belgium">Belgium</option>
                                    <option value="Belize">Belize</option>
                                    <option value="Benin">Benin</option>
                                    <option value="Bermuda">Bermuda</option>
                                    <option value="Bhutan">Bhutan</option>
                                    <option value="Bolivia">Bolivia</option>
                                    <option value="Bonaire, Sint Eustatius and Saba">
                                        Bonaire, Sint Eustatius and Saba
                                    </option>
                                    <option value="Bosnia and Herzegovina">
                                        Bosnia and Herzegovina
                                    </option>
                                    <option value="Botswana">Botswana</option>
                                    <option value="Bouvet Island">Bouvet Island</option>
                                    <option value="Brazil">Brazil</option>
                                    <option value="British Indian Ocean Territory">
                                        British Indian Ocean Territory
                                    </option>
                                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                                    <option value="Bulgaria">Bulgaria</option>
                                    <option value="Burkina Faso">Burkina Faso</option>
                                    <option value="Burundi">Burundi</option>
                                    <option value="Cambodia">Cambodia</option>
                                    <option value="Cameroon">Cameroon</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Cape Verde">Cape Verde</option>
                                    <option value="Cayman Islands">Cayman Islands</option>
                                    <option value="Central African Republic">
                                        Central African Republic
                                    </option>
                                    <option value="Chad">Chad</option>
                                    <option value="Chile">Chile</option>
                                    <option value="China">China</option>
                                    <option value="Christmas Island">Christmas Island</option>
                                    <option value="Cocos (Keeling) Islands">
                                        Cocos (Keeling) Islands
                                    </option>
                                    <option value="Colombia">Colombia</option>
                                    <option value="Comoros">Comoros</option>
                                    <option value="Congo">Congo</option>
                                    <option value="Congo">
                                        Congo, the Democratic Republic of the
                                    </option>
                                    <option value="Cook Islands">Cook Islands</option>
                                    <option value="Costa Rica">Costa Rica</option>
                                    <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                                    <option value="Croatia">Croatia</option>
                                    <option value="Cuba">Cuba</option>
                                    <option value="Curaçao">Curaçao</option>
                                    <option value="Cyprus">Cyprus</option>
                                    <option value="Czech Republic">Czech Republic</option>
                                    <option value="Denmark">Denmark</option>
                                    <option value="Djibouti">Djibouti</option>
                                    <option value="Dominica">Dominica</option>
                                    <option value="Dominican Republic">
                                        Dominican Republic
                                    </option>
                                    <option value="Ecuador">Ecuador</option>
                                    <option value="Egypt">Egypt</option>
                                    <option value="El Salvador">El Salvador</option>
                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                    <option value="Eritrea">Eritrea</option>
                                    <option value="Estonia">Estonia</option>
                                    <option value="Ethiopia">Ethiopia</option>
                                    <option value="Falkland Islands (Malvinas)">
                                        Falkland Islands (Malvinas)
                                    </option>
                                    <option value="Faroe Islands">Faroe Islands</option>
                                    <option value="Fiji">Fiji</option>
                                    <option value="Finland">Finland</option>
                                    <option value="France">France</option>
                                    <option value="French Guiana">French Guiana</option>
                                    <option value="French Polynesia">French Polynesia</option>
                                    <option value="French Southern Territories">
                                        French Southern Territories
                                    </option>
                                    <option value="Gabon">Gabon</option>
                                    <option value="Gambia">Gambia</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Ghana">Ghana</option>
                                    <option value="Gibraltar">Gibraltar</option>
                                    <option value="Greece">Greece</option>
                                    <option value="Greenland">Greenland</option>
                                    <option value="Grenada">Grenada</option>
                                    <option value="Guadeloupe">Guadeloupe</option>
                                    <option value="Guam">Guam</option>
                                    <option value="Guatemala">Guatemala</option>
                                    <option value="Guernsey">Guernsey</option>
                                    <option value="Guinea">Guinea</option>
                                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                                    <option value="Guyana">Guyana</option>
                                    <option value="Haiti">Haiti</option>
                                    <option value="Heard Island and McDonald Islands">
                                        Heard Island and McDonald Islands
                                    </option>
                                    <option value="Holy See (Vatican City State)">
                                        Holy See (Vatican City State)
                                    </option>
                                    <option value="Honduras">Honduras</option>
                                    <option value="Hong Kong">Hong Kong</option>
                                    <option value="Hungary">Hungary</option>
                                    <option value="Iceland">Iceland</option>
                                    <option value="India">India</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="Iran, Islamic Republic of">
                                        Iran, Islamic Republic of
                                    </option>
                                    <option value="Iraq">Iraq</option>
                                    <option value="Ireland">Ireland</option>
                                    <option value="Isle of Man">Isle of Man</option>
                                    <option value="Israel">Israel</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Jamaica">Jamaica</option>
                                    <option value="Japan">Japan</option>
                                    <option value="Jersey">Jersey</option>
                                    <option value="Jordan">Jordan</option>
                                    <option value="Kazakhstan">Kazakhstan</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="Kiribati">Kiribati</option>
                                    <option value="Korea, Democratic People's Republic of">
                                        Korea, Democratic People's Republic of
                                    </option>
                                    <option value="Korea, Republic of">
                                        Korea, Republic of
                                    </option>
                                    <option value="Kuwait">Kuwait</option>
                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                    <option value="Lao People's Democratic Republic">
                                        Lao People's Democratic Republic
                                    </option>
                                    <option value="Latvia">Latvia</option>
                                    <option value="Lebanon">Lebanon</option>
                                    <option value="Lesotho">Lesotho</option>
                                    <option value="Liberia">Liberia</option>
                                    <option value="Libya">Libya</option>
                                    <option value="Liechtenstein">Liechtenstein</option>
                                    <option value="Lithuania">Lithuania</option>
                                    <option value="Luxembourg">Luxembourg</option>
                                    <option value="Macao">Macao</option>
                                    <option value="Macedonia">
                                        Macedonia, the former Yugoslav Republic of
                                    </option>
                                    <option value="Madagascar">Madagascar</option>
                                    <option value="Malawi">Malawi</option>
                                    <option value="Malaysia">Malaysia</option>
                                    <option value="Maldives">Maldives</option>
                                    <option value="Mali">Mali</option>
                                    <option value="Malta">Malta</option>
                                    <option value="Marshall Islands">Marshall Islands</option>
                                    <option value="Martinique">Martinique</option>
                                    <option value="Mauritania">Mauritania</option>
                                    <option value="Mauritius">Mauritius</option>
                                    <option value="Mayotte">Mayotte</option>
                                    <option value="Mexico">Mexico</option>
                                    <option value="Micronesia">
                                        Micronesia, Federated States of
                                    </option>
                                    <option value="Moldova">Moldova, Republic of</option>
                                    <option value="Monaco">Monaco</option>
                                    <option value="Mongolia">Mongolia</option>
                                    <option value="Montenegro">Montenegro</option>
                                    <option value="Montserrat">Montserrat</option>
                                    <option value="Morocco">Morocco</option>
                                    <option value="Mozambique">Mozambique</option>
                                    <option value="Myanmar">Myanmar</option>
                                    <option value="Namibia">Namibia</option>
                                    <option value="Nauru">Nauru</option>
                                    <option value="Nepal">Nepal</option>
                                    <option value="Netherlands">Netherlands</option>
                                    <option value="New Caledonia">New Caledonia</option>
                                    <option value="New Zealand">New Zealand</option>
                                    <option value="Nicaragua">Nicaragua</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="Niue">Niue</option>
                                    <option value="Norfolk Island">Norfolk Island</option>
                                    <option value="Northern Mariana Islands">
                                        Northern Mariana Islands
                                    </option>
                                    <option value="Norway">Norway</option>
                                    <option value="Oman">Oman</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Palau">Palau</option>
                                    <option value="Palestinian Territory, Occupied">
                                        Palestinian Territory, Occupied
                                    </option>
                                    <option value="Panama">Panama</option>
                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                    <option value="Paraguay">Paraguay</option>
                                    <option value="Peru">Peru</option>
                                    <option value="Philippines">Philippines</option>
                                    <option value="Pitcairn">Pitcairn</option>
                                    <option value="Poland">Poland</option>
                                    <option value="Portugal">Portugal</option>
                                    <option value="Puerto Rico">Puerto Rico</option>
                                    <option value="Qatar">Qatar</option>
                                    <option value="Réunion">Réunion</option>
                                    <option value="Romania">Romania</option>
                                    <option value="Russian Federation">
                                        Russian Federation
                                    </option>
                                    <option value="Rwanda">Rwanda</option>
                                    <option value="Saint Barthélemy">Saint Barthélemy</option>
                                    <option value="Saint Helena, Ascension and Tristan da Cunha">
                                        Saint Helena, Ascension and Tristan da Cunha
                                    </option>
                                    <option value="Saint Kitts and Nevis">
                                        Saint Kitts and Nevis
                                    </option>
                                    <option value="Saint Lucia">Saint Lucia</option>
                                    <option value="Saint Martin (French part)">
                                        Saint Martin (French part)
                                    </option>
                                    <option value="Saint Pierre and Miquelon">
                                        Saint Pierre and Miquelon
                                    </option>
                                    <option value="Saint Vincent and the Grenadines">
                                        Saint Vincent and the Grenadines
                                    </option>
                                    <option value="Samoa">Samoa</option>
                                    <option value="San Marino">San Marino</option>
                                    <option value="Sao Tome and Principe">
                                        Sao Tome and Principe
                                    </option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="Senegal">Senegal</option>
                                    <option value="Serbia">Serbia</option>
                                    <option value="Seychelles">Seychelles</option>
                                    <option value="Sierra Leone">Sierra Leone</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Sint Maarten (Dutch part)">
                                        Sint Maarten (Dutch part)
                                    </option>
                                    <option value="Slovakia">Slovakia</option>
                                    <option value="Slovenia">Slovenia</option>
                                    <option value="Solomon Islands">Solomon Islands</option>
                                    <option value="Somalia">Somalia</option>
                                    <option value="South Africa">South Africa</option>
                                    <option value="South Georgia and the South Sandwich Islands">
                                        South Georgia and the South Sandwich Islands
                                    </option>
                                    <option value="South Sudan">South Sudan</option>
                                    <option value="Spain">Spain</option>
                                    <option value="Sri Lanka">Sri Lanka</option>
                                    <option value="Sudan">Sudan</option>
                                    <option value="Suriname">Suriname</option>
                                    <option value="Svalbard and Jan Mayen">
                                        Svalbard and Jan Mayen
                                    </option>
                                    <option value="Swaziland">Swaziland</option>
                                    <option value="Sweden">Sweden</option>
                                    <option value="Switzerland">Switzerland</option>
                                    <option value="Syrian Arab Republic">
                                        Syrian Arab Republic
                                    </option>
                                    <option value="Taiwan, Province of China">
                                        Taiwan, Province of China
                                    </option>
                                    <option value="Tajikistan">Tajikistan</option>
                                    <option value="Tanzania">
                                        Tanzania, United Republic of
                                    </option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Timor-Leste">Timor-Leste</option>
                                    <option value="Togo">Togo</option>
                                    <option value="Tokelau">Tokelau</option>
                                    <option value="Tonga">Tonga</option>
                                    <option value="Trinidad and Tobago">
                                        Trinidad and Tobago
                                    </option>
                                    <option value="Tunisia">Tunisia</option>
                                    <option value="Turkey">Turkey</option>
                                    <option value="Turkmenistan">Turkmenistan</option>
                                    <option value="Turks and Caicos Islands">
                                        Turks and Caicos Islands
                                    </option>
                                    <option value="Tuvalu">Tuvalu</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="Ukraine">Ukraine</option>
                                    <option value="United Arab Emirates">
                                        United Arab Emirates
                                    </option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="United States">United States</option>
                                    <option value="United States Minor Outlying Islands">
                                        United States Minor Outlying Islands
                                    </option>
                                    <option value="Uruguay">Uruguay</option>
                                    <option value="Uzbekistan">Uzbekistan</option>
                                    <option value="Vanuatu">Vanuatu</option>
                                    <option value="Venezuela, Bolivarian Republic of">
                                        Venezuela,
                                    </option>
                                    <option value="Viet Nam">Viet Nam</option>
                                    <option value="Virgin Islands, British">
                                        Virgin Islands, British
                                    </option>
                                    <option value="Virgin Islands, U.S.">
                                        Virgin Islands, U.S.
                                    </option>
                                    <option value="Wallis and Futuna">Wallis and Futuna</option>
                                    <option value="Western Sahara">Western Sahara</option>
                                    <option value="Yemen">Yemen</option>
                                    <option value="Zambia">Zambia</option>
                                    <option value="Zimbabwe">Zimbabwe</option>
                                </select>
                                <span class="invalid-feedback"><?php echo $country_err; ?></span>
                            </div>

                            <!-- Input Field Ends -->
                            <!-- Input Field Starts -->
                            <div class="form-group">
                                <small>eg. +18502033803</small>
                                <input class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" id="phone" name="phone" placeholder="Phone" required type="text" value="<?php echo $phone; ?>">
                                <span class="invalid-feedback"><?php echo $phone_err; ?></span>
                            </div>

                            <!-- Input Field Ends -->
                            <!-- Input Field Starts -->
                            <div class="form-group">
                                <input class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" id="password" name="password" placeholder="Password" required type="password" value="<?php echo $password; ?>">
                                
                            </div>
                                <div class="form-group">
                                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" placeholder="Confirm Password" value="<?php echo $confirm_password; ?>">
                                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                            </div>
                            <!-- Input Field Ends -->
                            <!-- Submit Form Button Starts -->
                            <div class="form-group">
                                <button class="btn btn-primary" name="submit" id="submit-btn" type="submit">
                                    create account
                                </button>
                                <p class="text-center">
                                    already have an account ? <a href="login.php">Login</a>
                                </p>
                            </div>

                            <!-- Submit Form Button Ends -->
                        </form>
                        <!-- Form Ends -->
                    </div>
                </div>
                
               
            </div>
        </div>

    </li>
</ul>


     <!-- Copyright Text Starts -->
                <p class="text-center copyright-text" style="margin-bottom: 0;">
                    Copyright ©
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    TradeBtc All Rights Reserved
                </p>
                <!-- Copyright Text Ends -->
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