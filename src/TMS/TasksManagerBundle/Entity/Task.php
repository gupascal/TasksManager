<?php // src/TMS/TasksManagerBundle/Entity/Task.php
namespace TMS\TasksManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="TMS\TasksManagerBundle\Entity\TaskRepository")
 * @ORM\Table(name="tasks")
 */
class Task
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	 protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;
	
	/**
	 * @ORM\Column(type="smallint")
	 */
	protected $priority;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $due_date;
	
    /**
     * @ORM\Column(type="text")
     */
    protected $description;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $date_started;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $date_completed;
	

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
     * Set date_begin
     *
     * @param \DateTime $dateBegin
     * @return Task
     */
    public function setDateBegin($dateBegin)
    {
        $this->date_begin = $dateBegin;
    
        return $this;
    }

    /**
     * Get date_begin
     *
     * @return \DateTime 
     */
    public function getDateBegin()
    {
        return $this->date_begin;
    }

    /**
     * Set date_end
     *
     * @param \DateTime $dateEnd
     * @return Task
     */
    public function setDateEnd($dateEnd)
    {
        $this->date_end = $dateEnd;
    
        return $this;
    }

    /**
     * Get date_end
     *
     * @return \DateTime 
     */
    public function getDateEnd()
    {
        return $this->date_end;
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
}