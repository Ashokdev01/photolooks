<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Facebook Photo Album</title>
    <link rel="stylesheet" href="assets/css/foundation.css"/>

    <link rel="stylesheet" href="assets/css/foundation-icons.css"/>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
    <script src="assets/js/vendor/modernizr.js"></script>
</head>
<body class="page-color" id="main-content">

<!-- Navigation -->
<div id="fb-root"></div>
<div class="row">
    <div class="large-12 columns">

        <nav class="top-bar" data-topbar>
            <ul class="title-area">
                <!-- Title Area -->
                <li class="name">
                    <h1><a href="#"> Facebook Album Move to google picasa</a></h1>
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
            <h1>Facebook Album </h1>
            <br>

            <h3>Login to Google for Moving
                <br class="hide-for-small">
                your Facebook Album to picasa.</h3>
            <br>

            <div class="left ">
                <?php

                /**
                 * Created by PhpStorm.
                 * User: sweet
                 * Date: 27/1/15
                 * Time: 11:05 AM
                 */

                session_start();

                require_once 'remdir.php';
                $remvdir = new remdir();

                require_once 'Zend/Loader.php';
                Zend_Loader::loadClass('Zend_Gdata_Photos');
                Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
                Zend_Loader::loadClass('Zend_Gdata_AuthSub');

                $gp = new Zend_Gdata_Photos(getAuthSubHttpClient(), "Google-DevelopersGuide-1.0");
                $entry = new Zend_Gdata_Photos_AlbumEntry();

                //moving photos to picasa

                if (isset($_GET['album_id'])) {
                    $response = null;
                    $album = $_GET['album_id'];
                    $album_move = explode(',', $album);
                    foreach ($album_move as $album_id) {
                        if (file_exists($album_id)) {
                            add_new_album($entry, $gp, $album_id, $album_id);
                            $remvdir->rrmdir($album_id);
                            $response = 1;
                        } else {
                            $response = 0;
                        }
                    }
                    echo '<script > document.location.href="index.php?r=' . $response . '"; </script>';
                }


                //---------------------------------------------------------------------------------------------
                function getAuthSubUrl()
                {
                    $next = getCurrentUrl();
                    $scope = 'https://picasaweb.google.com/data';
                    $secure = 0;
                    $session = 1;
                    return Zend_Gdata_AuthSub::getAuthSubTokenUri($next, $scope, $secure,
                        $session);
                }

                /*function getAuthSubHttpClient() {
                    if ( isset( $_SESSION['google_session_token'] ) ) {
                        $client = Zend_Gdata_AuthSub::getHttpClient( $_SESSION['google_session_token'] );
                        return $client;
                    }
                }
                */
                function getCurrentUrl()
                {
                    global $_SERVER;
                    $php_request_uri = htmlentities(substr($_SERVER['REQUEST_URI'], 0, strcspn($_SERVER['REQUEST_URI'], "\n\r")), ENT_QUOTES);

                    if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') {
                        $protocol = 'https://';
                    } else {
                        $protocol = 'http://';
                    }
                    $host = $_SERVER['HTTP_HOST'];
                    if ($_SERVER['SERVER_PORT'] != '' && (($protocol == 'http://' && $_SERVER['SERVER_PORT'] != '80') || ($protocol == 'https://' && $_SERVER['SERVER_PORT'] != '443'))) {
                        $port = ':' . $_SERVER['SERVER_PORT'];
                    } else {
                        $port = '';
                    }
                    return $protocol . $host . $port . $php_request_uri;
                }


                function add_new_album($entry, $gp, $album_id, $album_name)
                {
//	$new_album_name = str_replace( " ", "_", $album_name );
                    $new_album_name = 'facebook_album_'.$album_name . '_' .rand(1,1111);
                    $entry->setTitle($gp->newTitle($new_album_name));
                    $entry->setSummary($gp->newSummary("Album added by Falbum"));
                    $gp->insertAlbumEntry($entry);

                    $path = $album_id;
                    if (file_exists($path)) {
                        $photos = scandir($path);
                        foreach ($photos as $photo) {
                            if ($photo != "." && $photo != "..") {
                                $photo_path = $path . '/' . $photo;
                                add_new_photo_to_album($gp, $photo_path, $new_album_name);
                            }
                        }
                    }
                }

                function add_new_photo_to_album($gp, $path, $new_album_name)
                {
                    $user_name = "default";
                    $file_name = $path;
                    $photo_name = rand(11, 99999);
                    $photo_caption = "Falbum";
                    $fd = $gp->newMediaFileSource($file_name);
                    $fd->setContentType("image/jpeg");
                    // Create a PhotoEntry
                    $photo_entry = $gp->newPhotoEntry();
                    $photo_entry->setMediaSource($fd);
                    $photo_entry->setTitle($gp->newTitle($photo_name));
                    $photo_entry->setSummary($gp->newSummary($photo_caption));
                    $album_query = $gp->newAlbumQuery();
                    $album_query->setUser($user_name);
                    $album_query->setAlbumName($new_album_name);
                    $gp->insertPhotoEntry($photo_entry, $album_query->getQueryUrl());
                }


                function getAuthSubHttpClient()
                {
                    if (!isset($_SESSION['sessionToken']) && !isset($_GET['token'])) {
                        // echo '<a href="' . getAuthSubUrl() . '">Login!</a>';
                        echo '<a class="button alert" href="' . getAuthSubUrl() . '">Lohin with google
                </a>';
                        //exit;
                    } else if (!isset($_SESSION['sessionToken']) && isset($_GET['token'])) {
                        $_SESSION['sessionToken'] =
                            Zend_Gdata_AuthSub::getAuthSubSessionToken($_GET['token']);
                    }
                    $client = Zend_Gdata_AuthSub::getHttpClient($_SESSION['sessionToken']);
                    return $client;
                }


                ?>

            </div>
        </div>
        <div class=" large-6 medium-5 columns  ">
            <img src="assets/img/googlelogo.png">
        </div>

    </div>
</section>


<script src="assets/js/foundation.min.js"></script>
<script>
    $(document).foundation();
</script>

</body>
</html>
