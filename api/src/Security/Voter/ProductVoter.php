<?php
namespace App\Security\Voter;

use App\Entity\Product;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class ProductVoter extends Voter
{

    const YOUR_CUSTOM_ACTION = 'custom_action';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        return true;
        // only vote on Product objects inside this voter
        if (!$subject instanceof Product) {
            return false;
        }

        // if the attribute isn't one we support, return false
//        if (!in_array($attribute, array(self::YOUR_CUSTOM_ACTION))) {
//            return false;
//        }

        return true;
    }


    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {


        return true;
        /**
         * @var $user User
         */
//        $user = $token->getUser();
//        if(!$user instanceOf User) {
//            return false;
//        }
//
//        if($this->security->isGranted('ROLE_ADMIN',$subject)) {
//            return true;
//        }
//
//        if($subject->getOwner() === $user) {
//            return true;
//        }




        return false;
    }

}
