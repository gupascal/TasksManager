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
        return $this->render('TMSUsersBundle:Default:dashboard.html.twig', array('username' => $username));
    }
}
