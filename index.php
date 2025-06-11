<?php 
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
  
    <meta name="viewport" content="width=1280, maximum-scale=1.0" />
    <link rel="shortcut icon" type="image/png" href="https://animaproject.s3.amazonaws.com/home/favicon.png" />
    <meta name="og:type" content="website" />
    <meta name="twitter:card" content="photo" />
    <link rel="stylesheet" type="text/css" href="template/css/index.css" />
    <link rel="stylesheet" type="text/css" href="template/css/styleguide.css" />
    <link rel="stylesheet" type="text/css" href="template/css/globals.css" />
    <title>FlashUT</title>
  </head>
  <body style="margin: 0; background: #f6f6f6">
    <input type="hidden" id="anPageName" name="page" value="index" />
    <div class="container-center-horizontal">
      <div class="index screen">
        <div class="flex-col">
          <div class="logo"></div>
          <div class="x02-header">
            <h1 class="the-design-thinking"> Make learning fun!</h1>
            <div class="overlap-group1">
              <p class="tools-tutorials-de">Empower Your Study with Interactive Flashcards!</p>
              <p class="your-gateway-to-smarter-studying">
                <span class="span0-1">Your Gateway to Smarter Studying!</span>
              </p>
            </div>
           <a href="/FlashUT/views/register.php"> <div class="signupNow"><span class="get-started">Sign up now!</span></div></a>
          </div>
        </div>
        <div class="flex-col-1">
          <div class="button-container">
            <div class="signup-button">
            <a href="/FlashUT/views/register.php"><span class="singupText">
              Sign up</span>
            </a>
            </div>

            <div class="login-button">
              <a href="/FlashUT/views/login.php"><span class="loginText">Log in</span>
             </a>
            </div>

            <div class="stats-button">
                <a href="/FlashUT/views/statistics.php">
              <span class="statsText">📊 Collage Stats</span>
            </a>
</div>
          </div>
          <div class="overlap-group2">
            <img
              class="bigLogo"
              src="template/img/bigLogo.png"
              alt="flashUTlogo"
            />
            <div class="answer">
              <p class="flash-smarter-not-h publicsans-medium-black-haze-28px">
                <span class="span publicsans-medium-black-haze-28px">Flash </span
                ><span class="span publicsans-extra-extra-bold-black-haze-28px">smarter</span
                ><span class="span publicsans-medium-black-haze-28px">, not </span><span class="span3">harder</span
                ><span class="span publicsans-medium-black-haze-28px">!<br /><br /></span
                ><span class="span publicsans-extra-extra-bold-black-haze-28px">Study</span
                ><span class="span publicsans-medium-black-haze-28px">. </span
                ><span class="span publicsans-extra-extra-bold-black-haze-28px">Review</span
                ><span class="span publicsans-medium-black-haze-28px">. </span
                ><span class="span publicsans-extra-extra-bold-black-haze-28px">Succeed</span
                ><span class="span publicsans-medium-black-haze-28px">.<br /><br />Where learning meets </span
                ><span class="span11">speed</span><span class="span publicsans-medium-black-haze-28px">.</span>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

