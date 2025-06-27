<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ContactService
{
     /**
     * Create a new contact.
     */
    public function createContact(array $data): Contact
    {
        return Contact::create($data);
    }

    /**
     * Get all contacts.
     */
    public function getAllContacts(): LengthAwarePaginator 
    {
        return Contact::orderBy('name', 'asc')->paginate(10);
    }

    /**
     * Get a contact by ID.
     *
     * @throws ModelNotFoundException
     */
    public function getContactById(int $id): Contact
    {
        return Contact::findOrFail($id);
    }

    /**
     * Update a contact.
     *
     * @throws ModelNotFoundException
     */
    public function updateContact(int $id, array $data): Contact
    {
        $contact = Contact::findOrFail($id);
        $contact->update($data);

        return $contact;
    }

    /**
     * Delete a contact.
     *
     * @throws ModelNotFoundException
     */
    public function deleteContact(int $id): bool
    {
        $contact = Contact::findOrFail($id);
        return $contact->delete();
    }
}