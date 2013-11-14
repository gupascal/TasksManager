<?php

namespace TMS\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TMS\UsersBundle\Entity\User;
use TMS\UsersBundle\Form\Type\UserLogInType;
use TMS\UsersBundle\Form\Type\UserSignUpType;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
	
		$signup_form = $this->createForm(new UserSignUpType(), new User());
		$login_form = $this->createForm(new UserLogInType(), new User());
		
		$signup_form->handleRequest($request);
		
		if ($signup_form->isValid()) {
			$signup = $signup_form->getData();
			$em->persist($signup->getUser());
			$em->flush();
		}
		
        return $this->render('TMSUsersBundle:Default:index.html.twig', array('signup_form' => $signup_form->createView(),
																			 'login_form' => $login_form->createView()));
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
