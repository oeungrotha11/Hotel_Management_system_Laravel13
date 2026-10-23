<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_visit_the_public_homepage(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('StayEase');
        $response->assertSee('Book your stay');
    }
}
