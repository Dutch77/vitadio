<?php
/**
 * Created by PhpStorm.
 * User: Michal Kolář
 * Date: 19. 5. 2019
 * Time: 19:45
 */

namespace App\Service\Forum;

use App\Entity\Forum\Thread;
use App\Entity\User\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AccessManager
{
    const ADMIN_ROLE = 'admin';

    /**
     * @var
     */
    protected $tokenStorage;

    /**
     * AccessManager constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param Thread $thread
     *
     * @return bool
     */
    public function canAccessThread(Thread $thread): bool
    {
        if ($user = $this->getUser()) {
            if ($user->hasRole(self::ADMIN_ROLE)) {
                return true;
            }
            return $user->hasAccessToThread($thread);
        }
        return false;
    }

    /**
     * @return UserInterface|User|object|null
     */
    protected function getUser(): ?UserInterface
    {
        if ($token = $this->tokenStorage->getToken()) {
            $user = $token->getUser();
            if (is_object($user)) {
                return $user;
            }
        }
        return null;
    }
}