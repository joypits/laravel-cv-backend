<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageMail;
class ContactController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'message' => 'required|string',
    ]);

    // Authenticated user is automatically the default API user
    //$user = $request->user();
    $userEmail = $request->user() ? $request->user()->email : 'guest';
    Mail::to(env('CONTACT_RECEIVER_EMAIL'))
    ->send(new ContactMessageMail(
        $validated['name'],
        $validated['email'],
        $validated['message']
    ));

    return response()->json([
        'message' => 'Your message has been sent successfully!',
        'submitted_by' => $userEmail,
    ], 200);
}

}
