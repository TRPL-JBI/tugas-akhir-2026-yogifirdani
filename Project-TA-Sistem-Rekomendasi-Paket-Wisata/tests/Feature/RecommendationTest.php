<?php

namespace Tests\Feature;

use Tests\TestCase;

class RecommendationTest extends TestCase
{
    public function test_recommendation_flow_with_all_inputs(): void
    {
        $response = $this->post('/id/recommendation', [
            'tour_category' => 'Nature Trip',
            'description' => 'Saya ingin liburan melihat pemandangan alam yang indah dan sejuk di pegunungan',
            'budget' => 500000,
            'duration' => '1 Day',
            'facilities' => 'jeep, ticket',
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('recommendation');
        $response->assertViewHas('packages');
        $response->assertViewHas('preference');
    }
}
