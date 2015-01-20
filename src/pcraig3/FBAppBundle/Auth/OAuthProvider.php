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

use pcraig3\FBAppBundle\Entity\User;


class OAuthProvider extends OAuthUserProvider
{
    protected $session, $doctrine, $admins;

    public function __construct($session, $doctrine, $service_container)
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
        $qb = $this->doctrine->getManager()->createQueryBuilder();
        $qb->select('u')
            ->from('FBAppBundle:User', 'u')
            ->where('u.facebookId = :fid')
            ->setParameter('fid', $fid )
            ->setMaxResults(1);
        $result = $qb->getQuery()->getResult();

        if (count($result)) {

            return $result[0];
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
        $qb = $this->doctrine->getManager()->createQueryBuilder();
        $qb->select('u')
            ->from('FBAppBundle:User', 'u')
            ->where('u.facebookId = :fid')
            ->setParameter('fid', $fid )
            ->setMaxResults(1);
        $result = $qb->getQuery()->getResult();

        //add to database if doesn't exists
        if (!count($result)) {

            $user = new User( $fid );
            $user->setName( $name );
            //$user->setRoles('ROLE_USER');

            //Set some wild random pass since its irrelevant, this is Facebook login
            $factory = $this->container->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword(md5(uniqid()), $user->getSalt());
            $user->setPassword($password);

            $em = $this->doctrine->getManager();
            $em->persist($user);
            $em->flush();
        } else {

            $user = $result[0]; /* return User */
        }

        //set id
        $this->session->set('id', $user->getId());

        return $this->loadUserByUsername($response->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'pcraig3\\FBAppBundle\\Entity\\User';
    }
}