<?php

namespace App\Http\Controllers;

use App\Models\CppClient;
use App\Models\CppCode;
use App\Models\CppPromotion;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CppPortalController extends Controller
{
    public function index()
    {
        if (Setting::get('cpp_portal_enabled', '1') !== '1') {
            abort(404);
        }

        $promotions = CppPromotion::portalEnabled()
            ->where('status', '!=', 'draft')
            ->orderByDesc('start_date')
            ->get();

        return view('pages.cpp.index', compact('promotions'));
    }

    public function show(CppPromotion $promotion)
    {
        if (Setting::get('cpp_portal_enabled', '1') !== '1' || !$promotion->enable_portal || $promotion->status === 'draft') {
            abort(404);
        }

        $stats = $this->statsFor($promotion);
        $allowCountdown = Setting::get('cpp_allow_countdown', '1') === '1';

        return view('pages.cpp.show', compact('promotion', 'stats', 'allowCountdown'));
    }

    public function statistics(CppPromotion $promotion)
    {
        if (Setting::get('cpp_allow_statistics', '1') !== '1') {
            abort(404);
        }

        return response()->json($this->statsFor($promotion));
    }

    public function search(Request $request)
    {
        if (Setting::get('cpp_search_enabled', '1') !== '1') {
            return response()->json(['found' => false, 'message' => 'Code search is currently disabled.'], 403);
        }

        $request->validate(['code' => 'required|string|max:50']);

        $code = CppCode::with(['client.promotion', 'client.product'])
            ->where('code', strtoupper(trim($request->code)))
            ->first();

        if (!$code || !$code->client) {
            return response()->json(['found' => false, 'message' => 'No registration found for that promotion code.']);
        }

        $client = $code->client;
        $timeline = collect(CppClient::TIMELINE_STATUSES)->map(function ($label, $key) use ($client) {
            $order = array_keys(CppClient::TIMELINE_STATUSES);
            $currentIndex = array_search($client->current_timeline_status, $order);
            $thisIndex = array_search($key, $order);
            return [
                'key'       => $key,
                'label'     => $label,
                'completed' => $thisIndex < $currentIndex,
                'current'   => $key === $client->current_timeline_status,
            ];
        })->values();

        return response()->json([
            'found' => true,
            'company_name'    => $client->company_name ?: 'N/A',
            'code'            => $code->code,
            'code_status'     => $code->status,
            'promotion_title' => $client->promotion->title,
            'product_name'    => $client->product->name ?? 'N/A',
            'current_status'  => $client->current_timeline_label,
            'progress_percent'=> $client->progress_percent,
            'timeline'        => $timeline,
        ]);
    }

    private function statsFor(CppPromotion $promotion): array
    {
        return Cache::remember("cpp_stats_{$promotion->id}", 30, function () use ($promotion) {
            return [
                'max_clients'      => $promotion->max_clients,
                'registered'       => $promotion->registeredCount(),
                'remaining'        => $promotion->remainingSlots(),
                'effective_status' => $promotion->effective_status,
                'expiry_date'      => optional($promotion->expiry_date)->toIso8601String(),
            ];
        });
    }
}
