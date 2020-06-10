<?php

namespace App\Security\Voter;

use App\Entity\Task;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TaskVoter extends Voter
{
    private const DELETE = 'TASK_DELETE';
    private const DELETE_ANONYME = 'TASK_DELETE_ANONYME';

    protected function supports($attribute, $subject)
    {
        return in_array($attribute, [Self::DELETE, Self::DELETE_ANONYME])
            && $subject instanceof Task;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case Self::DELETE:
                return $user === $subject->getAuthor();
                break;
            case Self::DELETE_ANONYME:
                //l'auteur est vide et le user est un admin
                //dd($subject->getAuthor(),$user->getRoles());
                if ($subject->getAuthor() === 'anonyme' && in_array("ROLE_ADMIN", $user->getRoles())) {
                    return true;
                } else { return false; }
                break;
        }

        return false;
    }
}
