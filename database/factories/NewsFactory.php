<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $text = $this->fillHtmlText($this->faker->paragraphs(rand(5, 10)));
        return [
            'name'         => $this->faker->realText(rand(10, 90)),
            'description'  => $this->faker->realText(rand(100, 200)),
            'text'         => $text,
            'image'        => $this->faker->imageUrl(),
            'published_at' => $this->faker->dateTime(),
            'status'       => $this->faker->boolean(),
        ];
    }

    private function fillHtmlText($paragraphs)
    {
        $text = '';
        foreach ($paragraphs as $paragraph) {
            $text .= "<p>{$paragraph}</p>";
        }
        return $text;
    }
}
