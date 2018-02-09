<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);




define('APPLICATION_NAME', 'Upstream client');

define('CREDENTIALS_PATH', __DIR__ .'/credentials/calendar-php-quickstart.json');
define('CLIENT_SECRET_PATH',  __DIR__ .'/credentials/client_secret.json');


// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/calendar-php-quickstart.json
define('SCOPES', implode(' ', array(
  Google_Service_Calendar::CALENDAR)
));

// if (php_sapi_name() != 'cli') {
//   throw new Exception('This application must be run on the command line.');
// }

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient() {
  $client = new Google_Client();
  $client->setApplicationName(APPLICATION_NAME);
  $client->setScopes(SCOPES);
  $client->setAuthConfig(CLIENT_SECRET_PATH);
  $client->setAccessType('offline');
  $client->setApprovalPrompt('force');
  $client->setRedirectUri('https://upsteam.89.ee/order-confirm');

  // Load previously authorized credentials from a file.
  $credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);
  //echo $credentialsPath;exit;
  if (file_exists($credentialsPath)) {
    $accessToken = json_decode(file_get_contents($credentialsPath), true);
  } else {
    // Request authorization from the user.
//    $authUrl = $client->createAuthUrl();
    printf("Open the following link in your browser:\n%s\n", $authUrl);
    print 'Enter verification code: ';
    $authCode = trim('4/LXwm3mDWkARADDYBJh-EpV6jL21MXzWkgJSm6d0qaTE');

    // Exchange authorization code for an access token.
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
    
	
    // Store the credentials to disk.
    if(!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, json_encode($accessToken));
    printf("Credentials saved to %s\n", $credentialsPath);
  }
//print_r($accessToken);exit;
  $client->setAccessToken($accessToken);

  // Refresh the token if it's expired.
  if ($client->isAccessTokenExpired()) {
  	
  // save refresh token to some variable
        $refreshTokenSaved = $client->getRefreshToken();

        // update access token
        $client->fetchAccessTokenWithRefreshToken($refreshTokenSaved);

        // pass access token to some variable
        $accessTokenUpdated = $client->getAccessToken();

        // append refresh token
        $accessTokenUpdated['refresh_token'] = $refreshTokenSaved;

        //Set the new acces token
        $accessToken = $refreshTokenSaved;
        $client->setAccessToken($accessToken);

        // save to file
        file_put_contents($credentialsPath, 
       json_encode($accessTokenUpdated));
  
  
  
    //$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    //file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
  }
  return $client;
}

/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */
function expandHomeDirectory($path) {
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
  }
  return str_replace('~', realpath($homeDirectory), $path);
}

?>