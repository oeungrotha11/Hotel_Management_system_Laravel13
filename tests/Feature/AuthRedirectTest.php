<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_session_lifetime_is_seven_days(): void
    {
        $this->assertSame(10080, Config::get('session.lifetime'));
    }

    public function test_admin_login_redirects_to_admin_dashboard(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);
        $user->role = 'admin';
        $user->save();

        $response = $this->withSession(['url.intended' => route('customer.rooms.index')])
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'password123',
            ]);

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_customer_login_redirects_to_home(): void
    {
        $user = User::create([
            'name' => 'Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
    }

    public function test_registration_redirects_to_home(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'New Customer',
            'email' => 'new-customer@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
    }
}
