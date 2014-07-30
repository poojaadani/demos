<?php
    session_start();
    require 'src/facebook.php';
    if(file_exists('config.php')){
    include_once "config.php";
    include_once "class.fblinkedtwit.php";
    
$fblinkedtwit   =   new FbLinkedTwit();
   $facebook = new Facebook(array(
  'appId'  => $config["fb_api"],
  'secret' => $config["fb_secret"],
  'cookie' => true,
  'scope' => 'offline_access,read_stream,user_photos,user_videos,publish_stream,manage_pages',
  'req_perms' => 'publish_stream',
), $params);

// Get User ID
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
            /*$post = array('access_token' => $token, 'message' => 'new test post demo  - ' . date('Y-m-d'));

            try{
            $res = $facebook->api('/me/feed','POST',$post);
            print_r($res);

            } catch (Exception $e){
                echo $e->getMessage();
            }*/
        } catch (FacebookApiException $e) {
          error_log($e);
          $user = null;
        }
      }

      if ($user) {
        $logoutUrl = $logoutUrl = 'logout.php';
      } else {
        $loginUrl = $facebook->getLoginUrl();
      }
    
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript">
        var baseUrl =   "<?=$config['base_url']?>";
    </script>
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
    <script src='http://connect.facebook.net/en_US/all.js'></script>
    <script type="text/javascript" src="javascript.js"></script>
  </head>
    <body style="color: black;">
      <div>
      <table border="0" cellspacing="3" cellpadding="3">
          <tr style="background-color: #ffffff">
              <td>
                  <div id="fb-root"></div>
                  <div id="login">
                      <?php if ($user){
                        echo '<b>Facebook Information</b><br />';
                        
                        echo "name = <a href='".$_SESSION['fb_userlink'] ."' >" . $_SESSION['fb_username'] . "</a></br>";
                        
                        } else{?>
                        <div>
                          <a href="<?php echo $loginUrl; ?>">Give Facebook Access</a>
                        </div>
                      <?php } ?>
                    <!--<fb:login-button v="2" size="large" length="long" onlogin="fbcloggedin();"></fb:login-button>-->
                  </div>
                  <div id="logout" style="display: none">
                      <b>Facebook Information</b><br />
                      <div style="width: 60px;float:left">
                          <fb:profile-pic uid="loggedinuser" facebook-logo="true" linked="true" ></fb:profile-pic>
                      </div>
                      <!--<div style="margin-left: 10px; float: left">
                          <fb:name uid="loggedinuser" linked="true" useyou="false" ></fb:name><br />
                          <a href="#" onclick="FB.Connect.logoutAndRedirect('<?=$config['base_url']?>')">Facebook Logout</a>
                      </div>-->
                      <div style="clear:both"></div>
                      <a target='_blank' href='https://graph.facebook.com/me/accounts?access_token=CAAVIa4bc7l0BAF5vDu0nNnsmHFzCIW34i7Vk1jvKpHNcZBFDWWSIzEhV1MsRzYppJo9LvV3ZAuMfpTZCpKNsP6wMoTU7MH92fkLxMQvgsDnB6HqEa0UtIZAlSKdV4P1pAuHg0pkP5QramRiZCh5rW6WSci7rP8ieKVIVuncswcKfXSFm4hqQXTdX0Y1Ltp7GcYHuRs4hv1ORZCLqxAW71cf9EYpQN9SOkZD'>Give Status Update Permission</a>
                      
                  </div>
              </td>
          </tr>
          <tr style="background-color: #ffffff">
              <td>
                  <div id="linkedinfo" style="display: block">
                    <?php
                        if (isset($_SESSION['requestToken']) && isset($_SESSION['oauth_verifier']) && isset($_SESSION['oauth_access_token'])){
                            echo '<b>Linkedin Information</b><br />';
                            $data = $fblinkedtwit->linkedinGetLoggedinUserInfo($_SESSION['requestToken'], $_SESSION['oauth_verifier'], $_SESSION['oauth_access_token']);

                            $data = simplexml_load_string($data);
                            ?>
                            <table border="0" cellspacing="3" cellpadding="3" style="font-size: 12px">
                                <tr><td>Name</td>          <td><a target="_blank" href="<?=$data->{'public-profile-url'}?>"><?=$data->{'first-name'}?> <?=$data->{'last-name'}?></a></td></tr>
                                <tr><td>Headline</td>      <td><?=$data->headline?></td></tr>
                                <tr><td>Profile Image</td> <td><img src="<?=$data->{'picture-url'}?>" alt="" /></td></tr>
                            </table>
                      <?php
                        }
                      ?>
                  </div>
                  <a href='<?=$config['base_url']?>/linkedin.php'>Give Linkedin Acces</a>
              </td>
          </tr>
      </table>
      </div>
      <div id="page">

    <h1>KamalDhari Group Search</h1>
    
          <form id="searchForm" method="post">
		<fieldset>
        
           	<input id="s" type="text" />
            
            <input type="submit" value="Submit" id="submitButton" />
            
            <div id="searchInContainer">
                <input type="radio" name="check" value="site" id="searchSite" checked/>
                <label for="searchSite" id="siteNameLabel">Search</label>
                
                <input type="radio" name="check" value="web" id="searchWeb" />
                <label for="searchWeb">Search The Web</label>
			</div>
                        
            <ul class="icons">
                <li class="web" title="Web Search" data-searchType="web">Web</li>
                <li class="images" title="Image Search" data-searchType="images">Images</li>
                <li class="news" title="News Search" data-searchType="news">News</li>
                <li class="videos" title="Video Search" data-searchType="video">Videos</li>
            </ul>
            
        </fieldset>
    </form>
          <div id="resultsDiv"></div>
<script src="script.js"></script>
   
          
          <!--<form name="fstat" id="fstat" action="<?=$config['base_url']?>/statusupdate.php" method="POST">
              Enter Your Status <span style="font-size: 10px">144 Chars Limit</span><br />
              <textarea name="status" id="status" rows="4" cols="60"></textarea><br />
              <span style="font-size:12px">(If you give all access then status will update in all sites. </span><br />
              <span style="font-size:12px">We can't update your status in a site if you don't give permission</span><br />
              <span style="font-size:12px">We don't need password for this)</span><br />
              <input type="button" onclick="ajaxCall(); return false;" value="Update Status" />
          </form>
          <br />-->
          <div id="loader" style="display:none">
              <img src="<?=$config['base_url']?>/loader.gif" alt="loader" />
          </div>
          <div id="result" style="width: 400px; height: 200px; overflow:auto;">

          </div>

      </div>
      <div style="clear:both"></div>
      <!--<div style="font-size: 14px; text-align: center">
        <a href="http://code.google.com/p/facebook-twitter-linkedin-status-update/wiki/introduction">Read about this project </a>
        <br />
        <a href="http://code.google.com/p/facebook-twitter-linkedin-status-update/">Download the code</a>
      </div>-->
    <script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script>
    <script type="text/javascript">
        //FB.init("<?=$config['fb_api']?>", "xd_receiver.htm", {"ifUserConnected" : fbcloggedin});
        FB.init({appId: "<?=$config['fb_api']?>", status: true, cookie: true, xfbml: true, oauth: true });
    </script>
  </body>
</html>
    <?php 
       }
    else {
        header('location: settings.php');
    }
 ?>