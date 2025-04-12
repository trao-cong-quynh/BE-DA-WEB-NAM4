<?php

namespace App\Http\Controllers;

use App\Models\DvAnUong;
use Illuminate\Http\Request;

class DichVuAnUongController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    /**
     * @OA\Get(
     *     path="/api/dichvuanuong",
     *     summary="Lấy danh sách các dịch vụ ăn uống",
     *     tags={"Dịch vụ ăn uống"},
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách dịch vụ ăn uống",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="ten_dv", type="string", example="Combo bắp + nước"),
     *                 @OA\Property(property="gia_tien", type="number", format="float", example=45000)
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $dv = DvAnUong::all();
        return response()->json($dv);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
