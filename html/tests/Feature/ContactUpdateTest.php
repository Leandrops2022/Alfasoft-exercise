<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactUpdateTest extends TestCase
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

    public function test_it_requires_name_when_updating_contact()
    {
        $contact = Contact::factory()->create();

        $response = $this->put(route('contacts.update', $contact->id), [
            'name' => '', // Invalid: empty name
            'contact' => '123456789',
            'email_address' => 'update@example.com',
        ]);

        $response->assertSessionHasErrors('name');
        // Ensure the original contact's name was not updated
        $this->assertDatabaseHas('contacts', ['id' => $contact->id, 'name' => $contact->name]);
    }

    public function test_name_must_be_at_least_6_characters_when_updating_contact()
    {
        $contact = Contact::factory()->create();

        $response = $this->put(route('contacts.update', $contact->id), [
            'name' => 'Short', // Invalid: less than 6 chars
            'contact' => '123456789',
            'email_address' => 'update@example.com',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseHas('contacts', ['id' => $contact->id, 'name' => $contact->name]);
    }

    public function test_contact_must_be_exactly_9_digits_when_updating_contact()
    {
        $contact = Contact::factory()->create();

        $response = $this->put(route('contacts.update', $contact->id), [
            'name' => 'Valid Name',
            'contact' => '12345', // Invalid: not 9 digits
            'email_address' => 'update@example.com',
        ]);

        $response->assertSessionHasErrors('contact');
        $this->assertDatabaseHas('contacts', ['id' => $contact->id, 'contact' => $contact->contact]);
    }

    public function test_email_address_must_be_valid_when_updating_contact()
    {
        $contact = Contact::factory()->create();

        $response = $this->put(route('contacts.update', $contact->id), [
            'name' => 'Valid Name',
            'contact' => '123456789',
            'email_address' => 'invalid-email', // Invalid: not a valid email format
        ]);

        $response->assertSessionHasErrors('email_address');
        $this->assertDatabaseHas('contacts', ['id' => $contact->id, 'email_address' => $contact->email_address]);
    }

    public function test_contact_must_be_unique_when_updating_contact()
    {
        $contact1 = Contact::factory()->create(['contact' => '111111111']);
        $contact2 = Contact::factory()->create(['contact' => '222222222']);

        // Try to update contact1's contact to contact2's contact
        $response = $this->put(route('contacts.update', $contact1->id), [
            'name' => 'Updated Name',
            'contact' => $contact2->contact, // Invalid: already taken by contact2
            'email_address' => $contact1->email_address, // Keep original email
        ]);

        $response->assertSessionHasErrors('contact');
        // Ensure contact1 was not updated
        $this->assertDatabaseHas('contacts', ['id' => $contact1->id, 'contact' => '111111111']);
    }

    public function test_email_address_must_be_unique_when_updating_contact()
    {
        $contact1 = Contact::factory()->create(['email_address' => 'one@example.com']);
        $contact2 = Contact::factory()->create(['email_address' => 'two@example.com']);

        // Try to update contact1's email to contact2's email
        $response = $this->put(route('contacts.update', $contact1->id), [
            'name' => 'Updated Name',
            'contact' => $contact1->contact, // Keep original contact
            'email_address' => $contact2->email_address, // Invalid: already taken by contact2
        ]);

        $response->assertSessionHasErrors('email_address');
        // Ensure contact1 was not updated
        $this->assertDatabaseHas('contacts', ['id' => $contact1->id, 'email_address' => 'one@example.com']);
    }

    public function test_can_update_contact_with_its_own_unique_values()
    {
        $contact = Contact::factory()->create([
            'name' => 'Original Name',
            'contact' => '123456789',
            'email_address' => 'original@example.com',
        ]);

        // Update contact with its own values (should pass unique check due to ignore)
        $response = $this->put(route('contacts.update', $contact->id), [
            'name' => 'Updated Name',
            'contact' => '123456789', // Same as original, but should be ignored
            'email_address' => 'original@example.com', // Same as original, but should be ignored
        ]);

        $response->assertRedirect(route('contacts.show', $contact->id));
        $response->assertSessionHas('success', 'O contato foi editado com sucesso!');
        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => 'Updated Name', // This part should be updated
            'contact' => '123456789',
            'email_address' => 'original@example.com',
        ]);
    }

    public function test_can_update_contact_with_new_valid_unique_values()
    {
        $contact = Contact::factory()->create([
            'name' => 'Original Name',
            'contact' => '123456789',
            'email_address' => 'original@example.com',
        ]);

        $response = $this->put(route('contacts.update', $contact->id), [
            'name' => 'Updated Name New',
            'contact' => '987654321', // New valid contact
            'email_address' => 'new-updated@example.com', // New valid email
        ]);

        $response->assertRedirect(route('contacts.show', $contact->id));
        $response->assertSessionHas('success', 'O contato foi editado com sucesso!');
        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => 'Updated Name New',
            'contact' => '987654321',
            'email_address' => 'new-updated@example.com',
        ]);
    }
}
