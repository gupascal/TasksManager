<?php // src/TMS/TasksManagerBundle/Form/Type/TaskFiltersType.php
namespace TMS\TasksManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use TMS\TasksManagerBundle\Entity\Task;

class TaskFiltersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name_filter', 'choice', array("mapped" => false,
													 'choices' => array('contains' => 'contains',
																		'does_not_contain' => 'doesn\'t contain',
																		'begins_with' => 'begins with',
																		'ends_with' => 'ends with')))
				->add('name', 'text', array("mapped" => false,
											'required' => false))
				->add('priority_filter', 'choice', array("mapped" => false,
														 'choices' => array('is_greater_than' => 'is greater than',
																			'is_greater_or_equal_to' => 'is greater or equal to',
																			'is_equal_to' => 'is equal to',
																			'is_lower_or_equal_to' => 'is lower or equal to',
																			'is_lower_than' => 'is lower than')))
				->add('priority', 'choice', array("mapped" => false,
												  'required' => false,
												  'choices' => Task::getPriorities()))
				->add('due_date_filter', 'choice', array("mapped" => false,
														 'choices' => array('is_newer_than' => 'is newer than',
																			'is_older_than' => 'is older than')))
				->add('due_date', 'datetime', array("mapped" => false))
				->add('submit', 'submit');
    }

    public function getName()
    {
        return 'task_filters';
    }
}