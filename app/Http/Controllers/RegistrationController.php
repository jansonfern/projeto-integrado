<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function index(Event $event)
    {
        $registrations = $event->registrations()->with('user')->get();
        return view('registrations.index', compact('event', 'registrations'));
    }

    public function store(Request $request, Event $event)
    {
        Registration::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'status' => 'pendente',
        ]);
        return redirect()->route('events.show', $event);
    }

    public function approve(Registration $registration)
    {
        $registration->update(['status' => 'aprovado']);
        return back();
    }

    public function reject(Registration $registration)
    {
        $registration->update(['status' => 'rejeitado']);
        return back();
    }
} 