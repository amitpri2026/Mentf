<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'issuing_org'    => 'required|string|max:255',
            'issue_date'     => 'nullable|date',
            'expiry_date'    => 'nullable|date',
            'no_expiry'      => 'boolean',
            'credential_id'  => 'nullable|string|max:255',
            'credential_url' => 'nullable|string|max:255',
        ]);

        $validated['user_id']    = auth()->id();
        $validated['sort_order'] = auth()->user()->certificates()->max('sort_order') + 1;

        Certificate::create($validated);
        return back()->with('success', 'Certification added.');
    }

    public function update(Request $request, Certificate $certificate)
    {
        abort_if($certificate->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'issuing_org'    => 'required|string|max:255',
            'issue_date'     => 'nullable|date',
            'expiry_date'    => 'nullable|date',
            'no_expiry'      => 'boolean',
            'credential_id'  => 'nullable|string|max:255',
            'credential_url' => 'nullable|string|max:255',
        ]);

        $certificate->update($validated);
        return back()->with('success', 'Certification updated.');
    }

    public function destroy(Certificate $certificate)
    {
        abort_if($certificate->user_id !== auth()->id(), 403);
        $certificate->delete();
        return back()->with('success', 'Certification removed.');
    }
}
