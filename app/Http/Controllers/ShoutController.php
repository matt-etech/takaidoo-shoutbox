<?php

namespace App\Http\Controllers;

use App\Models\Shout;
use Illuminate\Http\Request;

class ShoutController extends Controller
{
    /**
     * Display a listing of shouts.
     */
    public function index()
    {
        // Fetch latest messages first
        $shouts = Shout::latest()->get();

        return view('shoutbox', compact('shouts'));
    }

    /**
     * Store a newly created shout in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50'],
            'message'  => ['required', 'string', 'max:255'],
        ]);

        Shout::create($validated);

        return redirect()->route('shouts.index')
                         ->with('success', 'Shout posted!');
    }

    /**
     * Remove the specified shout from storage.
     */
    public function destroy(Shout $shout)
    {
        $shout->delete();

        return redirect()->route('shouts.index')
                         ->with('success', 'Shout deleted!');
    }
}
