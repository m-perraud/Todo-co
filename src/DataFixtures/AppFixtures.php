<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @codeCoverageIgnore
 */
class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Création de 3 utilisateurs
        for ($i = 1; $i <= 3; ++$i) {
            $user = new User();
            $user->setUsername($faker->word())
                ->setRoles(['ROLE_ADMIN'])
                ->setPassword($this->userPasswordHasher->hashPassword($user, 'AppFixturesPass'))
                ->setEmail($faker->email());

            $manager->persist($user);
            $manager->flush();

            // Création de 10 tâches par utilisateur
            for ($h = 1; $h <= 10; ++$h) {
                $task = new Task();
                $task->setCreatedAt(new \DateTime())
                    ->setTitle($faker->word())
                    ->setContent($faker->text())
                    ->setAuthor($user)
                    ->setIsDone($faker->randomElement([true, false]));

                $manager->persist($task);
                $manager->flush();
            }
        }

        // Création utilisateur anonyme
        $user = new User();
        $user->setUsername('anonyme')
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->userPasswordHasher->hashPassword($user, 'AppFixturesPass'))
            ->setEmail($faker->email());

        $manager->persist($user);
        $manager->flush();

        // Création de 5 tâches pour anonyme
        for ($h = 1; $h <= 5; ++$h) {
            $task = new Task();
            $task->setCreatedAt(new \DateTime())
                ->setTitle($faker->word())
                ->setContent($faker->text())
                ->setAuthor($user)
                ->setIsDone($faker->randomElement([true, false]));

            $manager->persist($task);
            $manager->flush();
        }

        // Création utilisateur admin
        $user = new User();
        $user->setUsername('admin')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->userPasswordHasher->hashPassword($user, 'AppFixturesPass'))
            ->setEmail($faker->email());

        $manager->persist($user);
        $manager->flush();
    }
}
