<?php

namespace TMS\UsersBundle\Entity;

use Doctrine\ORM\EntityRepository;
use TMS\UsersBundle\Entity\User;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
	/*
	* @return true if User is not yet registrated. false if an user with
	* the same name or the same email is already registrated.
	*/
	public function isNotRegistratedUser(User $user)
	{
		$qb = $this->createQueryBuilder('u');
		$res = $qb->where('u.username = :username')
					->setParameter('username', $user->getUsername())
					->orWhere('u.email = :email')
					->setParameter('email', $user->getEmail())
					->getQuery()
					->getOneOrNullResult();
		return $res === null;
	}
}
