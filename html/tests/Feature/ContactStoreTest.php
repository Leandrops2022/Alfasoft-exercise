<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactStoreTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;

    // Set up an authenticated user for tests that require authentication
    protected function setUp(): void
    {
        parent::setUp();
        // Create a user and authenticate for protected routes
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }
    
    public function test_it_requires_name_when_storing_contact()
    {
        $response = $this->post(route('contacts.store'), [
            'name' => '', // Invalid: empty name
            'contact' => '123456789',
            'email_address' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseMissing('contacts', ['email_address' => 'test@example.com']);
    }

    public function test_it_requires_contact_when_storing_contact()
    {
        $response = $this->post(route('contacts.store'), [
            'name' => 'Valid Name',
            'contact' => '', // Invalid: empty contact
            'email_address' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors('contact');
        $this->assertDatabaseMissing('contacts', ['email_address' => 'test@example.com']);
    }

    public function test_it_requires_email_address_when_storing_contact()
    {
        $response = $this->post(route('contacts.store'), [
            'name' => 'Valid Name',
            'contact' => '123456789',
            'email_address' => '', // Invalid: empty email
        ]);

        $response->assertSessionHasErrors('email_address');
        $this->assertDatabaseMissing('contacts', ['contact' => '123456789']);
    }

    public function test_name_must_be_at_least_6_characters_when_storing_contact()
    {
        $response = $this->post(route('contacts.store'), [
            'name' => 'Short', // Invalid: less than 6 chars
            'contact' => '123456789',
            'email_address' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseMissing('contacts', ['email_address' => 'test@example.com']);
    }

    public function test_contact_must_be_exactly_9_digits_when_storing_contact()
    {
        $response = $this->post(route('contacts.store'), [
            'name' => 'Valid Name',
            'contact' => '12345', // Invalid: not 9 digits
            'email_address' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors('contact');
        $this->assertDatabaseMissing('contacts', ['email_address' => 'test@example.com']);

        $response = $this->post(route('contacts.store'), [
            'name' => 'Valid Name',
            'contact' => '1234567890', // Invalid: more than 9 digits
            'email_address' => 'test2@example.com',
        ]);

        $response->assertSessionHasErrors('contact');
        $this->assertDatabaseMissing('contacts', ['email_address' => 'test2@example.com']);
    }

    public function test_email_address_must_be_valid_when_storing_contact()
    {
        $response = $this->post(route('contacts.store'), [
            'name' => 'Valid Name',
            'contact' => '123456789',
            'email_address' => 'invalid-email', // Invalid: not a valid email format
        ]);

        $response->assertSessionHasErrors('email_address');
        $this->assertDatabaseMissing('contacts', ['contact' => '123456789']);
    }

    public function test_contact_must_be_unique_when_storing_contact()
    {
        Contact::factory()->create(['contact' => '987654321']);

        $response = $this->post(route('contacts.store'), [
            'name' => 'New Name',
            'contact' => '987654321', // Invalid: already taken
            'email_address' => 'new@example.com',
        ]);

        $response->assertSessionHasErrors('contact');
        $this->assertDatabaseMissing('contacts', ['email_address' => 'new@example.com']);
    }

    public function test_email_address_must_be_unique_when_storing_contact()
    {
        Contact::factory()->create(['email_address' => 'existing@example.com']);

        $response = $this->post(route('contacts.store'), [
            'name' => 'New Name',
            'contact' => '111222333',
            'email_address' => 'existing@example.com', // Invalid: already taken
        ]);

        $response->assertSessionHasErrors('email_address');
        $this->assertDatabaseMissing('contacts', ['contact' => '111222333']);
    }

    public function test_can_create_contact_with_valid_data()
    {
        $response = $this->post(route('contacts.store'), [
            'name' => 'John Doe Contact',
            'contact' => '999888777',
            'email_address' => 'john@example.com',
        ]);

        $response->assertRedirect(route('contacts.index'));
        $response->assertSessionHas('success', 'Contact created successfully!');
        $this->assertDatabaseHas('contacts', [
            'name' => 'John Doe Contact',
            'contact' => '999888777',
            'email_address' => 'john@example.com',
        ]);
    }

}
