<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Interfaces\ProfileRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(protected readonly ProfileRepositoryInterface $repository) {}

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $this->repository->update($request->validated());

        return redirect()->route('profile.edit')
            ->with('success', 'Profile updated successfully!');
    }
}