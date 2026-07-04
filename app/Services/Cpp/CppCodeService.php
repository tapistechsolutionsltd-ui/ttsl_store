<?php

namespace App\Services\Cpp;

use App\Models\CppClient;
use App\Models\CppCode;
use App\Models\Setting;
use Illuminate\Database\QueryException;

class CppCodeService
{
    /**
     * Generate and persist a globally-unique promotion code for a client.
     * Sequence is global per calendar month across all promotions (e.g. CPP-JUL26-0001).
     */
    public function generate(CppClient $client): CppCode
    {
        $prefix = $client->promotion->code_prefix ?: Setting::get('cpp_code_prefix', 'CPP');
        $length = (int) Setting::get('cpp_code_length', 4);
        $monthKey = strtoupper(now()->format('My'));
        $pattern  = "{$prefix}-{$monthKey}-";

        $attempts = 0;
        while ($attempts < 5) {
            $attempts++;

            $count = CppCode::where('code', 'like', $pattern . '%')->count();
            $sequence = str_pad((string) ($count + 1 + $attempts - 1), $length, '0', STR_PAD_LEFT);
            $code = $pattern . $sequence;

            try {
                return CppCode::create([
                    'cpp_client_id'   => $client->id,
                    'cpp_promotion_id' => $client->cpp_promotion_id,
                    'code'            => $code,
                    'generated_at'    => now(),
                    'status'          => 'active',
                ]);
            } catch (QueryException $e) {
                // Unique constraint hit under concurrency — retry with the next sequence.
                if ($attempts >= 5) {
                    throw $e;
                }
            }
        }

        throw new \RuntimeException('Unable to generate a unique CPP code after several attempts.');
    }
}
