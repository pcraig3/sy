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

    //returned after a successful facebook login
    private $accessToken;

    //used to call on the Facebook API
    private $facebookSession;

    function __construct($app_id, $app_secret) {

        $this->appId = $app_id;
        $this->appSecret = $app_secret;
    }

    function setAccessToken($accessToken) {

        if( is_null($accessToken) )
            throw new \Exception('Whoops, but I need a Facebook Access Token.');

        $this->accessToken = $accessToken;
    }

    function setAppSecret($newSecret) {

        $this->appSecret = $newSecret;
    }

    function getAppSecret() {

        return $this->appSecret;
    }

    function getFacebookSession($accessToken = null) {

        if( ! $this->accessToken )
            $this->setAccessToken($accessToken);

        FacebookSession::setDefaultApplication(
            $this->appId,
            $this->appSecret
        );

        if( ! $this->facebookSession )
            $this->facebookSession = new FacebookSession($this->accessToken);

        return $this->facebookSession;

    }

}