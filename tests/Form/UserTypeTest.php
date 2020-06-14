<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Test\TypeTestCase;

class UserTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'username' => 'username',
            'password' => ['first'=>'fakePassword','second'=>'fakePassword'],
            'email' => 'username@gmail.com',
            'role' => ['ROLE_USER'],
        ];

        $user = new User();
        $user->setUsername($formData['username'])
            ->setPassword($formData['password']['first'])
            ->setEmail($formData['email'])
            ->setRoles($formData['role']);
       
        $objectToCompare = new User();
        $objectToCompare->setRoles($formData['role']);
        
        $form = $this->factory->create(UserType::class, $objectToCompare); 
        $form->submit($formData);

        //dd($objectToCompare);
        static::assertTrue($form->isSynchronized()); 
        static::assertEquals($user->getUsername(), $objectToCompare->getUsername());
        static::assertEquals($user->getPassword(), $objectToCompare->getPassword());

        // Check the creation of the FormView. Should check if all widgets you want to display are available in the children property:
        $children = $form->createView()->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    
    }
}