<?php
if(file_exists('config.php')){
   header('location:index.php');
}
?>
<link rel="stylesheet" type="text/css" href="admin/style.css"/>
<div style="width: 100%">

	<h2>
		 <img src="admin/images/facebook-logo.png" height="16px"> Facebook Settings
	</h2>
	
	
	<table class="widefat" style="width: 99%;background-color: #FFFBCC">
	<tr>
	<td id="bottomBorderNone">
	
	
	</td>
	</tr>
	</table>
	
	<form method="post">
		<input type="hidden" value="config">
                             
			<div style="font-weight: bold;padding: 3px;">All fields given below are mandatory</div> 
			<table class="widefat xyz_smap_widefat_table" style="width: 99%">
				<tr valign="top">
					<td width="50%">AppID
					</td>
					<td><input id="fb_app_id"
						name="fb_app_id" type="text"
						value="" />
					</td>
				</tr>

				<tr valign="top">
					<td>AppSecret
						
					</td>
					<td><input id="fb_app_secret"
						name="fb_app_secret" type="text"
						value=""/>
					</td>
				</tr>
				
			</table>

	


	<h2>
		 <img	src="admin/images/twitter-logo.png" height="16px"> Twitter Settings
	</h2>
	


<table class="widefat" style="width: 99%;background-color: #FFFBCC">
<tr>
<td id="bottomBorderNone">
	
</td>
</tr>
</table>


	
		<input type="hidden" value="config">



			<div style="font-weight: bold;padding: 3px;">All fields given below are mandatory</div> 
			<table class="widefat xyz_smap_widefat_table" style="width: 99%">
				<tr valign="top">
					<td width="50%">Access Token
					</td>
					<td><input id="twapp_id"
						name="twapp_id" type="text"
						value="" />
					</td>
				</tr>

				<tr valign="top">
					<td>Access Token secret
					</td>
					<td><input id="twapp_secret"
						name="twapp_secret" type="text"
						value="" />
					</td>
				</tr>
				<tr valign="top">
					<td>Consumer Key
					</td>
					<td><input id="tw_access_token" class="al2tw_text"
						name="tw_access_token" type="text"
						value="" />
					</td>
				</tr>
				<tr valign="top">
					<td>Consumer Secret
					</td>
					<td><input id="tw_access_token_secret" class="al2tw_text"
						name="tw_access_token_secret" type="text"
						value="" />
					</td>
				</tr>
			</table>

<h2>
		  General Settings
	</h2>
	


<table class="widefat" style="width: 99%;background-color: #FFFBCC">
<tr>
<td id="bottomBorderNone">
	
</td>
</tr>
</table>


	
		<input type="hidden" value="config">



			<div style="font-weight: bold;padding: 3px;">All fields given below are mandatory</div> 
			<table class="widefat xyz_smap_widefat_table" style="width: 99%">
				<tr valign="top">
					<td width="50%">Application Title
					</td>
					<td><input id="app_title"
						name="app_title" type="text"
						value="" />
					</td>
				</tr>

				<tr valign="top">
					<td>Base URL
					</td>
					<td><input id="base_url"
						name="base_url" type="text"
						value="" />
					</td>
				</tr>
				<tr valign="top">
					<td>CallBack URL
					</td>
					<td><input id="callback_url" class="al2tw_text"
						name="callback_url" type="text"
						value="" />
					</td>
				</tr>
			</table>
	

	
	<h2>
		 <img	src="admin/images/linkedin.gif" height="16px"> Linkedin Settings
	</h2>
    <table class="widefat" style="width: 99%;background-color: #FFFBCC">
<tr>
<td id="bottomBorderNone">
	
</td>
</tr>
</table>
    
	
	

	<div style="font-weight: bold;padding: 3px;">All fields given below are mandatory</div> 
	
	<table class="widefat xyz_smap_widefat_table" style="width: 99%">
	<tr valign="top">
	<td width="50%">API Key </td>					
	<td>
		<input id="lnk_appkey" name="lnk_appkey" type="text" value=""/>
	</td></tr>
	

	<tr valign="top"><td>API Secret</td>
	<td>
		<input id="lnk_appsecret" name="lnk_appsecret" type="text" value="" />
	</td></tr>
	
		<tr>
			<td   id="bottomBorderNone"></td>
					<td   id="bottomBorderNone"><div style="height: 50px;">
							<input type="submit" class="submit_smap_new"
								style=" margin-top: 10px; "
								name="update" value="UpdateAllSetting" /></div>
					</td>
				</tr>

</table>


</form>

		
</div>		
<?php
if(isset($_POST['update']))
{
    $fbappid = $_POST['fb_app_id'];
    $fbappsecret = $_POST['fb_app_secret'];
    $twappkey = $_POST['twapp_id'];
    $twappsecret = $_POST['twapp_secret'];
    $twaccesstkn = $_POST['tw_access_token'];
    $twaccesstknsecret = $_POST['tw_access_token_secret'];
    $lnkappkey = $_POST['lnk_appkey'];
    $lnkappsecret = $_POST['lnk_appsecret'];
    $base_url = $_POST['base_url'];
    $callback_url = $_POST['callback_url'];
    $title = $_POST['app_title'];
    
    $file = 'config.php';
    $fi = fopen($file, "w+");
    $code = "<?php /*General Configuration*/ ";
    $code .= '$config["app_title"] = "'.$title.'"; ';
    $code .= '$config["base_url"] = "'.$base_url.'"; ';
    $code .= '$config["callback_url"] = "'.$callback_url.'";  /*Facebook Configuration*/ ';
    $code .= '$config["fb_api"] = "'.$fbappid.'"; ';
    $code .= '$config["fb_secret"] = "'.$fbappsecret.'"; ';
    $code .= '$config["facebook_library_path"] = "facebook/facebook.php";  /*LinkedIn Configuration*/ ';
    $code .= '$config["linkedin_access"] = "'.$lnkappkey.'"; ';
    $code .= '$config["linkedin_secret"] = "'.$lnkappsecret.'"; ';
    $code .= '$config["linkedin_library_path"] = "linkedin_twitter/linkedinoAuth.php";  /*Twitter Configuration*/ ';
    $code .= '$config["twitter_consumer"] = "'.$twaccesstkn.'"; ';
    $code .= '$config["twitter_secret"] = "'.$twaccesstknsecret.'"; ';
    $code .= '$config["twitter_access_token"] = "'.$twappkey.'"; ';
    $code .= '$config["twitter_access_token_secret"] = "'.$twappsecret.'"; ';
    $code .= '$config["twitter_library_path"] = "linkedin_twitter/twitteroauth.php"; ';
    $code .= " ?>";
    fwrite($fi,$code);
    // fopen($file, "w+");
    fclose($fi);
    if(file_exists('config.php')){
        header('location:index.php');
     }
}
?>




