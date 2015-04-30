<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
$reponse = array();
if (isset($_POST["accesstoken"])) {
    $_SESSION["accesstoken"] = $_POST["accesstoken"];
    return json_encode($reponse);
}

if (!isset($_SESSION["accesstoken"])) {
    $reponse["status"] = 0;
    echo json_encode($reponse);
}
require_once('remdir.php');
$remvdir = new remdir();

// Initialize facebook sdk
require_once("lib/facebook.php");
require_once("fbCredentials.php");
$config = array();
$config['appId'] = $AppId;
$config['secret'] = $AppSecret;
$config['fileUpload'] = false;
// optional
$facebook = new Facebook($config);
if (!isset($_SESSION["accesstoken"])) {
    $facebook->getAccessToken();
}
else
    $facebook->setAccessToken($_SESSION["accesstoken"]);
$uid = $facebook->getUser();
if ($uid == 0) {
    $reponse["status"] = 0;
    echo json_encode($reponse);
    $uid = null;
}

//total progress
$total_img = 0;

//prepare album to download for single multiple or all

if (isset($_REQUEST['albumids'])) {
    //Fetch User albums Photo
    $albums = explode(',', $_REQUEST['albumids']);

    //looping album
    $zip_files = array();
    foreach ($albums as $albums_single) {

        $albumPhotos = $facebook->api('/' . $albums_single . '/photos?limit=200', 'GET');
        //file for zipping

        foreach ($albumPhotos["data"] as $file) {

            $zip_files[$albums_single][] = $file['source'];
        }
    }
    $zipfile = crateZip($uid, $_REQUEST['albumids'], $zip_files);
    echo $zipfile;
}

//create zip
function crateZip($uid, $album, $album_file)
{

    $zip = new ZipArchive();
    $filename = $uid . ".zip";

    if ($zip->open($filename, ZipArchive::CREATE | ZIPARCHIVE::OVERWRITE) !== TRUE) {
        exit("cannot open <$filename>\n");
    }
    $directory = explode(',', $album);
    foreach ($directory as $album_dir) {
        $zip->addEmptyDir($album_dir);
        foreach ($album_file[$album_dir] as $album_files) {

            $newName = rand(11, 10000) . ".jpeg";
            $file = file_get_contents($album_files);
            $zip->addFromString($album_dir . '/' . $newName, $file);

        }

    }
    $zip->close();
    return $filename;

}

//get file from url
function getfile($url, $dir)
{
    ini_set('max_execution_time', 300);
    try {
        file_put_contents($dir . substr($url, strrpos($url, '/'), strlen($url)), file_get_contents($url));
    } catch (Exception $ex) {
        echo $ex;
    }
}


//prepare move
function prepare_move($files = array(), $album_id)
{
    mkdir($album_id);
    if (is_array($files)) {
        foreach ($files as $file) {
            getfile($file, $album_id);
        }
    }
}

if (isset($_GET['albumids_move'])) {
    $album = explode(',', $_REQUEST['albumids_move']);
    foreach ($album as $album_id) {
        $photos = $facebook->api("/{$album_id}/photos");
        $files_to_move = array();
        foreach ($photos['data'] as $photo) {
            $files_to_move[] = $photo["source"];
        }
        $remvdir->rrmdir($album_id);
        prepare_move($files_to_move, $album_id);
        $reponse["status"] = 1;
    }
    if ($reponse["status"] == 1)
        print_r($_REQUEST['albumids_move']);

}

if(isset($_POST['removedir']))
{
    echo $_POST['removedir'];
    exit;
    $facebook->destroySession();
    if (file_exists($_POST['removedir'].'zip')) {

        unlink($_POST['removedir'].'zip');

    }
}
