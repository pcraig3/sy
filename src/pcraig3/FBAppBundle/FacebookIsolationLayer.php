<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 29/01/2015
 * Time: 23:53
 */

namespace pcraig3\FBAppBundle;


use Facebook\FacebookSession;

class FacebookIsolationLayer {

    //Given by Facebook when registering a new App
    private $appId;
    private $appSecret;

    function __construct($app_id, $app_secret) {

        $this->appId = $app_id;
        $this->appSecret = $app_secret;
    }

    function getFacebookSession( $accessToken ) {

        FacebookSession::setDefaultApplication(
            $this->appId,
            $this->appSecret
        );

        return new FacebookSession($accessToken);
    }

}