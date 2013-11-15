<?php // src/TMS/UsersBundle/Entity/User.php
namespace TMS\UsersBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * @ORM\Entity(repositoryClass="TMS\UsersBundle\Entity\UserRepository")
 * @ORM\Table(name="users",
 * 			  uniqueConstraints={
 * 									@ORM\UniqueConstraint(name="email_idx", columns={"email"}),
 * 									@ORM\UniqueConstraint(name="username_idx", columns={"username"})
 * 								})
 */
class User implements UserInterface, \Serializable
{
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	 protected $id;
	 
	 /**
     * @ORM\Column(type="string", length=127)
     */
	protected $email;

    /**
     * @ORM\Column(type="string", length=30)
     */
    protected $username;
	
	/**
     * @ORM\Column(type="string", length=255)
     */
	protected $password;
	
	/**
     * @ORM\Column(type="string", length=32)
     */
    private $salt;
	
	/**
     * @ORM\OneToMany(targetEntity="TMS\TasksManagerBundle\Entity\Task", mappedBy="user")
     */
	 protected $tasks;
	 
	 
	public function __construct()
    {
        $this->tasks = new ArrayCollection();
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
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Get username
     *
	 * @inheritDoc
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
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
	 * @inheritDoc
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
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
	 * @inheritDoc
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Add tasks
     *
     * @param \TMS\TasksManagerBundle\Entity\Task $tasks
     * @return User
     */
    public function addTask(\TMS\TasksManagerBundle\Entity\Task $tasks)
    {
        $this->tasks[] = $tasks;
    
        return $this;
    }

    /**
     * Remove tasks
     *
     * @param \TMS\TasksManagerBundle\Entity\Task $tasks
     */
    public function removeTask(\TMS\TasksManagerBundle\Entity\Task $tasks)
    {
        $this->tasks->removeElement($tasks);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTasks()
    {
        return $this->tasks;
    }
	
	/**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

   /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }
	
	public function isEqualTo(UserInterface $user)
	{
		return $this->username === $user->getUsername();
	}
}