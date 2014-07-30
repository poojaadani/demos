<?php

//Include facebook class (make sure your path is correct)
require '../src/facebook.php';
//Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '592805714172914',
  'secret' => 'abafbdb0fff87482dac97c6f74f8edaa',
	  'cookie' => true,
));
 
//$token is the access token from the URL above
$post = array('access_token' => $token, 'message' => 'new test post - ' . date('Y-m-d'));
 
try{
$res = $facebook->api('/me/feed','POST',$post);
print_r($res);
 
} catch (Exception $e){
    echo $e->getMessage();
}
?>
