<?php

namespace TMS\TasksManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TMSTasksManagerBundle:Default:index.html.twig', array('name' => $name));
    }
}
