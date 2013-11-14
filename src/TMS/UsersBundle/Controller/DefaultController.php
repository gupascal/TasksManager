<?php

namespace TMS\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TMS\UsersBundle\Form\Type\UserLogInType;
use TMS\UsersBundle\Form\Type\UserSignUpType;

class DefaultController extends Controller
{
    public function indexAction()
    {
		$signup_form = $this->createForm(new UserSignUpType());
		$login_form = $this->createForm(new UserLogInType());
		
        return $this->render('TMSUsersBundle:Default:index.html.twig', array('signup_form' => $signup_form,
																			 'login_form' => $login_form));
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
