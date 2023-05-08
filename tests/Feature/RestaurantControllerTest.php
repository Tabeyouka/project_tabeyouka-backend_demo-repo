<?php

namespace Tests\Feature;

use App\Models\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * Note that in the second test method, we're using a factory to create a new Restaurant and then fetching it by its ID in the endpoint. We're also asserting that the reviews array returned in the response is empty since we haven't created any reviews yet. You can modify these tests to suit your specific requirements.
 */
class RestaurantControllerTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  /**
   * The first test method it_returns_a_list_of_restaurants() tests that the /api/restaurants endpoint returns a list of restaurants and that the response is in the expected format.
   */
  public function it_returns_a_list_of_restaurants()
  {
    // Arrange
    $restaurants = Restaurant::factory()->count(3)->create();

    // Act
    $response = $this->getJson('/api/restaurants');

    // Assert
    $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonStructure([
              '*' => [
                'name',
                'address',
                'menu_type',
                'phone_number',
                'total_points',
                'total_votes',
              ]
            ]);
  }

  /** @test */
  /**
   * The second test method it_returns_a_single_restaurant_by_id() tests that the /api/restaurants/{id} endpoint returns the correct restaurant and that the response is in the expected format.
   */
  public function it_returns_a_single_restaurant_by_id()
  {
    // Arrange
    $restaurant = Restaurant::factory()->create();

    // Act
    $response = $this->getJson("/api/restaurants/{$restaurant->id}");

    // Assert
    $response->assertStatus(200)
            ->assertJson([
              'restaurant' => [
                'id' => $restaurant->id,
                'title' => $restaurant->title,
                'address' => $restaurant->address,
                'menu_type' => $restaurant->menu_type,
                'phone_number' => $restaurant->phone_number,
                'total_points' => $restaurant->total_points,
                'total_votes' => $restaurant->total_votes,
              ],
              'reviews' => [],
            ]);
  }
}