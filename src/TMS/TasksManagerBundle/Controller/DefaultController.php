<?php

namespace TMS\TasksManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
