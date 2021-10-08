<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Services\ICrudService;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    private $crudService;
    public function __construct(ICrudService $crudService)
    {
        $this->crudService = $crudService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(['items' => $this->crudService->indexModel()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreNewsRequest $request
     * @return JsonResponse
     */
    public function store(StoreNewsRequest $request)
    {
        $response = $this->crudService->storeModel($request);
        return response()->json([
            'message' => 'created',
            'item'    => $response['result'],
        ], $response['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return response()->json(['item' => $this->crudService->showModel($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateNewsRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateNewsRequest $request, $id)
    {
        $response = $this->crudService->updateModel($request, $id);
        return response()->json([
            'message' => 'updated',
            'item'    => $response['result'],
        ], $response['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return response()->json([
            'message' => 'deleted',
            'item'    => $this->crudService->destroyModel($id),
        ]);
    }
}
