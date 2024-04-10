<?php

namespace App\Tests\Unitaire;

use PHPUnit\Framework\TestCase;

class SimpleTest extends TestCase
{
    public function testAddition():void{

        $this->assertEquals(2,1+1);
    }
}
