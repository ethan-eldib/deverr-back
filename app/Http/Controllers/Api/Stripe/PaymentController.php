<?php

namespace App\Http\Controllers\Api\Stripe;

use App\Http\Controllers\Controller;
use App\Models\DeveloperPrestation;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    /**
     * @param $id
     * @return View
     */
    public function recapDeveloperPrestation($id): JsonResponse
    {
        $order = Order::where('id', $id)->first();
        $devFullName = $order->developerPrestation->developer->user->firstname . ' ' . $order->developerPrestation->developer->user->lastname;

        return new JsonResponse([
            'developerPrestationId'    => $order->developerPrestation->id,
            'developerPrestationName'  => $order->developerPrestation->prestationType->name,
            'developerFullName'        => $devFullName,
            'developerPrestationPrice' => $order->developerPrestation->price,
        ]);

        /*return view('recap', [
            'developerPrestation' => $order->developerPrestation,
        ]);*/
    }

    /**
     * @param $stripeSessionId
     * @param $developerPrestationId
     * @return JsonResponse
     */
    public function success($stripeSessionId, $developerPrestationId): JsonResponse
    {
        Order::where('developer_prestation_id', $developerPrestationId)->update([
            'is_paid' => true,
            'reference' => str_replace([' ', '-'], '', now()->format('Y-m-d').'-'.uniqid()),
            'stripe_session_id' => $stripeSessionId,
        ]);

        $orderStripeSessionId = Order::where('stripe_session_id', $stripeSessionId)->first();

        return new JsonResponse([
            'message' => 'Paiement accepté',
            'order' => $orderStripeSessionId,
        ]);
    }

    /**
     * @param $stripeSessionId
     * @param $developerPrestationId
     * @return JsonResponse
     */
    public function canceled($stripeSessionId, $developerPrestationId): JsonResponse
    {
        Order::where('developer_prestation_id', $developerPrestationId)->update([
            'is_paid' => false,
            'reference' => str_replace([' ', '-'], '', now()->format('Y-m-d').'-'.uniqid()),
            'stripe_session_id' => $stripeSessionId,
        ]);

        $orderStripeSessionId = Order::where('stripe_session_id', $stripeSessionId)->first();

        return new JsonResponse([
            'message' => 'Échec du paiement',
            'order' => $orderStripeSessionId,
        ]);
    }
}
