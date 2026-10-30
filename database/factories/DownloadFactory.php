<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Download;
use App\Models\MarketplaceProduct;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DownloadFactory extends Factory
{
    protected $model = Download::class;

    public function definition(): array
    {
        $fileName = fake()->uuid() . '.zip';

        return [
            'user_id' => User::factory(),
            'product_id' => MarketplaceProduct::factory(),
            'file_path' => 'products/' . $fileName,
            'file_name' => $fileName,
            'file_size' => fake()->numberBetween(10240, 10485760),
            'downloads_count' => fake()->numberBetween(1, 10),
            'last_downloaded_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
