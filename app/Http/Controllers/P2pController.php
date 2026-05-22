<?php

namespace App\Http\Controllers;

use App\Models\P2pRegistration;
use Illuminate\Http\Request;

class P2pController extends Controller
{
    /* ── Frontend ─────────────────────────────── */

    public function index()
    {
        return view('frontend.p2p');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'         => 'required|string|max:100',
            'last_name'          => 'nullable|string|max:100',
            'email'              => 'required|email|max:200',
            'whatsapp_number'    => 'required|string|max:30',
            'country'            => 'required|string|max:100',
            'exchange'           => 'nullable|string|max:100',
            'payment_screenshot' => 'required|file|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data['payment_screenshot'] = $request->file('payment_screenshot')
            ->store('p2p/payments', 'public');

        P2pRegistration::create($data);

        return redirect()->route('p2p.success')
            ->with('success', 'Registration submitted! We will contact you within 48 hours.');
    }

    public function success()
    {
        return view('frontend.p2p-success');
    }

    /* ── Admin ────────────────────────────────── */

    public function adminIndex()
    {
        $registrations = P2pRegistration::latest()->get();
        $counts = [
            'total'    => $registrations->count(),
            'pending'  => $registrations->where('status', 'pending')->count(),
            'verified' => $registrations->where('status', 'verified')->count(),
            'rejected' => $registrations->where('status', 'rejected')->count(),
        ];
        return view('admin.p2p.index', compact('registrations', 'counts'));
    }

    public function adminShow(P2pRegistration $p2p)
    {
        return view('admin.p2p.show', compact('p2p'));
    }

    public function verify(P2pRegistration $p2p)
    {
        $p2p->update(['status' => 'verified']);
        return back()->with('success', 'Registration verified.');
    }

    public function reject(P2pRegistration $p2p)
    {
        $p2p->update(['status' => 'rejected']);
        return back()->with('success', 'Registration rejected.');
    }

    public function destroy(P2pRegistration $p2p)
    {
        // Delete payment screenshot file
        if ($p2p->payment_screenshot) {
            \Storage::disk('public')->delete($p2p->payment_screenshot);
        }
        $p2p->delete();
        return back()->with('success', 'Registration deleted.');
    }
}
