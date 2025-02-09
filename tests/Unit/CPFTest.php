<?php

namespace Tests\Unit;

use App\Rules\CPF;
use PHPUnit\Framework\TestCase;

class CPFTest extends TestCase
{
    
    public function test_valid(): void
    {
        $rule = new CPF();

        $rule->validate('cpf', '12345678909', function() {
            $this->assertTrue(false);
        });

        $this->assertTrue(true);
    }
    
    public function test_invalid_by_formula(): void
    {
        $rule = new CPF();
        $failed = false;

        $rule->validate('cpf', '12345678911', function($errorMessage) use (&$failed) {
            $this->assertEquals('Invalid CPF.', $errorMessage);
            $failed = true;
        });
        
        $this->assertTrue($failed);
    }
    
    public function test_invalid_by_length(): void
    {
        $rule = new CPF();
        $failed = false;

        $rule->validate('cpf', '123456789110', function($errorMessage) use (&$failed) {
            $this->assertEquals('The cpf field must be 11 digits.', $errorMessage);
            $failed = true;
        });
        
        $this->assertTrue($failed);
    }
    
    public function test_invalid_by_repeated_digits(): void
    {
        $rule = new CPF();
        $failed = false;

        $rule->validate('cpf', '11111111111', function($errorMessage) use (&$failed) {
            $this->assertEquals('Invalid CPF.', $errorMessage);
            $failed = true;
        });
        
        $this->assertTrue($failed);
    }
}
