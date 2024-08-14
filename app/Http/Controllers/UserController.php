<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        return view('users.index', [
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        // return view for creating a new user
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the request from user
        // ...
        // Store the user
        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // Redirect to the users list
        return redirect('/users');
    }

    /**
     * Display the specified resource.
     * @return void
     */
    public function show(string $id): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @return View
     */
    public function edit(User $user): View
    {
        // return view for update user
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     * @return RedirectResponse
     */
    public function update(User $user): RedirectResponse
    {
        // Authorize the user
        // ...

        // Validate the request from user
        // ...
        // Update the user
        $user->update([
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
            'password' => request('password'),
        ]);

        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        // authorize the user
        // ...
        // Delete the user
        $user->delete();
        return redirect('/users');
    }
}
