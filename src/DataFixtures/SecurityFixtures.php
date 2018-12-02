<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = (new User())
            ->setEmail('user@test.com')
            ->setFirstName('Mr.')
            ->setLastName('Test')
            ->setAddress('Straatnaam 420')
            ->setZipCode('1337EZ')
            ->setCity('Litstad')
            ->setTelephone('0669696969');

        $user->setPassword($this->passwordEncoder->encodePassword($user, 'password'));

        $manager->persist($user);
        $manager->flush();
    }
}
