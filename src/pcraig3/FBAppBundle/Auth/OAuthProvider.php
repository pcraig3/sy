<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 19/01/2015
 * Time: 21:58
 */

namespace pcraig3\FBAppBundle\Auth;

use Facebook\FacebookRequest;
use Facebook\FacebookSession;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Bundle\DoctrineBundle\Registry;

use pcraig3\FBAppBundle\Entity\User;


class OAuthProvider extends OAuthUserProvider
{
    protected $session, $doctrine, $admins;

    public function __construct(Session $session, Registry $doctrine, $service_container)
    {
        $this->session = $session;
        $this->doctrine = $doctrine;
        $this->container = $service_container;
    }

    /**
     * @param string $fid
     * @return User
     */
    public function loadUserByUsername( $fid )
    {
        //Check if this Facebook user already exists in our app DB
        $result = $this->returnUserByFacebookId( $fid );

        if ( $result ) {

            return $result;
        } else {

            return new User( $fid );
        }
    }

    /**
     * @param UserResponseInterface $response
     * @return User
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        /*
        Data from Facebook response, for example:

        array(
          "id" => "10152739996332675"
          "email" => "paul_craig_16@hotmail.com"
          "first_name" => "Paul"
          "gender" => "male"
          "last_name" => "Craig"
          "link" => "https://www.facebook.com/app_scoped_user_id/10152739996332675/"
          "locale" => "en_GB"
          "name" => "Paul Craig"
          "timezone" => -5
          "updated_time" => "2014-11-03T20:35:28+0000"
          "verified" => true
        )
        */
        $raw_response = $response->getResponse();

        foreach ( $raw_response as $key => $value)
            $this->session->set('response/' . $key, $value);

        $fid = $this->session->get('response/id'); /* A Facebook ID like: 10152739996332675 */
        $name = $this->session->get('response/name');

        FacebookSession::setDefaultApplication(
            $this->container->getParameter('facebook_app_id'),
            $this->container->getParameter('facebook_app_secret')
        );

        $facebookSession = new FacebookSession( $response->getAccessToken() );

        //set a facebook session in our session
        $this->session->set('response/facebookSession', $facebookSession);
        $this->session->set('response/token', $response->getAccessToken());

        $facebookRequest = new FacebookRequest($facebookSession, 'GET', '/me');
        $facebookResponse = $facebookRequest->execute();
        $graphObject = $facebookResponse->getGraphObject();

        $this->session->set('response/graphObject', $graphObject);

        //Check if this Facebook user already exists in our app DB
        $result = $this->returnUserByFacebookId( $fid );

        //add to database if doesn't exists
        if (! $result ) {

            $user = $this->createNewUser( $fid, $name );

            $em = $this->doctrine->getManager();
            $em->persist($user);
            $em->flush();
        } else {

            $user = $result; /* return User */
        }

        //set id
        $this->session->set('id', $user->getId());

        return $this->loadUserByUsername($response->getUsername());
    }

    private function createNewUser( $fid, $name, $is_admin = false ) {

        $newUser = new User( $fid );

        //set name
        $newUser->setName( $name );

        //set roles
        $roles = array( 'ROLE_USER' );

        if( true === $is_admin )
            array_push( $roles, 'ROLE_ADMIN' );

        $newUser->setRoles( $roles );

        //set (irrelevant) password since this is Facebook login
        $factory = $this->container->get('security.encoder_factory');
        $encoder = $factory->getEncoder($newUser);
        $password = $encoder->encodePassword(md5(uniqid()), $newUser->getSalt());
        $newUser->setPassword($password);


        return $newUser;
    }

    private function returnUserByFacebookId( $fid ) {

        return $this->doctrine->getManager()
            ->getRepository('FBAppBundle:User')->findOneByFacebookId( $fid );
    }

    public function supportsClass($class)
    {
        return $class === 'pcraig3\\FBAppBundle\\Entity\\User';
    }
}