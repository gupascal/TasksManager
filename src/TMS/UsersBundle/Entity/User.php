<?php // src/TMS/UsersBundle/Entity/User.php
namespace TMS\UsersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="TMS\UsersBundle\Entity\UserRepository")
 * @ORM\Table(name="users",
 * 			  uniqueConstraints={
 * 									@ORM\UniqueConstraint(name="email_idx", columns={"email"}),
 * 									@ORM\UniqueConstraint(name="username_idx", columns={"username"})
 * 								})
 */
class User
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
	protected $passwordHash;
	
	/**
     * @ORM\OneToMany(targetEntity="TMS\TasksManagerBundle\Entity\Task", mappedBy="user_id")
     */
	 protected $tasks;
	 
	 
	public function __construct()
    {
        $this->tasks = new ArrayCollection();
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
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set passwordHash
     *
     * @param string $passwordHash
     * @return User
     */
    public function setPasswordHash($passwordHash)
    {
        $this->passwordHash = $passwordHash;
    
        return $this;
    }

    /**
     * Get passwordHash
     *
     * @return string 
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
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
}