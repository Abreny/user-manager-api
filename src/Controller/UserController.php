<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1")
 */
class UserController extends AbstractController
{
    private $manager;

    public function __construct(UserManager $userManager)
    {
        $this->manager = $userManager;
    }

    /**
     * @Route("/users", methods={"GET"}, name="app.users.index")
     */
    public function index(Request $request): Response
    {
        return $this->json($this->manager->getUsersForPagination($request->query->all()));
    }

    /**
     * @Route("/users", methods={"POST"}, name="app.users.create")
     */
    public function createUser(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->save($user);
            return $this->json($user);
        }
        // TODO: show form errors
        return $this->json("Form has an errors");
    }

    /**
     * @Route("/users/{id}", methods={"POST"}, name="app.users.update", requirements= { "id" = "[0-9]+" })
     */
    public function updateUser(Request $request, $id): Response
    {
        $user = $this->manager->getById($id);
        if (!$user) {
            return $this->json('USER NOT FOUND');
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->update($user);
            return $this->json($user);
        }
        //TODO: show form errors
        return $this->json("Form has an errors");
    }
}
