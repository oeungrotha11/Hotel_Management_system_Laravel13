<?php

namespace Tests\Feature;

use Tests\TestCase;

class SmokeTest extends TestCase
{
    public function test_guest_visiting_home_can_see_the_public_landing_page(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('StayEase');
        $response->assertSee('Book your stay');
    }
}
