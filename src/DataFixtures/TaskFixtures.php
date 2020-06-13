<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\DataFixtures\UserFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // anonyme tasks
        for ($i = 0; $i <= 11; $i++) {
            $task = new Task();
            $task->setTitle('Tache n°' . $i);
            $task->setContent('Contenue de la tache n°'. $i);
            $task->setCreatedAt(new \DateTime());

            if (in_array($i, [0,2])){
                $task->setAuthor($this->getReference(UserFixtures::USER_REFERENCE.$i));
            } 
            elseif (in_array($i, [1,3])) {
                $task->setAuthor($this->getReference(UserFixtures::ADMIN_REFERENCE.$i));
                }
                 else {
                    $task->setAuthor(null);
                }
            $manager->persist($task);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }

}
