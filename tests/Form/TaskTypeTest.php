<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\Form\Test\TypeTestCase;

class TaskTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'title' => 'Titre',
            'content' => 'Contenu',
        ];

        $task = new Task();
        $task->setTitle($formData['title'])
            ->setContent($formData['content']);

        $objectToCompare = new Task();

        $form = $this->factory->create(TaskType::class, $objectToCompare); 
        $form->submit($formData);
        
        static::assertTrue($form->isSynchronized()); 
        static::assertEquals($task->getContent(), $objectToCompare->getContent());
        static::assertEquals($task->getTitle(), $objectToCompare->getTitle());

        // Check the creation of the FormView. Should check if all widgets you want to display are available in the children property:
        $children = $form->createView()->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    
    }
}