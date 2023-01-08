<?php

namespace Tests\Feature\Auth;

use App\Http\Livewire\Auth\LoginView;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * @test
     * Test if the Livewire login component can be accessed and seen.
     */
    public function can_access_and_see_login_component()
    {
        $this->get(route('auth.login'))
            ->assertSuccessful()
            ->assertSeeLivewire('auth.login-view');
    }

    /**
     * @test
     * Test if the login flow can auth the user
     */
    public function can_login()
    {
        $email = 'superadmin@keeper.com';
        $user = User::where('email', $email)->first();
        $test = Livewire::test(LoginView::class);

        $test->set('email', $email)
            ->set('password', 'Supersecret@123')
            ->call('login');

        $this->assertTrue(auth()->user()->is($user));
    }

    /**
     * @test
     * Test if the auth middleware redirecting user to AuthBridge when logged in
     */
    public function is_redirected_when_logged_in()
    {
        auth()->attempt(['email' => 'superadmin@keeper.com', 'password' => 'Supersecret@123']);
        $this->get(route('auth.login'))
            ->assertRedirect(route('home'));
    }
}
