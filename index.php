
<?php
// require_once  'db.php';
// $con = new db();
// $con->connect();
// echo "<pre>";
// var_dump($con->select());

// $pd = array(
//     "ptid"=>900,
//     "title"=>"Mr ",
//     "name"=>"James Mwangi",
//     "email"=>"nguru@inclusion.pro",
//     "phone"=>"+254722657526",
//     "dob"=> "1992-04-22",
//     "last_seen"=> "0000-00-00"
//   );
// var_dump($con->insert('tbl_pats',$pd,false));


// die;

require_once __DIR__ . '/vendor/autoload.php';


define('APPLICATION_NAME', 'Google Calendar API PHP Quickstart');
define('CREDENTIALS_PATH', '~/.credentials/calendar-php-quickstart.json');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/calendar-php-quickstart.json
define('SCOPES', implode(' ', array(
  Google_Service_Calendar::CALENDAR_READONLY)
));

if (php_sapi_name() != 'cli') {
  throw new Exception('This application must be run on the command line.');
}

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

  // Load previously authorized credentials from a file.
  $credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);
  if (file_exists($credentialsPath)) {
    $accessToken = json_decode(file_get_contents($credentialsPath), true);
  } else {
    // Request authorization from the user.
    $authUrl = $client->createAuthUrl();
    printf("Open the following link in your browser:\n%s\n", $authUrl);
    print 'Enter verification code: ';
    $authCode = trim(fgets(STDIN));

    // Exchange authorization code for an access token.
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

    // Store the credentials to disk.
    if(!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, json_encode($accessToken));
    printf("Credentials saved to %s\n", $credentialsPath);
  }
  $client->setAccessToken($accessToken);

  // Refresh the token if it's expired.
  if ($client->isAccessTokenExpired()) {
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
#   $refreshToken = $client->getRefreshToken();
#    $client->refreshToken($refreshToken);
#    $newAccessToken = $client->getAccessToken();
#    $newAccessToken['refresh_token'] = $refreshToken;
#    file_put_contents($credentialsPath, json_encode($newAccessToken));
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

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Calendar($client);

// Print the next 10 events on the user's calendar.
$calendarId = 'theperiodontistdc@gmail.com';
$optParams = array(
  'maxResults' => 30,
  'orderBy' => 'startTime',
  'singleEvents' => TRUE,
  'timeMin' => date('c'),
);
$results = $service->events->listEvents($calendarId, $optParams);

if (count($results->getItems()) == 0) {
  print "No upcoming events found.\n";
} else {
  print "Upcoming events:\n";
  foreach ($results->getItems() as $event) {
    $start = $event->start->dateTime;
    if (empty($start)) {
      $start = $event->start->date;
    }
   // printf("%s (%s)\n", $event->getSummary());

    // parse & send todays & tomorrows
    require_once 'parsetxt.php';
    sendtext($event->getSummary(),$event->getLocation(),$event->start->dateTime);


    // print_r($event);
    echo $event->getId().'\n';
    echo $event->getStatus().'\n';
    echo $event->getLocation().'\n';
    echo $event->getSummary().'\n';
echo $event->start->dateTime;
// var_dump($event['modelData']['start']['dateTime']).'\n';

    // status == confirmed
    // id
    // location 
  }
}

