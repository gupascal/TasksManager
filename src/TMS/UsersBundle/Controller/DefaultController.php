<?php

namespace TMS\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use TMS\UsersBundle\Entity\User;
use TMS\UsersBundle\Form\Type\UserLogInType;
use TMS\UsersBundle\Form\Type\UserSignUpType;

class DefaultController extends Controller
{
    public function indexAction()
    {
		$em = $this->getDoctrine()->getManager();
	
		$signup_form = $this->createForm(new UserSignUpType(), new User());
		
		$signup_form->handleRequest($this->getRequest());
		
		if ($signup_form->isValid()) {
			$user = $signup_form->getData();
			if ($em->getRepository('TMSUsersBundle:User')->isNotRegistratedUser($user))
			{
				$factory = $this->get('security.encoder_factory');
				$encoder = $factory->getEncoder($user);
				$password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
				$user->setPassword($password);
				
				$em->persist($user);
				$em->flush();
			}
		}
		
        return $this->render('TMSUsersBundle:Default:index.html.twig', array('signup_form' => $signup_form->createView()));
    }
	
	public function loginAction()
	{
        $request = $this->getRequest();
        $session = $request->getSession();
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
		
		$login_form = $this->createForm(new UserLogInType(), new User(), array('action' => $this->generateUrl('login_check')));
		
        return $this->render('TMSUsersBundle:Default:login.html.twig', array(
			'login_form'    => $login_form->createView(),
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
	}
	
	public function dashboardAction()
    {
		$user = $this->getUser();
	
		$next_tasks = $this->getDoctrine()->getRepository('TMSTasksManagerBundle:Task')->findNextTasks($user->getUsername(), 5);
		$tasks_in_progress = $this->getDoctrine()->getRepository('TMSTasksManagerBundle:Task')->findTasksInProgress($user->getUsername(), 5);
	
        return $this->render('TMSUsersBundle:Default:dashboard.html.twig', array('next_tasks' => $next_tasks,
																				 'tasks_in_progress' => $tasks_in_progress));
    }
}
