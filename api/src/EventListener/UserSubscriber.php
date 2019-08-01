<?php
namespace App\EventListener;


use App\Entity\User;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserSubscriber implements EventSubscriberInterface
{
    private $passwordEncoder;

    /**
     * UserSubscriber constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [ KernelEvents::VIEW => ['encodePassword', EventPriorities::PRE_WRITE]];
    }

    /**
     * @param ViewEvent $event
     */
    public function encodePassword(ViewEvent $event)
    {
        $user = $event->getControllerResult();
        if (!$user instanceof User || ($user instanceof User && $user->plainPassword === null)) {
            return;
        }
        $password = $this->passwordEncoder->encodePassword($user, $user->plainPassword);
        $user->setPassword($password);

        $user->eraseCredentials();
    }
}
