<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TutoringLead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        $leads = TutoringLead::latest()->paginate(20);

        return view("admin.leads.index", compact("leads"));
    }

    public function update(Request $request, TutoringLead $lead)
    {
        $validated = $request->validate([
            "status" => ["required", "in:new,contacted,scheduled,closed"],
        ]);

        $lead->update($validated);

        return back()->with("status", "Lead updated.");
    }
}
