<?php

namespace Tests\Feature;

use App\Models\Person;
use App\Models\User;
use Tests\TestCase;

class PersonTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_people_page_is_displayed(): void
    {
        $response = $this->get(route('people'));

        $response->assertOk();
    }

    public function test_person_can_be_created(): void
    {
        $data = [
            'first_name' => 'Mateus',
            'last_name' => 'Huebra',
            'gender' => 'male',
            'birthday' => '2001-04-13',
            'cpf' => '35271267083',
        ];

        $response = $this->post(route('people.store'), $data);

        $response->assertRedirect(route('people'));
        $this->assertDatabaseHas('people', $data);
    }

    public function test_person_cant_be_created_with_invalid_date(): void
    {
        $data = [
            'first_name' => 'Teste',
            'last_name' => '',
            'gender' => 'male',
            'birthday' => '3001-04-13',
            'cpf' => '53009489005',
        ];

        $response = $this->post(route('people.store'), $data);

        $response->assertInvalid([
            'birthday' => 'The birthday field must be a date before today.'
        ]);
        $this->assertDatabaseMissing('people', $data);
    }

    public function test_person_cant_be_created_with_invalid_gender(): void
    {
        $data = [
            'first_name' => 'Teste',
            'last_name' => '',
            'gender' => 'alien',
            'birthday' => '2001-04-13',
            'cpf' => '94653927073',
        ];

        $response = $this->post(route('people.store'), $data);

        $response->assertInvalid([
            'gender' => 'The selected gender is invalid.'
        ]);
        $this->assertDatabaseMissing('people', $data);
    }

    public function test_person_can_be_updated(): void
    {
        $data = [
            'first_name' => 'Test',
            'last_name' => '',
            'gender' => 'male',
            'birthday' => '2001-04-13',
            'cpf' => '47538248021',
        ];
        
        $updatedData = [
            'first_name' => 'Updated',
            'last_name' => 'Test',
            'gender' => 'male',
            'birthday' => '2001-08-23',
            'cpf' => '47538248021',
        ];

        $person = Person::create($data);
        $response = $this->patch(route('people.update', $person->id), $updatedData);

        $response->assertRedirect(route('people'));
        $this->assertDatabaseMissing('people', $data);
        $this->assertDatabaseHas('people', $updatedData);
    }

    public function test_person_cant_be_updated(): void
    {
        $data = [
            'first_name' => 'Test',
            'last_name' => '',
            'gender' => 'male',
            'birthday' => '2001-04-13',
            'cpf' => '94653927073',
        ];
        
        $updatedData = [
            'first_name' => 'Updated',
            'last_name' => 'Test',
            'gender' => 'male',
            'birthday' => '2001-08-23',
            'cpf' => '11111111111',
        ];

        $person = Person::create($data);
        $response = $this->patch(route('people.update', $person->id), $updatedData);

        $response->assertInvalid([
            'cpf' => 'Invalid CPF.'
        ]);
        $this->assertDatabaseMissing('people', $updatedData);
        $this->assertDatabaseHas('people', $data);
    }

    public function test_person_can_be_deleted(): void
    {
        $data = [
            'first_name' => 'Maria',
            'last_name' => '',
            'gender' => 'female',
            'birthday' => '1998-12-15',
            'cpf' => '94835392000',
        ];
        $person = Person::create($data);
        $response = $this->delete(route('people.destroy', ['id' => $person->id]));

        $response->assertOk();
        $this->assertDatabaseMissing('people', $data);
    }
}
