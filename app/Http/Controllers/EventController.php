<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('address')->get();
        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required|date',
            'cep' => 'required',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
        ]);
        $event = Event::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'date' => $data['date'],
            'organizer_id' => Auth::id(),
        ]);
        Address::create([
            'event_id' => $event->id,
            'cep' => $data['cep'],
            'street' => $data['street'],
            'city' => $data['city'],
            'state' => $data['state'],
        ]);
        return redirect()->route('events.index');
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required|date',
        ]);
        $event->update($data);
        $event->address->update($request->only(['cep', 'street', 'city', 'state']));
        return redirect()->route('events.index');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index');
    }
} 