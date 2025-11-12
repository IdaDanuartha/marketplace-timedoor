<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\AccountDeletionConfirmation as MailAccountDeletionConfirmation;
use App\Models\AccountDeletionToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class AccountDeletionController extends Controller
{
    // send email containing signed url + one-time token
    public function requestDeletion(Request $request)
    {
        $user = $request->user();

        $request->validate(['password' => 'required']);
        if (!password_verify($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password incorrect.']);
        }

        // generate token sekali pakai (disimpan dalam bentuk hash)
        $rawToken = Str::random(40);

        AccountDeletionToken::updateOrCreate(
            ['user_id' => $user->id],
            ['token_hash' => hash('sha256', $rawToken), 'expires_at' => now()->addHour()]
        );

        // signed url (30 menit) + raw token di query
        $url = URL::temporarySignedRoute(
            'account.deletion.confirm',
            now()->addMinutes(30),
            ['uid' => $user->id, 'token' => $rawToken]
        );

        Mail::to($user->email)->send(new MailAccountDeletionConfirmation(
            $user->username,
            $url
        ));

        return back()->with('success', 'Email confirmation link has been sent to your email address.');
    }

    // verify and delete account
    public function confirm(Request $request)
    {
        $request->validate([
            'uid'   => ['required','integer','exists:users,id'],
            'token' => ['required','string'],
        ]);

        $user = User::findOrFail($request->uid);

        $row = AccountDeletionToken::where('user_id', $user->id)->first();
        if (!$row || $row->expires_at->isPast() || !hash_equals($row->token_hash, hash('sha256', $request->token))) {
            abort(403, 'Invalid or expired account deletion token.');
        }

        DB::transaction(function () use ($user, $row) {
            // if user has profile image, delete it from storage
            if ($user->profile_image) {
                app(\App\Services\HandleFileService::class)->deleteFile($user->profile_image);
            }

            $row->delete();        // consume the token
            $user->delete();       // soft delete user; to force delete, use ->forceDelete()
        });

        Auth::logout();

        return redirect('/')->with('success', 'Your account has been deleted. Bye and good luck out there.');
    }
}