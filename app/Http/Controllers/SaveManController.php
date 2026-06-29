<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\SaveManService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaveManController extends Controller
{
    public function chat(Request $request, SaveManService $service): JsonResponse
    {
        $request->validate([
            'message'           => 'required|string|max:1000',
            'history'           => 'nullable|array|max:20',
            'history.*.role'    => 'required|in:user,assistant',
            'history.*.content' => 'required|string|max:2000',
        ]);

        $reply = $service->chat(
            $request->input('message'),
            $request->input('history', [])
        );

        return response()->json(['reply' => $reply]);
    }
}
