<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 29/01/2015
 * Time: 03:25
 */

namespace pcraig3\FBAppBundle;

use Facebook\FacebookSession;

/**
 * There must be a better way to do this
 *
 * Class FacebookFactory
 * @package pcraig3\FBAppBundle
 */
class FacebookFactory {

    function __construct($app_id, $app_secret)
    {
        FacebookSession::setDefaultApplication($app_id, $app_secret);
    }

    //method either returns a session of holds onto it
    //probably the first one if we're keeping this as a factory
}