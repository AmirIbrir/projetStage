<?php

namespace App\Tests\Unit;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    public function testEntityIsValid(): void
    {
        $kernel = self::bootKernel();
        $container = static::getContainer();

        $user = new User();
        $user->setEmail('User #1')
            ->setPassword('password #1')
            ->setRoles([]);

        $errors = $container->get('validator')->validate($user);

        $this->assertCount(0, $errors);

    }
}
