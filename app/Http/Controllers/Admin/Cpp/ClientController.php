<?php

namespace App\Http\Controllers\Admin\Cpp;

use App\Http\Controllers\Controller;
use App\Mail\CppTimelineUpdated;
use App\Models\CppClient;
use App\Models\CppTimelineLog;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = CppClient::with(['promotion', 'user', 'product', 'activeCode']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                    ->orWhereHas('activeCode', fn($c) => $c->where('code', 'like', "%{$search}%"))
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }
        if ($request->filled('promotion')) {
            $query->where('cpp_promotion_id', $request->promotion);
        }
        if ($request->filled('status')) {
            $query->where('current_timeline_status', $request->status);
        }

        $clients = $query->latest()->paginate(20)->withQueryString();

        return view('admin.cpp.clients.index', compact('clients'));
    }

    public function show(CppClient $client)
    {
        $client->load(['promotion', 'user', 'product', 'order', 'codes', 'timelineLogs.admin']);

        return view('admin.cpp.clients.show', compact('client'));
    }

    public function update(Request $request, CppClient $client)
    {
        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'is_active'    => 'nullable|boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active');

        $client->update($validated);

        return back()->with('success', 'Client updated.');
    }

    public function updateTimeline(Request $request, CppClient $client)
    {
        $validated = $request->validate([
            'status'           => 'required|string|in:' . implode(',', array_keys(CppClient::TIMELINE_STATUSES)),
            'notes'            => 'nullable|string|max:1000',
            'progress_percent' => 'nullable|integer|min:0|max:100',
        ]);

        $log = CppTimelineLog::create([
            'cpp_client_id'    => $client->id,
            'status'           => $validated['status'],
            'notes'            => $validated['notes'] ?? null,
            'progress_percent' => $validated['progress_percent'] ?? null,
            'created_by'       => auth()->id(),
        ]);

        $client->update([
            'current_timeline_status' => $validated['status'],
            'progress_percent'        => $validated['progress_percent'] ?? $client->progress_percent,
        ]);

        if (Setting::get('cpp_client_timeline_email_enabled', '0') === '1') {
            try {
                $client->load('user', 'promotion', 'activeCode');
                if ($client->user?->email) {
                    Mail::to($client->user->email)->send(new CppTimelineUpdated($client, $log));
                }
            } catch (\Throwable $e) {
                Log::error('CPP timeline update email failed: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Timeline updated.');
    }

    public function deactivate(CppClient $client)
    {
        $client->update(['is_active' => !$client->is_active]);

        return back()->with('success', $client->is_active ? 'Client reactivated.' : 'Client deactivated.');
    }

    public function destroy(CppClient $client)
    {
        $client->delete();

        return redirect()->route('admin.cpp.clients.index')->with('success', 'Client record deleted.');
    }
}
