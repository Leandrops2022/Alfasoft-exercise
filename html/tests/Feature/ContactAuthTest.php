<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ContactAuthTest extends TestCase
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

    public function test_guest_cannot_access_protected_contact_routes()
    {
        // Log out the user for this specific test
        Auth::logout();

        // Attempt to access create form
        $this->get(route('contacts.create'))
             ->assertRedirect(route('login'));

        // Attempt to post to store
        $this->post(route('contacts.store'), [])
             ->assertRedirect(route('login'));

        // Create a dummy contact for update/delete tests
        $contact = Contact::factory()->create();

        // Attempt to access edit form
        $this->get(route('contacts.edit', $contact->id))
             ->assertRedirect(route('login'));

        // Attempt to put to update
        $this->put(route('contacts.update', $contact->id), [])
             ->assertRedirect(route('login'));

        // Attempt to delete
        $this->delete(route('contacts.destroy', $contact->id))
             ->assertRedirect(route('login'));
    }
}
