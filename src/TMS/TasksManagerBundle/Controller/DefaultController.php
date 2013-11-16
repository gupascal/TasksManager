<?php

namespace TMS\TasksManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TMS\TasksManagerBundle\Entity\Task;
use TMS\TasksManagerBundle\Form\Type\CreateTaskType;

class DefaultController extends Controller
{
    public function indexAction()
    {
		$user = $this->getUser();
	
		$tasks = $this->getDoctrine()->getRepository('TMSTasksManagerBundle:Task')->findAllRunningTasksOrderedByDueDate($user->getUsername());
		
        return $this->render('TMSTasksManagerBundle:Default:index.html.twig', array('tasks' => $tasks));
    }
	
	public function showAction($taskid)
    {
		$user = $this->getUser();
	
		$task = $this->getDoctrine()->getRepository('TMSTasksManagerBundle:Task')->findUserTask($user->getUsername(), $taskid);
		
		// Redirect if the task doesn't exist
		if ($task === null) {
			return $this->redirect($this->generateUrl('tms_tasks_manager_homepage'));
		}
		
        return $this->render('TMSTasksManagerBundle:Default:show.html.twig', array('task' => $task));
    }
	
	public function createAction()
	{
		$creation_form = $this->createForm(new CreateTaskType(), new Task());
		
		$creation_form->handleRequest($this->getRequest());
		
		if ($creation_form->isValid())
		{
			$task = $creation_form->getData();
			$task->setUser($this->getUser());
			$em = $this->getDoctrine()->getManager();
			$em->persist($task);
			$em->flush();
		}
		
		return $this->render('TMSTasksManagerBundle:Default:create.html.twig', array('creation_form' => $creation_form->createView()));
	}
}
