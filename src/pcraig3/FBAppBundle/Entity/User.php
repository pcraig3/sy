<?php

namespace pcraig3\FBAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUser;

/**
 * User
 *
 * @ORM\Table(name="pcraig3_user")
 * @ORM\Entity(repositoryClass="pcraig3\FBAppBundle\Entity\UserRepository")
 */
class User extends OAuthUser implements EquatableInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_id", type="string", length=255, unique=true)
     */
    private $facebookId;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true)
     */
    private $facebookAccessToken = null;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="roles", type="json_array")
     */
    private $roles = array();

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=32)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_messaged", type="boolean")
     */
    private $isMessaged = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_updated", type="boolean")
     */
    private $isUpdated = true;


    /**
     * make me a new user!
     */
    public function __construct($fid)
    {
        $this->facebookId = $fid;

        $this->salt = md5(uniqid(null, true));
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set facebookId
     *
     * @param string $facebookId
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string 
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Method calls 'setFacebookID'
     * @param string $facebookId
     * @return User
     */
    public function setUsername($facebookId)
    {
        $this->setFacebookId($facebookId);

        return $this;
    }

    /**
     * Method calls 'getFacebookID'
     *
     * @return string $facebookId
     */
    public function getUsername()
    {
        return $this->getFacebookId();
    }

    /**
     * Set facebookAccessToken
     *
     * @param string $facebookAccessToken
     * @return User
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebookAccessToken = $facebookAccessToken;

        return $this;
    }

    /**
     * Get facebookAccessToken
     *
     * @return string 
     */
    public function getFacebookAccessToken()
    {
        return $this->facebookAccessToken;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param string $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set isMessaged
     *
     * @param boolean $isMessaged
     * @return User
     */
    public function setIsMessaged($isMessaged)
    {
        $this->isMessaged = $isMessaged;

        return $this;
    }

    /**
     * Get isMessaged
     *
     * @return boolean 
     */
    public function getIsMessaged()
    {
        return $this->isMessaged;
    }

    /**
     * Set isUpdatd
     *
     * @param boolean $isUpdated
     * @return User
     */
    public function setIsUpdatd($isUpdated)
    {
        $this->isUpdated = $isUpdated;

        return $this;
    }

    /**
     * Get isUpdated
     *
     * @return boolean 
     */
    public function getIsUpdated()
    {
        return $this->isUpdated;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->facebookId,
            $this->name,
        ));
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->facebookId,
            $this->name,
        ) = unserialize($serialized);
    }

    /**
     * Also implementation should consider that $user instance may implement
     * the extended user interface `AdvancedUserInterface`.
     *
     * @param UserInterface $user
     *
     * @return bool
     */
    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof User) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }

    /**
     * Method that overrrides the equals method in OAuthUser.
     * Reason is because we don't want this class to have a username
     * Wrapper for the 'isEqualTo' function
     *
     * @param UserInterface $user
     * @return bool
     */
    public function equals(UserInterface $user)
    {
        return $this->isEqualTo($user);
    }
}
