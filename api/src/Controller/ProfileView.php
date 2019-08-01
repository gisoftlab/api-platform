<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProfileView
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Security("is_authenticated()")
     *
     * @Route(
     *     name="me_view",
     *     path="/profile/me",
     *     methods={"GET"},
     *     defaults={"_api_item_operation_name"="view_myself"}
     * )
     *
     * @return User
     */
    public function __invoke()
    {
        return $this->tokenStorage->getToken()->getUser();
    }
}
