<?php

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it returns a list of brands', function () {
    $this->withoutVite();
    Brand::factory()->count(3)->create();

    $response = $this->getJson('/api/brands');

    $response->assertStatus(200)
        ->assertJsonCount(3, 'data');
});

test('it returns a single brand', function () {
    $this->withoutVite();
    $brand = Brand::factory()->create();

    $response = $this->getJson('/api/brands/' . $brand->id);

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $brand->id,
                'name' => $brand->name,
                'slug' => $brand->slug,
            ]
        ]);
});
