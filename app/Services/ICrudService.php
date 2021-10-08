<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

interface ICrudService
{
    public function indexModel(): JsonResource;
    public function showModel($id): JsonResource;
    public function updateModel(Request $request, $id): array;
    public function storeModel(Request $request): array;
    public function destroyModel($id): JsonResource;
}
