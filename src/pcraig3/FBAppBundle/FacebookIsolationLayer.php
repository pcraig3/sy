<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 29/01/2015
 * Time: 23:53
 */

namespace pcraig3\FBAppBundle;


use Facebook\FacebookRequest;
use Facebook\FacebookSession;

class FacebookIsolationLayer {

    //Given by Facebook when registering a new App
    private $appId;
    private $appSecret;

    function __construct($app_id, $app_secret) {

        $this->appId = $app_id;
        $this->appSecret = $app_secret;
    }

    public function returnFacebookSession($accessToken) {

        FacebookSession::setDefaultApplication(
            $this->appId,
            $this->appSecret
        );

        return new FacebookSession($accessToken);
    }

    public function returnGraphObject( $accessToken, $method = 'GET', $param = '/me' ) {

        $facebookSession = $this->returnFacebookSession($accessToken);

        $facebookRequest = new FacebookRequest($facebookSession, $method, $param);
        $facebookResponse = $facebookRequest->execute();
        return $facebookResponse->getGraphObject();
    }

}