<?php

namespace App\Services\News;

use App\Http\Resources\Api\NewsResouce;
use App\Models\News;
use App\Services\ICrudService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Image; // Alias for App\Facades\Image, можно заменить на сам фасад
class NewsService implements ICrudService
{
    private $model;

    public function __construct(News $news)
    {
        $this->model = $news;
    }

    public function indexModel(): JsonResource
    {
        $items = $this->model::paginate($this->model::PAGINATION_LIMIT);
        return NewsResouce::collection($items);
    }

    public function showModel($id): JsonResource
    {
        $item = $this->model::findOrFail($id);
        return NewsResouce::make($item);
    }

    public function updateModel(Request $request, $id): array
    {
        return $this->storeOrUpdate($request, $id);
    }

    public function storeModel(Request $request): array
    {
        return $this->storeOrUpdate($request);
    }

    private function storeOrUpdate(Request $request, $id = null)
    {
        if ($id) {
            $item = $this->model::findOrFail($id);
        } else {
            $item = $this->model;
        }
        $data = $request->all();
        if ($requestImage = $request->file('image')) {
            if ($image = Image::upload($requestImage, $this->model->image_base_path)) {
                $data['image'] = $image;
            }
        } else if ($requestImage = $request->get('image_url')) {
            if ($image = Image::uploadFromUrl($requestImage, $this->model->image_base_path)) {
                $data['image'] = $image;
            }
        }
        $item->fill($data);
        $item->save();

        return [
            'status' => $id
                ? $this->model::RESPONSE_OK
                : $this->model::RESPONSE_CREATED,
            'result' => NewsResouce::make($item),
        ];
    }

    public function destroyModel($id): JsonResource
    {
        $item = $this->model::findOrFail($id);
        Image::delete($item->image);
        $item->delete();

        return NewsResouce::make($item);
    }
}
