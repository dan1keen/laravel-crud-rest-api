<?php

namespace Tests\Feature\Api;

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Image;

class NewsTest extends TestCase
{
    use RefreshDatabase;

    private $limit = 10;

    /** @test */
    public function a_news_list_can_be_list()
    {
        $this->insertDummyItems();
        $this
            ->getJson(route('api.news.index'))
            ->assertStatus(200);
    }

    /** @test */
    public function a_single_news_can_be_listed()
    {
        $this->insertDummyItems();
        $item = News::inRandomOrder()->first();
        $this
            ->getJson(route('api.news.show', ['news' => $item->id]))
            ->assertStatus(200);
    }

    /** @test */
    public function a_single_news_can_be_created_with_image()
    {
        Storage::fake('public_uploads');
        $fakeData = $this->fillDummyItem();

        $this
            ->postJson(route('api.news.store'), $fakeData->toArray())
            ->assertStatus(201);
        $this->assertEquals(1, News::count());

        $news = News::first();
        Storage::disk('public_uploads')->assertExists($news->image);
    }

    /** @test */
    public function a_single_news_can_be_post_updated_with_image()
    {
        Storage::fake('public_uploads');
        $fakeData = $this->fillDummyItem(false);
        $fakeData->image = UploadedFile::fake()->image('updated_fake.jpg');

        $createdData = $this->insertDummyItems()->first();

        $this
            ->postJson(route('api.news.update', ['news' => $createdData->id]), $fakeData->toArray())
            ->assertStatus(200);

        $news = News::find($createdData->id);
        Storage::disk('public_uploads')->assertExists($news->image);
    }

    /** @test */
    public function a_single_news_can_be_put_updated_with_image()
    {
        Storage::fake('public_uploads');

        $this->insertDummyItems();
        $fakeData = $this->fillDummyItem(false);
        $fakeData->image_url = News::factory()->make()->image;

        $news = News::inRandomOrder()->first();

        $response = $this
            ->putJson(route('api.news.update', ['news' => $news->id]), $fakeData->toArray());
        $response->assertStatus(200);

        $news = News::find($news->id);
        Storage::disk('public_uploads')->assertExists($news->image);
    }

    /** @test */
    public function a_single_news_can_be_deleted_with_image()
    {
        Storage::fake('public_uploads');
        $fakeData = $this->fillDummyItem();

        $createdData = $this
            ->postJson(route('api.news.store'), $fakeData->toArray())
            ->assertStatus(201)
            ->json();

        $this
            ->deleteJson(route('api.news.destroy', ['news' => $createdData['item']['id']]))
            ->assertStatus(200);
        $this->assertEquals(0, News::count());

        Storage::disk('public_uploads')->assertMissing($createdData['item']['image']);
    }

    private function insertDummyItems()
    {
        return News::factory()->count($this->limit)->create();
    }

    private function fillDummyItem($imagable = true)
    {
        $data = News::factory()->make();
        if ($imagable) {
            $data->image = UploadedFile::fake()->image('fake.jpg');
        } else {
            unset($data->image);
        }

        return $data;
    }

}
