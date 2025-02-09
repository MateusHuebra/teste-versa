<?php

namespace Tests\Unit;

use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonFormattedAttributesTest extends TestCase
{
    use RefreshDatabase;
    private Person $person;

    public function setUp(): void
    {
        parent::setUp();

        $data = [
            'first_name' => 'Test',
            'last_name' => '',
            'gender' => 'male',
            'birthday' => '2001-04-13',
            'cpf' => '87718524094',
        ];    
        $this->person = Person::create($data);
    }

    public function test_birthday_formatted_correctly(): void
    {
        $this->assertEquals('2001-04-13', $this->person->birthday);
        $this->assertEquals('13/04/2001', $this->person->birthday_formatted);
    }

    public function test_cpf_formatted_correctly(): void
    {
        $this->assertEquals('87718524094', $this->person->cpf);
        $this->assertEquals('877.185.240-94', $this->person->cpf_formatted);
    }
}
