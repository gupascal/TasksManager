<?php // src/TMS/UsersBundle/Entity/User.php
namespace TMS\UsersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="TMS\UsersBundle\Entity\UserRepository")
 * @ORM\Table(name="users",
 * 			  uniqueConstraints={
 * 									@ORM\UniqueConstraint(name="email_idx", columns={"email"}),
 * 									@ORM\UniqueConstraint(name="nick_idx", columns={"nick"})
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
    protected $nick;
	
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
     * Set nick
     *
     * @param string $nick
     * @return User
     */
    public function setNick($nick)
    {
        $this->nick = $nick;
    
        return $this;
    }

    /**
     * Get nick
     *
     * @return string 
     */
    public function getNick()
    {
        return $this->nick;
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
     * @param \TMS\UsersBundle\Entity\Task $tasks
     * @return User
     */
    public function addTask(\TMS\UsersBundle\Entity\Task $tasks)
    {
        $this->tasks[] = $tasks;
    
        return $this;
    }

    /**
     * Remove tasks
     *
     * @param \TMS\UsersBundle\Entity\Task $tasks
     */
    public function removeTask(\TMS\UsersBundle\Entity\Task $tasks)
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