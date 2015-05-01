<?php
require_once("fbCredentials.php");

?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Facebook Photo Album</title>
    <link rel="stylesheet" href="assets/css/foundation.css"/>
    <link rel="stylesheet" href="assets/css/fbalbum.css"/>
    <link rel="stylesheet" href="assets/css/foundation-icons.css"/>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
    <script src="assets/js/vendor/modernizr.js"></script>
</head>
<body class="page-color" id="main-content">

<!-- Navigation -->
<div id="fb-root"></div>
<div class="loader" style="display: none;"></div>
<div class="row">
    <div class="large-12 columns">

        <nav class="top-bar" data-topbar>
            <ul class="title-area">
                <!-- Title Area -->
                <li class="name">
                    <h1><a href="#"> Facebook Album </a></h1>
                </li>
            </ul>
        </nav>
        <!-- End Top Bar -->
    </div>
</div>

<!-- End Navigation -->
<section id="bef_login">
    <div class="row">
        <div class="medium-7 large-6 columns">
            <h1>Facebook Album</h1>
            <br>

            <h3>Download your Facebook albums
                <br class="hide-for-small">
                and move it to picasa.</h3>
            <br>
        </div>
    </div>

    <div class="row">
        <div class="small-6 columns">

            <button class="btn_login">Connect with facebook
            </button>
        </div>
    </div>

</section>
<div id="aft_login" class="row margin_top_2 " style="margin-left: auto;margin-right: auto">


    <div class="small-12 medium-5 large-4 columns left" id="profile">

        <img src="assets/img/bg.png" id="ProfilePic" style="width: 100%">

        <div id="btn_container" class="text-center">
            <h3 id="username"></h3>
            <button class="success button small" style="width: 100%" id="download_all">Download All</button>

            <button class="button small" style="width: 100%" id="download_selected">Download Selected</button>

            <button class="secondary button small" style="width: 100%" id="move_selected">Move Selected</button>

            <button class="warning button small" style="width: 100%" id="move_all">Move All</button>

            <button class="alert button small" style="width: 100%" id="signout"> Signout</button>

        </div>
    </div>
    <div class="small-12 medium-7 large-8 columns left middle" id="albumsss1"></div>


    <a href="#" data-reveal-id="myModal" id="openmodal" style="display:none;"></a>

    <div id="myModal" class="reveal-modal" data-reveal>
        <div class="modal-header">
            <h4 id="myModalLabel">Please wait while we are preparing your files</h4>
        </div>
        <div class="modal-body">
            <!-- Progress    -->
            <div id="downloadprogress">
                <img src="assets/img/6.gif"/>
            </div>
        </div>


        <div id="progressbar" class="meter active round"></div>

        <div id="download-progress-done" style="display:none">
            <!--Download Button -->
            <a href="" id="downloadLink" class="button">Click Here to Download</a>
        </div>
        <a class="close-reveal-modal" id="closemodal">&#215;</a>
    </div>

</div>


<div id="slider" style="display:none">
    <div id="backalbum">
        <button id="backtoalbum" class="button small">
            Back to Albums
        </button>
        <button id="btnDownload" class="button success small">
            Download Album
        </button>
        <button id="btnMove" class="button success small">
            Move Album
        </button>
    </div>
    <!--Thumbnail Navigation-->
    <div id="prevthumb"></div>
    <div id="nextthumb"></div>

    <!--Arrow Navigation-->
    <a id="prevslide" class="load-item"></a>
    <a id="nextslide" class="load-item"></a>

    <div id="thumb-tray" class="load-item">
        <div id="thumb-back"></div>
        <div id="thumb-forward"></div>
    </div>

    <!--Time Bar-->
    <div id="progress-back" class="load-item">
        <div id="progress-bar"></div>
    </div>

    <!--Control Bar-->
    <div id="controls-wrapper" class="load-item">
        <div id="controls">

            <a id="play-button"><img id="pauseplay" src="assets/img/pause.png"/></a>

            <!--Slide counter-->
            <div id="slidecounter">
                <span class="slidenumber"></span> / <span class="totalslides"></span>
            </div>

            <!--Slide captions displayed here-->
            <div id="slidecaption"></div>

            <!--Thumb Tray button-->
            <a id="tray-button" style="display: block"><img id="tray-arrow" src="assets/img/button-tray-up.png"/></a>

            <!--Navigation-->
            <ul id="slide-list"></ul>

        </div>
    </div>
</div>



<script src="assets/js/foundation.min.js"></script>
<script src="assets/js/fbscript.js"></script>
<script>
    $(document).foundation();
</script>

<link rel="stylesheet" href="assets/css/supersized.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="assets/css/supersized.shutter.css" type="text/css" media="screen"/>
<script type="text/javascript" src="assets/js/jquery.easing.min.js"></script>


<script type="text/javascript" src="assets/js/supersized.3.2.7.js"></script>
<script type="text/javascript" src="assets/js/supersized.shutter.js"></script>
<script>
    $(document).ready(function () {
        $('#supersized-loader').remove();
        $('#supersized').hide();
    });
</script>
</body>
</html>
