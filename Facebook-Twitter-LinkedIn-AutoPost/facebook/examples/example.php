<?php
/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require '../src/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '592805714172914',
  'secret' => 'abafbdb0fff87482dac97c6f74f8edaa',
  'cookie' => true,
  'scope' => 'offline_access,read_stream,user_photos,user_videos,publish_stream,manage_pages',
  'req_perms' => 'publish_stream',
), $params);

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
    echo "name = " . $user_profile['name'] . "</br>";
    echo "id = ". $user_profile['id'] . "</br>";
    echo "link = ". $user_profile['link'] . "</br>";
      //$token is the access token from the URL above
       //$token = $facebook->getAccessToken(); 
      $post = array('access_token' => $token, 'message' => 'new test post demo  - ' . date('Y-m-d'));

      try{
      $res = $facebook->api('/me/feed','POST',$post);
      print_r($res);

      } catch (Exception $e){
          echo $e->getMessage();
      }
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $logoutUrl = 'logout.php';
} else {
  $loginUrl = $facebook->getLoginUrl();
}

// This call will always work since we are fetching public data.
//$naitik = $facebook->api('/naitik');

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>php-sdk</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <h1>php-sdk</h1>
    
    <?php if ($user): ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php else: ?>
      <div>
        Login using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>

    <h3>PHP Session</h3>
    <pre><?php print_r($_SESSION); ?></pre>

    <?php if ($user): ?>
      <h3>You</h3>
      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">

      <h3>Your User Object (/me)</h3>
      <pre><?php print_r($user_profile); ?></pre>
      <?php /*echo $user_profile['first_name'];*/ ?>
    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>

    <!--<h3>Public profile of Naitik</h3>
    <img src="https://graph.facebook.com/naitik/picture">-->
    <?php /*echo $naitik['name'];*/ ?>
  </body>
</html>
