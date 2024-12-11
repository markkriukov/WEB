<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Server(
 *     url="/php/api",
 *     description="API Server"
 * )
 */
class SubscriberController extends Controller
{
    /**
     * @OA\Get(
     *     path="/subscribers",
     *     summary="Get list of subscribers",
     *     tags={"Subscribers"},
     *     @OA\Response(
     *         response=200,
     *         description="List of subscribers",
     *         @OA\JsonContent(ref="#/components/schemas/Subscriber")
     *     )
     * )
     */
    public function index()
    {
        return Subscriber::all();
    }

    /**
     * @OA\Post(
     *     path="/subscribers",
     *     summary="Create a new subscriber",
     *     tags={"Subscribers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Subscriber")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Subscriber created",
     *         @OA\JsonContent(ref="#/components/schemas/Subscriber")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:subscribers',
        ]);

        $subscriber = Subscriber::create($request->all());

        return response()->json($subscriber, 201);
    }

    /**
     * @OA\Get(
     *     path="/subscribers/{id}",
     *     summary="Get a subscriber by ID",
     *     tags={"Subscribers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Subscriber found",
     *         @OA\JsonContent(ref="#/components/schemas/Subscriber")
     *     ),
     *     @OA\Response(response=404, description="Subscriber not found")
     * )
     */
    public function show($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        return response()->json($subscriber);
    }

    /**
     * @OA\Put(
     *     path="/subscribers/{id}",
     *     summary="Update a subscriber by ID",
     *     tags={"Subscribers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Subscriber")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Subscriber updated",
     *         @OA\JsonContent(ref="#/components/schemas/Subscriber")
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->update($request->all());

        return response()->json($subscriber);
    }

    /**
     * @OA\Delete(
     *     path="/subscribers/{id}",
     *     summary="Delete a subscriber by ID",
     *     tags={"Subscribers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Subscriber deleted")
     * )
     */
    public function destroy($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();

        return response()->json(null, 204);
    }
}