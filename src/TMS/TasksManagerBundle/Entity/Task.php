<?php // src/TMS/TasksManagerBundle/Entity/Task.php
namespace TMS\TasksManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="TMS\TasksManagerBundle\Entity\TaskRepository")
 * @ORM\Table(name="tasks")
 */
class Task implements JsonSerializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	 protected $id;

    /**
     * @ORM\Column(type="string", length=100)
	 * @Assert\NotBlank()
     */
    protected $name;
	
	/**
	 * @ORM\Column(type="smallint")
	 * @Assert\Choice(callback = "getPriorities")
	 */
	protected $priority;
	
	/**
	 * @ORM\Column(type="datetime")
	 * @Assert\NotBlank()
	 * @Assert\Type("\DateTime")
	 */
	protected $due_date;
	
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date_started;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date_completed;
	
	 /**
     * @ORM\ManyToMany(targetEntity="Task", inversedBy="related_tasks")
     * @ORM\JoinTable(name="Tasks_dependencies",
     *      joinColumns={@ORM\JoinColumn(name="task_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="dep_task_id", referencedColumnName="id")}
     *      )
     */
	 protected $dep_tasks;
	 
	 /**
     * @ORM\ManyToMany(targetEntity="Task", mappedBy="dep_tasks")
     */
	 protected $related_tasks;
	
	/**
     * @ORM\ManyToOne(targetEntity="TMS\UsersBundle\Entity\User", inversedBy="tasks")
     * @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=false)
     */
	 protected $user;
	
	public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'name'=> $this->name,
			'priority'=> $this->priority,
			'due_date'=> $this->due_date,
			'description'=> $this->description,
			'date_started'=> $this->date_started,
			'date_completed'=> $this->date_completed
        );
    }
	
	
	public static function getPriorities()
    {
		return array("10" => 10, "9" => 9, "8" => 8, "7" => 7, "6" => 6, "5" => 5, "4" => 4, "3" => 3, "2" => 2, "1" => 1,
					 "0" => 0, "-1" => -1, "-2" => -2, "-3" => -3, "-4" => -4, "-5" => -5, "-6" => -6, "-7" => -7, "-8" => -8, "-9" => -9, "-10" => -10);
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
     * Set name
     *
     * @param string $name
     * @return Task
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
     * Set priority
     *
     * @param integer $priority
     * @return Task
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    
        return $this;
    }

    /**
     * Get priority
     *
     * @return integer 
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set due_date
     *
     * @param \DateTime $dueDate
     * @return Task
     */
    public function setDueDate($dueDate)
    {
        $this->due_date = $dueDate;
    
        return $this;
    }

    /**
     * Get due_date
     *
     * @return \DateTime 
     */
    public function getDueDate()
    {
        return $this->due_date;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Task
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date_started
     *
     * @param \DateTime $dateStarted
     * @return Task
     */
    public function setDateStarted($dateStarted)
    {
        $this->date_started = $dateStarted;
    
        return $this;
    }

    /**
     * Get date_started
     *
     * @return \DateTime 
     */
    public function getDateStarted()
    {
        return $this->date_started;
    }

    /**
     * Set date_completed
     *
     * @param \DateTime $dateCompleted
     * @return Task
     */
    public function setDateCompleted($dateCompleted)
    {
        $this->date_completed = $dateCompleted;
    
        return $this;
    }

    /**
     * Get date_completed
     *
     * @return \DateTime 
     */
    public function getDateCompleted()
    {
        return $this->date_completed;
    }

    /**
     * Set user
     *
     * @param \TMS\UsersBundle\Entity\User $user
     * @return Task
     */
    public function setUser(\TMS\UsersBundle\Entity\User $user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \TMS\UsersBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
		$this->priority = 0;
		$this->due_date = new \DateTime("tomorrow");
	
        $this->dep_tasks = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add dep_tasks
     *
     * @param \TMS\TasksManagerBundle\Entity\Task $depTasks
     * @return Task
     */
    public function addDepTask(\TMS\TasksManagerBundle\Entity\Task $depTasks)
    {
        $this->dep_tasks[] = $depTasks;
    
        return $this;
    }

    /**
     * Remove dep_tasks
     *
     * @param \TMS\TasksManagerBundle\Entity\Task $depTasks
     */
    public function removeDepTask(\TMS\TasksManagerBundle\Entity\Task $depTasks)
    {
        $this->dep_tasks->removeElement($depTasks);
    }

    /**
     * Get dep_tasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDepTasks()
    {
        return $this->dep_tasks;
    }

    /**
     * Add related_tasks
     *
     * @param \TMS\TasksManagerBundle\Entity\Task $relatedTasks
     * @return Task
     */
    public function addRelatedTask(\TMS\TasksManagerBundle\Entity\Task $relatedTasks)
    {
        $this->related_tasks[] = $relatedTasks;
    
        return $this;
    }

    /**
     * Remove related_tasks
     *
     * @param \TMS\TasksManagerBundle\Entity\Task $relatedTasks
     */
    public function removeRelatedTask(\TMS\TasksManagerBundle\Entity\Task $relatedTasks)
    {
        $this->related_tasks->removeElement($relatedTasks);
    }

    /**
     * Get related_tasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRelatedTasks()
    {
        return $this->related_tasks;
    }
}