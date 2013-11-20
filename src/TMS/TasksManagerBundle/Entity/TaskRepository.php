<?php

namespace TMS\TasksManagerBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

/**
 * TaskRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TaskRepository extends EntityRepository
{
	private function whereUserIs(\Doctrine\ORM\QueryBuilder $qb, $username)
	{
		if ($username !== null) {
			$qb->innerJoin('TMS\UsersBundle\Entity\User', 'u', Join::WITH, 't.user = u.id')
				->andWhere('u.username = :username')
				->setParameter('username', $username);
		}
	}

	public function findAllRunningTasksOrderedByDueDate($username)
	{
		$qb = $this->createQueryBuilder('t');
		$this->whereUserIs($qb, $username);
		return $qb//->andWhere('t.date_completed IS NOT NULL')
					->orderBy('t.due_date', 'ASC')
					->getQuery()
					->getResult();
	}
	
	public function findUserTask($username, $taskid)
	{
		$qb = $this->createQueryBuilder('t');
		$this->whereUserIs($qb, $username);
		return $qb->andWhere('t.id = :id')
						->setParameter('id', $taskid)
						->getQuery()
						->getOneOrNullResult();
	}
	
	public function findNextTasks($username, $limit)
	{
		$qb = $this->createQueryBuilder('t');
		$this->whereUserIs($qb, $username);
		return $qb->andWhere('t.date_started IS NULL')
					->orderBy('t.due_date', 'ASC')
					//->setFirstResult($offset)
					->setMaxResults($limit)
					->getQuery()
					->getResult();
	}
	
	public function findTasksInProgress($username, $limit)
	{
		$qb = $this->createQueryBuilder('t');
		$this->whereUserIs($qb, $username);
		return $qb->andWhere('t.date_started IS NOT NULL')
					->andWhere('t.date_completed IS NULL')
					->orderBy('t.due_date', 'ASC')
					//->setFirstResult($offset)
					->setMaxResults($limit)
					->getQuery()
					->getResult();
	}
	
	// public function hasUncompletedDependances($username, $taskid)
	// {
		// $qb = $this->createQueryBuilder('t')
					// ->innerJoin('t.dep_tasks', 'dt');
		// $this->whereUserIs($qb, $username);
		// return $qb->andWhere('t.id = :id')
						// ->setParameter('id', $taskid)
						// ->getQuery()
						// ->getOneOrNullResult();
	// }
	
	public function taskHasValidDueDate($task)
	{
		// Check the due date regarding tasks that depend of the current task
		$qb = $this->createQueryBuilder('t')
					->innerJoin('t.related_tasks', 'rt');
		$res = $qb->where('t.id = :id')
					->setParameter('id', $task->getId())
					->andWhere('rt.due_date <= :dueDate')
					->setParameter('dueDate', $task->getDueDate())
					->orderBy('rt.due_date', 'ASC')
					->setMaxResults(1)
					->getQuery()
					->getOneOrNullResult();
		
		if ($res !== null)
			return false;
	
		// Check the due date regarding the current task and its own dependencies
		$dep_tasks = $task->getDepTasks();
		$dep_tasks_id = array();
		foreach ($dep_tasks as $dt) {
			$dep_tasks_id[] = $dt->getId();
		}
		if ($dep_tasks_id === array())
			return true;
		
		$qb = $this->createQueryBuilder('t');
		$res = $qb->where($qb->expr()->in('t.id', ':ids'))
						->setParameter('ids', $dep_tasks_id)
						->orderBy('t.due_date', 'DESC')
						->setMaxResults(1)
						->getQuery()
						->getOneOrNullResult();
						
		return ($res === null ||  $task->getDueDate() > $res->getDueDate());
	}
}
