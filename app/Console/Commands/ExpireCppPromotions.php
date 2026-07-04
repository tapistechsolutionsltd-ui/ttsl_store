<?php

namespace App\Console\Commands;

use App\Mail\CppPromotionExpiredAlert;
use App\Models\CppPromotion;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ExpireCppPromotions extends Command
{
    protected $signature = 'cpp:expire-promotions';

    protected $description = 'Mark auto-expiring CPP promotions as expired once their expiry date has passed';

    public function handle(): int
    {
        $alertEmail = Setting::get('cpp_alert_email', 'ttsl.support@gmail.com');

        $promotions = CppPromotion::where('status', 'published')
            ->where('auto_expire', true)
            ->whereNotNull('expiry_date')
            ->where('expiry_date', '<', now())
            ->get();

        foreach ($promotions as $promotion) {
            $promotion->update(['status' => 'expired']);
            $this->info("Expired promotion: {$promotion->title}");

            try {
                if ($alertEmail) {
                    Mail::to($alertEmail)->send(new CppPromotionExpiredAlert($promotion));
                }
            } catch (\Throwable $e) {
                Log::error('CPP promotion expired alert failed: ' . $e->getMessage());
            }
        }

        $this->info("Processed {$promotions->count()} promotion(s).");

        return self::SUCCESS;
    }
}
