<?php

set_time_limit(0);
date_default_timezone_set('UTC');

require __DIR__.'/../vendor/autoload.php';

/////// CONFIG ///////
$username = 'newtondevelopers';
$password = 'newtondevelopers123';
$debug = true;
$truncatedDebug = false;
// tocken generator
 $rankToken = \InstagramAPI\Signatures::generateUUID();

$ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);
$tofollow = 'newnyc_newton';

// login
$ig->login($username, $password);

$MyUsername = 8675318992;

 $loginResponse = $ig->login($username, $password);
 echo ($loginResponse);
//  get user id
 $userId = $ig->people->getUserIdForName($username);
 echo("my id is: ". $userId);
 //get a user's followers
 $getUserFollowers = $ig->people->getFollowers($userId, $rankToken);
 echo("my followers are:". $getUserFollowers);
 //follow a user 
 $followUserId = $ig->people->getUserIdForName($tofollow);
 $ig->people->follow($followUserId);
