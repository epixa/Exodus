<?php
define('ROOT_PATH', dirname(dirname(__FILE__)));

set_include_path(implode(PATH_SEPARATOR, array(
    ROOT_PATH . '/library',
    get_include_path()
)));

require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance()->registerNamespace('Zend_');

$frontendOptions = array(
   'lifetime' => 120,
   'automatic_serialization' => true
);

$backendOptions = array(
    'cache_dir' => ROOT_PATH . '/cache/'
);

$cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);

if(($body = $cache->load('court_friends')) === false) {
    $request = new HttpRequest('http://api.twitter.com/1/statuses/friends.json', HttpRequest::METH_GET);
    $request->setQueryData(array(
        'screen_name' => 'courtewing'
    ));
    $response = $request->send();
    $body = $response->getBody();
    $cache->save($body, 'court_friends');
    var_dump('retrieved fresh');
}

$followers = json_decode($body);
/*array_walk($followers, function(&$follower){
    $newFollower = new stdClass();
    $newFollower->id = $follower->id;
    $newFollower->alias = $follower->screen_name;
    $newFollower->name = $follower->name;
    $newFollower->totalTweets = $follower->statuses_count;
    $follower = $newFollower;
});*/

var_dump($followers);