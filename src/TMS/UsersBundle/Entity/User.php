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


}