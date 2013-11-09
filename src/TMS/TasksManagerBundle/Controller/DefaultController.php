<?php

namespace TMS\TasksManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($username)
    {
		$tasks = $this->getDoctrine()->getRepository('TMSTasksManagerBundle:Task')->findAllRunningTasksOrderedByDueDate($username);
		
        return $this->render('TMSTasksManagerBundle:Default:index.html.twig', array('username' => $username, 'tasks' => $tasks));
    }
	
	public function showAction($username, $taskid)
    {
		$task = $this->getDoctrine()->getRepository('TMSTasksManagerBundle:Task')->find($taskid, $username);
		
        return $this->render('TMSTasksManagerBundle:Default:show.html.twig', array('username' => $username, 'tasks' => $task));
    }
}
