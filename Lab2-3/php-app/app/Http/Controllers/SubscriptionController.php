<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Server(
 *     url="http://localhost:8000/php/api",
 *     description="Local API Server"
 * )
 */
class SubscriptionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/subscriptions",
     *     summary="Get list of subscriptions",
     *     tags={"Subscriptions"},
     *     @OA\Response(
     *         response=200,
     *         description="List of subscriptions",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Subscription")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return Subscription::all();
    }

    /**
     * @OA\Post(
     *     path="/subscriptions",
     *     summary="Create a new subscription",
     *     tags={"Subscriptions"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Subscription")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Subscription created",
     *         @OA\JsonContent(ref="#/components/schemas/Subscription")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'service' => 'required|string',
            'topic' => 'required|string',
            'payload' => 'required|json',
            'expired_at' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $subscription = Subscription::create($request->all());

        return response()->json($subscription, 201);
    }

    /**
     * @OA\Get(
     *     path="/subscriptions/{id}",
     *     summary="Get a subscription by ID",
     *     tags={"Subscriptions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Subscription found",
     *         @OA\JsonContent(ref="#/components/schemas/Subscription")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Subscription not found"
     *     )
     * )
     */
    public function show($id)
    {
        $subscription = Subscription::findOrFail($id);
        return response()->json($subscription);
    }

    /**
     * @OA\Put(
     *     path="/subscriptions/{id}",
     *     summary="Update a subscription by ID",
     *     tags={"Subscriptions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Subscription")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Subscription updated",
     *         @OA\JsonContent(ref="#/components/schemas/Subscription")
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $subscription = Subscription::findOrFail($id);
        // $subscription->update($request->all());

        // Валидируем входящие данные
        $validated = $request->validate([
            'service' => 'nullable|string',
            'topic' => 'nullable|string',
            'payload' => 'nullable|json',
            'expired_at' => 'nullable|date_format:Y-m-d H:i:s',
        ]);

        // Частичное обновление, только для переданных данных
        $subscription->fill($validated);

        // Сохраняем обновлённые данные в базе данных
        $subscription->save();

        return response()->json($subscription);
    }

    /**
     * @OA\Delete(
     *     path="/subscriptions/{id}",
     *     summary="Delete a subscription by ID",
     *     tags={"Subscriptions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Subscription deleted"
     *     )
     * )
     */
    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();
        return response()->json(null, 204);
    }


}