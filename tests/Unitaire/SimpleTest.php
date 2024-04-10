<?php

namespace App\Tests\Unitaire;

use PHPUnit\Framework\TestCase;

class SimpleTest extends TestCase
{
    public function testAddition():void{

        $this->assertEquals(2,1+1);
    }

    public function testTrue():void{
        $age=rand(0, 100);
        if($age>18){
            $est_majeur = true;
            $this->assertTrue($est_majeur, 'Âge est > 18');
        } else {
            $est_majeur = false;
            $this->assertTrue($est_majeur, 'Âge est < 18');
        }
    }
}
