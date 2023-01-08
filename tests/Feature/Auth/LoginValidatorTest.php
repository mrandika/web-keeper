<?php

namespace Tests\Feature\Auth;

use App\Http\Livewire\Auth\LoginView;
use Livewire\Livewire;
use Tests\TestCase;

class LoginValidatorTest extends TestCase
{
    /**
     * @test
     * Test if the component throws error if email has valid input.
     */
    public function check_email_validation()
    {
        $test = Livewire::test(LoginView::class);

        // Missing email
        $test->set('email', '')
            ->call('login')
            ->assertHasErrors(['email' => 'required']);

        // Incorrect email format
        $test->set('email', 'superadmin')
            ->call('login')
            ->assertHasErrors(['email' => 'email']);
    }

    /**
     * @test
     * Test if the component throws error if password has valid input.
     */
    public function check_password_validation()
    {
        $test = Livewire::test(LoginView::class);

        // Missing password
        $test->set('password', '')
            ->call('login')
            ->assertHasErrors(['password' => 'required']);
    }
}
