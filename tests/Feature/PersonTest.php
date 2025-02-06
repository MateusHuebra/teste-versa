<?php

namespace Tests\Feature;

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

    public function test_person_can_be_created(): void
    {
        $data = [
            'first_name' => 'Mateus',
            'last_name' => 'Huebra',
            'gender' => 'male',
            'birthday' => '2001-04-13',
            'cpf' => '12345678909',
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
            'cpf' => '12345678909',
        ];

        $response = $this->post(route('people.store'), $data);

        $response->assertInvalid([
            'birthday' => 'The birthday field must be a date before today.'
        ]);
        $this->assertDatabaseMissing('people', $data);
    }
}
