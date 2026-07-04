<?php

namespace App\Services\Cpp;

use App\Mail\CppCapacityReachedAlert;
use App\Mail\CppNewClientAlert;
use App\Models\CppClient;
use App\Models\CppPromotion;
use App\Models\CppTimelineLog;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CppEnrollmentService
{
    public function __construct(private CppCodeService $codeService) {}

    /**
     * Enroll an order item's product into its promotion, if eligible.
     * Returns null (without throwing) whenever the product/promotion isn't eligible.
     */
    public function enrollFromOrderItem(Order $order, OrderItem $item): ?CppClient
    {
        $product = $item->product;

        if (!$product || !$product->cpp_enabled || !$product->cpp_promotion_id) {
            return null;
        }

        /** @var CppPromotion|null $promotion */
        $promotion = CppPromotion::whereKey($product->cpp_promotion_id)->lockForUpdate()->first();

        if (!$promotion || !$promotion->isOpenForRegistration()) {
            Log::info('CPP enrollment skipped — promotion not open.', [
                'promotion_id' => $product->cpp_promotion_id,
                'order_id'     => $order->id,
            ]);
            return null;
        }

        $client = CppClient::create([
            'cpp_promotion_id' => $promotion->id,
            'user_id'          => $order->user_id,
            'order_id'         => $order->id,
            'order_item_id'    => $item->id,
            'product_id'       => $product->id,
            'company_name'     => $order->organisation ?: ($order->shipping_address['full_name'] ?? null),
            'current_timeline_status' => Setting::get('cpp_default_timeline', 'application_received'),
        ]);

        $this->codeService->generate($client);

        CppTimelineLog::create([
            'cpp_client_id' => $client->id,
            'status'        => $client->current_timeline_status,
            'notes'         => 'Registration received via order ' . $order->order_number,
        ]);

        $this->notifyNewClient($client);

        if ($promotion->auto_close && $promotion->isFull()) {
            $promotion->update(['status' => 'closed']);
            $this->notifyCapacityReached($promotion);
        }

        return $client;
    }

    private function notifyNewClient(CppClient $client): void
    {
        try {
            $alertEmail = Setting::get('cpp_alert_email', 'ttsl.support@gmail.com');
            if ($alertEmail) {
                Mail::to($alertEmail)->send(new CppNewClientAlert($client->fresh(['promotion', 'user', 'product', 'order', 'activeCode'])));
            }
        } catch (\Throwable $e) {
            Log::error('CPP new client alert failed: ' . $e->getMessage());
        }
    }

    private function notifyCapacityReached(CppPromotion $promotion): void
    {
        try {
            $alertEmail = Setting::get('cpp_alert_email', 'ttsl.support@gmail.com');
            if ($alertEmail) {
                Mail::to($alertEmail)->send(new CppCapacityReachedAlert($promotion));
            }
        } catch (\Throwable $e) {
            Log::error('CPP capacity reached alert failed: ' . $e->getMessage());
        }
    }
}
