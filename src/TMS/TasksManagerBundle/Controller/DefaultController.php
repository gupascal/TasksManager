<?php

namespace TMS\TasksManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
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
			
			// Check due date
			if ($this->getDoctrine()->getRepository('TMSTasksManagerBundle:Task')->taskHasValidDueDate($task))
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($task);
				$em->flush();
			}
			
			return $this->redirect($this->generateUrl('tms_tasks_manager_homepage'));
		}
		
		return $this->render('TMSTasksManagerBundle:Default:create.html.twig', array('creation_form' => $creation_form->createView()));
	}
	
	public function editAction($taskid)
	{
		$user = $this->getUser();
	
		$task = $this->getDoctrine()->getRepository('TMSTasksManagerBundle:Task')->findUserTask($user->getUsername(), $taskid);
	
		$edit_form = $this->createForm(new CreateTaskType(), $task);
		
		$edit_form->handleRequest($this->getRequest());
		
		if ($edit_form->isValid())
		{
			$task = $edit_form->getData();
			$task->setUser($this->getUser());
			
			// Check due date
			if ($this->getDoctrine()->getRepository('TMSTasksManagerBundle:Task')->taskHasValidDueDate($task))
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($task);
				$em->flush();
			}
			
			return $this->redirect($this->generateUrl('tms_tasks_manager_homepage'));
		}
		
		return $this->render('TMSTasksManagerBundle:Default:edit.html.twig', array('edit_form' => $edit_form->createView()));
	}
	
	public function startTaskAction()
	{
		$request = $this->container->get('request');
		
		if(!$request->isXmlHttpRequest()) {
			return $this->redirect($this->generateUrl('tms_tasks_manager_homepage'));
		}
		
		$id = (int)$request->request->get('taskid');
	
		$user = $this->getUser();
	
		$task = $this->getDoctrine()->getRepository('TMSTasksManagerBundle:Task')->findUserTask($user->getUsername(), $id);
		$task->setDateStarted(new \DateTime("now"));
		$em->persist($task);
		$em->flush();
		
		$response = array('taskid' => $id, 'date_started' => $task->getDateStarted());
		return new Response(json_encode($response));
	}
	
	public function completeTaskAction()
	{
		$request = $this->container->get('request');
		
		if(!$request->isXmlHttpRequest()) {
			return $this->redirect($this->generateUrl('tms_tasks_manager_homepage'));
		}
		
		$id = (int)$request->request->get('taskid');
	
		$user = $this->getUser();
	
		$task = $this->getDoctrine()->getRepository('TMSTasksManagerBundle:Task')->findUserTask($user->getUsername(), $id);
		if ($task->getDateStarted() !== null) {
			$task->setDateCompleted(new \DateTime("now"));
		}
		$em->persist($task);
		$em->flush();
		
		$response = array('taskid' => $id, 'date_completed' => $task->getDateCompleted());
		return new Response(json_encode($response));
	}
	
	public function deleteAction($taskid)
	{
		$user = $this->getUser();
		$em = $this->getDoctrine()->getManager();
	
		$task = $em->getRepository('TMSTasksManagerBundle:Task')->findUserTask($user->getUsername(), $taskid);
		
		if ($task !== null)
		{
			$em->remove($task);
			$em->flush();
		}
		return $this->redirect($this->generateUrl('tms_tasks_manager_homepage'));
	}
	
	
	public function addDependenciesFormAction()
	{
		$request = $this->container->get('request');
		
		if(!$request->isXmlHttpRequest()) {
			return $this->redirect($this->generateUrl('tms_tasks_manager_homepage'));
		}
		
		$id = (int)$request->request->get('taskid');
		
		$user = $this->getUser();
		$em = $this->getDoctrine()->getManager();
	
		$task = $em->getRepository('TMSTasksManagerBundle:Task')->findUserTask($user->getUsername(), $id);
		$deps = $em->getRepository('TMSTasksManagerBundle:Task')->findPossibleDependencies($user->getUsername(), $task);

		// serialize all entities
		$serializedTasks = array();
		foreach ($deps as $task) {
			$serializedTasks[] = json_encode($task);
		}
		
		$response = array('taskid' => $id, 'deps' => $serializedTasks);
		return new Response(json_encode($response)); 
	}
	
	public function addDependenciesAction()
	{
		$request = $this->container->get('request');

		if(!$request->isXmlHttpRequest()) {
			return $this->redirect($this->generateUrl('tms_tasks_manager_homepage'));
		}
		
		$id = (int)$request->request->get('taskid');
		$new_deps = $request->request->get('new_deps');
		
		$user = $this->getUser();
		$em = $this->getDoctrine()->getManager();
		$task = $em->getRepository('TMSTasksManagerBundle:Task')->findUserTask($user->getUsername(), $id);
		
		foreach ($new_deps as $new_dep) {
			$task->addDepTask($em->getRepository('TMSTasksManagerBundle:Task')->findUserTask($user->getUsername(), $new_dep));
		}
		
		$em->persist($task);
		$em->flush();
		
		$response = array('taskid' => $id, 'deps' => $deps);
		return new Response(json_encode($response)); 
	}
	
	public function removeDependenciesAction()
	{
		$request = $this->container->get('request');

		if(!$request->isXmlHttpRequest()) {
			return $this->redirect($this->generateUrl('tms_tasks_manager_homepage'));
		}
		
		$id = (int)$request->request->get('taskid');
		$dep_id = (int)$request->request->get('dep_id');
		
		$user = $this->getUser();
		$em = $this->getDoctrine()->getManager();
		$task = $em->getRepository('TMSTasksManagerBundle:Task')->findUserTask($user->getUsername(), $id);
		$task->removeDepTask($em->getRepository('TMSTasksManagerBundle:Task')->findUserTask($user->getUsername(), $dep_id));
		
		$em->persist($task);
		$em->flush();
		
		$response = array('taskid' => $id);
		return new Response(json_encode($response));
	}
}
