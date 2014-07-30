<?php
session_start();
include_once "config.php";
include_once "class.fblinkedtwit.php";
$fblinkedtwit   =   new FbLinkedTwit();
require 'src/facebook.php';
$facebook = new Facebook(array(
  'appId'  => $config["fb_api"],
  'secret' => $config["fb_secret"],
  'cookie' => true,
  'scope' => 'offline_access,read_stream,user_photos,user_videos,publish_stream,manage_pages',
  'req_perms' => 'publish_stream',
), $params);

// Get User ID


if (!empty($_POST)){
$status1 = $_POST['title'].' ---> ';
$status1 .= $_POST['content'];
$status1 = str_replace('<b>', ' ', $status1);
$status1 = str_replace('</b>', ' ', $status1);
$status1 = str_replace('&amp;', ' ', $status1);
$status = substr($status1, 0, 140);

    //facebook status update
    $user = $facebook->getUser();
    if ($user) {
    try {
      // Proceed knowing you have a logged in user who's authenticated.
      $user_profile = $facebook->api('/me');
      $_SESSION['fb_username'] = $user_profile['name'];
      $_SESSION['fb_userid'] = $user_profile['id'];
      $_SESSION['fb_userlink'] = $user_profile['link'];
        //$token is the access token from the URL above
         //$token = $facebook->getAccessToken(); 
        $post = array('access_token' => $token, 'message' => $status);

        try{
        $res = $facebook->api('/me/feed','POST',$post);
        //print_r($res);

        } catch (Exception $e){
            echo $e->getMessage();
        }
    } catch (FacebookApiException $e) {
      error_log($e);
      $user = null;
    }
}
    //$fblinkedtwit->facebookStatusUpdate($status);

    //if (isset($_SESSION['twit_oauth_access_token']) && isset($_SESSION['twit_oauth_access_token_secret'])){
        $fblinkedtwit->twitterStatusUpdate($status, $config['twitter_access_token'], $config['twitter_access_token_secret']);
    //}

    //linkedin status update
    if (isset($_SESSION['requestToken']) && isset($_SESSION['oauth_verifier']) && isset($_SESSION['oauth_access_token'])){
        $fblinkedtwit->linkedinStatusUpdate($status, $_SESSION['requestToken'], $_SESSION['oauth_verifier'], $_SESSION['oauth_access_token']);
    }
}
?>
