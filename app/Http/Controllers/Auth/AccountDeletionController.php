<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\Request;

class AccountDeletionController extends Controller
{
    public function __construct(private readonly AuthRepositoryInterface $authRepo) {}

    public function requestDeletion(Request $request)
    {
        $request->validate(['password' => 'required']);

        $success = $this->authRepo->requestAccountDeletion(
            $request->user(),
            $request->password
        );

        if (!$success) {
            return back()->withErrors(['password' => 'Password incorrect or failed to process request.']);
        }

        return back()->with('success', 'Email confirmation link has been sent.');
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'uid'   => 'required|integer',
            'token' => 'required|string'
        ]);

        $success = $this->authRepo->confirmAccountDeletion(
            $request->uid,
            $request->token
        );

        if (!$success) {
            abort(403, 'Invalid or expired account deletion token.');
        }

        return redirect('/')->with('success', 'Your account has been deleted.');
    }
}