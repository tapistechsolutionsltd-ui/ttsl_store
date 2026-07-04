<?php

namespace App\Http\Controllers\Admin\Cpp;

use App\Http\Controllers\Controller;
use App\Models\CppClient;
use App\Models\CppCode;
use App\Services\Cpp\CppCodeService;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    public function index(Request $request)
    {
        $query = CppCode::with(['client.user', 'client.product', 'promotion']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('code', 'like', '%' . $request->search . '%');
        }

        $codes = $query->latest()->paginate(20)->withQueryString();

        return view('admin.cpp.codes.index', compact('codes'));
    }

    public function generate(CppClient $client, CppCodeService $codeService)
    {
        $client->codes()->where('status', 'active')->update(['status' => 'cancelled']);

        $codeService->generate($client);

        return back()->with('success', 'New code generated for this client.');
    }

    public function expire(CppCode $code)
    {
        $code->update(['status' => 'expired', 'expires_at' => now()]);

        return back()->with('success', 'Code marked as expired.');
    }

    public function cancel(CppCode $code)
    {
        $code->update(['status' => 'cancelled']);

        return back()->with('success', 'Code cancelled.');
    }

    public function reassign(Request $request, CppCode $code)
    {
        $request->validate(['client_id' => 'required|exists:cpp_clients,id']);

        $code->update(['cpp_client_id' => $request->client_id]);

        return back()->with('success', 'Code reassigned to the selected client.');
    }
}
