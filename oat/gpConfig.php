<?php
if(!session_id()){
    session_start();
}

// Include Google API client library
require_once 'google-api-php-client/Google_Client.php';
require_once 'google-api-php-client/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
$clientId = '875688751535-oleiqa9e1f7joc74h3el1a5et4e9m0kt.apps.googleusercontent.com';
$clientSecret = 'zAibb9Cqhjz4iauzZIpQIbzP';
$redirectURL = 'https://veh.nettech.ga/oat/'; //Callback URL

// Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login to CodexWorld.com');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
