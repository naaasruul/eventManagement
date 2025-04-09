<?php

namespace App\Http\Controllers\Attendee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invitation;

class AttendeeController extends Controller
{
    public function index()
    {
        // Attendee dashboard view
        return view('attendee.rsvp-success');;
    }

    public function viewRSVP($link)
    {
        // Find the invitation by the RSVP link
        $invitation = Invitation::where('rsvp_link', $link)->first();

        if (!$invitation) {
            abort(404, 'RSVP link not found.');
        }

        return view('attendee.rsvp', compact('invitation'));
    }

    public function viewRemindRSVP($link)
    {
        // Find the invitation by the RSVP link
        $invitation = Invitation::where('rsvp_link', $link)->first();

        if (!$invitation) {
            abort(404, 'RSVP link not found.');
        }

        return view('attendee.rsvp', compact('invitation'));
    }

    public function submitRSVP(Request $request, $link)
    {
        // Submit RSVP response
        $invitation = Invitation::where('rsvp_link', $link)->firstOrFail();

        $request->validate([
            'rsvp_status' => 'required|in:accepted,declined',
        ]);

        $invitation->update([
            'rsvp_status' => $request->rsvp_status,
        ]);

        return redirect()->route('attendee.dashboard')->with('success', 'RSVP submitted successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
