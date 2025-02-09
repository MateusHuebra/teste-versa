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

    public function test_person_edit_page_is_displayed(): void
    {
        $person = Person::factory()->create();
        $response = $this->get(route('people.edit', $person->id));

        $response->assertOk();
    }

    public function test_person_can_be_created(): void
    {
        $data = Person::factory()->make()->getAttributes();
        $response = $this->post(route('people.store'), $data);

        $response->assertRedirect(route('people'));
        $this->assertDatabaseHas('people', $data);
    }

    public function test_person_cant_be_created_with_invalid_date(): void
    {
        $data = Person::factory()->make([
            'birthday' => '3001-04-13',
        ])->getAttributes();
        $response = $this->post(route('people.store'), $data);

        $response->assertInvalid([
            'birthday' => 'The birthday field must be a date before today.'
        ]);
        $this->assertDatabaseMissing('people', $data);
    }

    public function test_person_cant_be_created_with_invalid_gender(): void
    {
        $data = Person::factory()->make([
            'gender' => 'alien',
        ])->getAttributes();
        $response = $this->post(route('people.store'), $data);

        $response->assertInvalid([
            'gender' => 'The selected gender is invalid.'
        ]);
        $this->assertDatabaseMissing('people', $data);
    }

    public function test_person_can_be_updated(): void
    {
        $person = Person::factory()->create();
        $updatedData = Person::factory()->make()->getAttributes();
        $response = $this->patch(route('people.update', $person->id), $updatedData);

        $response->assertRedirect(route('people'));
        $this->assertDatabaseMissing('people', $person->getAttributes());
        $this->assertDatabaseHas('people', $updatedData);
    }

    public function test_person_cant_be_updated(): void
    {
        $person = Person::factory()->create();
        $updatedData = Person::factory()->make([
            'cpf' => '11111111111'
        ])->getAttributes();
        $response = $this->patch(route('people.update', $person->id), $updatedData);

        $response->assertInvalid([
            'cpf' => 'Invalid CPF.'
        ]);
        $this->assertDatabaseMissing('people', $updatedData);
        $this->assertDatabaseHas('people', $person->getAttributes());
    }

    public function test_person_can_be_deleted(): void
    {
        $person = Person::factory()->create();
        $response = $this->delete(route('people.destroy', ['id' => $person->id]));

        $response->assertOk();
        $this->assertDatabaseMissing('people', $person->getAttributes());
    }
}
