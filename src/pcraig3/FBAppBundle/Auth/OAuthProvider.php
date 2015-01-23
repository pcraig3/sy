<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 19/01/2015
 * Time: 21:58
 */

namespace pcraig3\FBAppBundle\Auth;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

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

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {

        //Data from Facebook response
        $fid = $response->getUsername(); /* An ID like: 112259658235204980084 */
        $name = $response->getRealName();
        $avatar = $response->getProfilePicture();

        //set data in session
        /*$this->session->set('email', $email);
        $this->session->set('nickname', $nickname);
        $this->session->set('realname', $realname);
        $this->session->set('avatar', $avatar);*/

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