<?php // src/TMS/TasksManagerBundle/Form/Type/CreateTaskType.php
namespace TMS\TasksManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use TMS\TasksManagerBundle\Entity\Task;

class CreateTaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
				->add('priority', 'number')
				->add('due_date', 'datetime')
				->add('description', 'textarea')
				->add('dep_tasks', 'entity', array('class' => 'TMSTasksManagerBundle:Task',
												'property' => 'name',
												'multiple' => true,
												/*'expanded' => true*/))
				->add('submit', 'submit');
    }

    public function getName()
    {
        return 'task_create';
    }
}