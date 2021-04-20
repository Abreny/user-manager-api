<?php
namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserManager {

    /**
     * @var UserRepository;
     */
    private $userRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    /**
     * Get all users from database
     * @return User[]
     */
    public function getUsers($pagination = [])
    {
        return $this->userRepository->findAll();
    }

    /**
     * Get all users from database
     * 
     * @return array
     */
    public function getUsersForPagination($pagination = [])
    {
        $results = $this->userRepository->findAllPaginate($pagination);
        return ['users' => $results['content'], 'total' => $results['total']];
    }
    
    /**
     * Get an user by id
     * 
     * @return User
     */
    public function getById($id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * Save an user
     * 
     * @return User
     */
    public function save(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }

    /**
     * Update an user
     * 
     * @return User
     */
    public function update(User $user)
    {
        $this->em->flush();
        return $user;
    }
}