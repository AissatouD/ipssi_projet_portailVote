<?php


namespace App\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;


class SecurityRepository extends EntityRepository implements UserLoaderInterface
{

    /**
     * @param string $username
     * @return mixed|\Symfony\Component\Security\Core\User\UserInterface|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.firstname = :username OR u.email = :email')
            ->setParameter('firstname', $username)
            ->setParameter('mail', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
}