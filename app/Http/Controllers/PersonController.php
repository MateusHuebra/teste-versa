<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Rules\CPF;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('People/Index', [
            'people' => Person::all()->toArray()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : Response
    {
        return Inertia::render('People/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required|string|max:16',
            'last_name' => 'max:32',
            'gender' => ['required', 'in:male,female,other'],
            'birthday' => 'required|date|before:today',
            'cpf' => ['required', 'digits:11', 'unique:people', new CPF],
        ]);

        Person::create($request->all());

        return redirect(route('people', absolute: false));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): Response
    {
        $person = Person::findOrFail($id);
        return Inertia::render('People/Edit', [
            'person' => $person->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $person = Person::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:16',
            'last_name' => 'max:32',
            'gender' => ['required', 'in:male,female,other'],
            'birthday' => 'required|date|before:today',
            'cpf' => ['required', 'digits:11', "unique:people,cpf,{$id}", new CPF],
        ]);

        $person->update($request->all());

        return redirect(route('people', absolute: false));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): void
    {
        $person = Person::findOrFail($request->id);
        $person->delete();
        return;
    }
}
