<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Services\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    protected ContactService $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = $this->contactService->getAllContacts();
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contacts.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateContactRequest $request)
    {
        $this->contactService->createContact($request->validated());

        return redirect()->route('contacts.index')->with('success', 'Contact created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = $this->contactService->getContactById($id);
        return view('contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contact = $this->contactService->getContactById($id);
        return view('contacts.edit', compact('contact'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, string $id)
    {
        $contact = $this->contactService->updateContact($id, $request->validated());
        return redirect()->route('contacts.show', $contact->id)->with('success', 'O contato foi editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($this->contactService->deleteContact($id)) {
            $contacts = $this->contactService->getAllContacts();
            return redirect()->route('contacts.index', compact('contacts'))->with('success', 'O contato foi excluído  com sucesso!');
        }

        return back()->withErrors(['erro' => 'Erro ao deletar o contato']);
    }
}
