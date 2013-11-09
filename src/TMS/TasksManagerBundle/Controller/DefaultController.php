<?php

namespace TMS\TasksManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($userid)
    {
		$tasks = $this->getDoctrine()->getRepository('TMSTasksManagerBundle:Task')->findAllRunningTasksOrderedByDueDate($userid);
		
        return $this->render('TMSTasksManagerBundle:Default:index.html.twig', array('userid' => $userid, 'tasks' => $tasks));
    }
	
	public function showAction($userid, $taskid)
    {
		$task = $this->getDoctrine()->getRepository('TMSTasksManagerBundle:Task')->find($taskid, $userid);
		
        return $this->render('TMSTasksManagerBundle:Default:show.html.twig', array('userid' => $userid, 'tasks' => $task));
    }
}
