<?php

namespace Tests\Feature\Auth;

use App\Http\Livewire\Auth\RegisterView;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class RegisterValidatorTest extends TestCase
{
    /**
     * @test
     * Test if the component throws error if name has valid input.
     */
    public function check_name_validation()
    {
        $test = Livewire::test(RegisterView::class);

        // Missing first name
        $test->set('first_name', '')
            ->call('register')
            ->assertHasErrors(['first_name' => 'required']);

        // Invalid first name length
        $test->set('first_name', 'a')
            ->call('register')
            ->assertHasErrors(['first_name' =>  'min:2']);

        $test->set('first_name', 'abcdefghijklmnopqrstuvwxyz')
            ->call('register')
            ->assertHasErrors(['first_name' =>  'max:25']);

        // Missing last name
        $test->set('last_name', '')
            ->call('register')
            ->assertHasErrors(['last_name' => 'required']);

        // Invalid last name length
        $test->set('last_name', 'a')
            ->call('register')
            ->assertHasErrors(['last_name' =>  'min:2']);

        $test->set('last_name', 'abcdefghijklmnopqrstuvwxyz')
            ->call('register')
            ->assertHasErrors(['last_name' =>  'max:25']);
    }

    /**
     * @test
     * Test if the component throws error if phone number has valid input.
     */
    public function check_phone_number_validation()
    {
        $test = Livewire::test(RegisterView::class);

        // Missing phone number
        $test->set('phone_number', '')
            ->call('register')
            ->assertHasErrors(['phone_number' => 'required']);

        // Invalid phone number (string)
        $test->set('phone_number', 'abc')
            ->call('register')
            ->assertHasErrors(['phone_number' => 'numeric']);

        // Invalid phone number, incorrect length
        $test->set('phone_number', '0812')
            ->call('register')
            ->assertHasErrors(['phone_number' => 'min_digits:8']);

        $test->set('phone_number', '081234567890987654321')
            ->call('register')
            ->assertHasErrors(['phone_number' => 'max_digits:15']);
    }

    /**
     * @test
     * Test if the component throws error if email has valid input.
     */
    public function check_email_validation()
    {
        $test = Livewire::test(RegisterView::class);

        // Missing email
        $test->set('email', '')
            ->call('register')
            ->assertHasErrors(['email' => 'required']);

        // Incorrect email format
        $test->set('email', 'superadmin')
            ->call('register')
            ->assertHasErrors(['email' => 'email']);

        // Existing email
        $test->set('email', 'superadmin@keeper.com')
            ->call('register')
            ->assertHasErrors(['email' => 'unique:users']);
    }

    /**
     * @test
     * Test if the component throws error if password has valid input.
     */
    public function check_password_validation()
    {
        $test = Livewire::test(RegisterView::class);

        // Missing password
        $test->set('password', '')
            ->call('register')
            ->assertHasErrors(['password' => 'required']);
    }
}
