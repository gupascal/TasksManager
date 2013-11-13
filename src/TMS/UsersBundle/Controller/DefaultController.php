<?php

namespace TMS\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TMSUsersBundle:Default:index.html.twig');
    }
	
	public function dashboardAction($username)
    {
		$next_tasks = $this->getDoctrine()->getRepository('TMSTasksManagerBundle:Task')->findNextTasks($username, 5);
		$tasks_in_progress = $this->getDoctrine()->getRepository('TMSTasksManagerBundle:Task')->findTasksInProgress($username, 5);
	
        return $this->render('TMSUsersBundle:Default:dashboard.html.twig', array('username' => $username,
																				 'next_tasks' => $next_tasks,
																				 'tasks_in_progress' => $tasks_in_progress));
    }
}
