<?php

class FbLinkedTwit {
    private $config                         =   array();

    public function __construct(){
        include_once "config.php";
        global $config;
        
        $this->config                       =   $config;
       
    }

    /* This function update facebook user's status */
    /* $id could be facebook page id, if null then session user is used */
    public function facebookStatusUpdate($status='', $id=''){
        include_once $this->config['facebook_library_path'];
        echo 'hiiiii';
        $facebook   =   new Facebook($this->config['fb_api'], $this->config['fb_secret']);
        $user       =   $facebook->api_client->user;
        //print_r($facebook);exit;
        if (empty($id))
            $id     =   $user;
        //echo $id;exit;
        if (!empty($id)){
            try{
                $status = $facebook->api_client->users_setStatus($status, $id);
                echo "Facebook status updated successfully!<br />";
            }
            catch(Exception $o){
                echo "<br />Facebook Status couldn't updated!</br>";
                print_r($o);
                echo '<br />';
            }
        }
    }

    /* This function update linkedin user's status */
    public function linkedinStatusUpdate($status='', $requestToken='', $oauthVerifier='', $accessToken=''){
        include_once $this->config['linkedin_library_path'];

        $linkedin = new LinkedIn($this->config['linkedin_access'], $this->config['linkedin_secret']);

        $linkedin->request_token    =   unserialize($requestToken);
        $linkedin->oauth_verifier   =   $oauthVerifier;
        $linkedin->access_token     =   unserialize($accessToken);

        try{
            $stat = $linkedin->setStatus($status);
            echo "Linkedin status updated successfully!<br />";
        }
        catch (Exception $o){
            echo "<br />Linkedin Status couldn't updated!</br>";
            print_r($o);
            echo '<br />';
        }
    }

    public function linkedinGetLoggedinUserInfo( $requestToken='', $oauthVerifier='', $accessToken=''){
        include_once $this->config['linkedin_library_path'];

        $linkedin = new LinkedIn($this->config['linkedin_access'], $this->config['linkedin_secret']);

        $linkedin->request_token    =   unserialize($requestToken); //as data is passed here serialized form
        $linkedin->oauth_verifier   =   $oauthVerifier;
        $linkedin->access_token     =   unserialize($accessToken);

        try{
            $xml_response = $linkedin->getProfile("~:(id,first-name,last-name,headline,picture-url,public-profile-url)");
        }
        catch (Exception $o){
            print_r($o);
        }
        return $xml_response;
    }

    /* This function update twitter user's status */
    public function twitterStatusUpdate($status='', $token='', $secret=''){
        include_once $this->config['twitter_library_path'];
 
       try {
            //$to = new TwitterOAuth($this->config['twitter_consumer'], $this->config['twitter_secret'], $token, $secret);
            $to = new TwitterOAuth($this->config['twitter_consumer'], $this->config['twitter_secret'], $token, $secret);

            $content = $to->post('statuses/update', array('status' => $status));

            echo "Twitter status updated successfull!<br />";
        }
        catch(Exception $o) {
            echo "<br />Twitter Status couldn't updated!</br>";
            print_r($o);
            echo '<br />';
        }
    }

    /*public function twitterGetLoggedinUserInfo($token='', $secret=''){
        include_once $this->config['twitter_library_path'];
        
        $data = '';

        try {
            $to = new TwitterOAuth($this->config['twitter_consumer'], $this->config['twitter_secret'], $token, $secret);
            
            $data     =   simplexml_load_string($to->OAuthRequest('http://api.twitter.com/1/account/verify_credentials.xml', '', 'GET'));
        }
        catch(Exception $o) {
            print_r($o);
        }
        return $data;
    }*/
}
?>
