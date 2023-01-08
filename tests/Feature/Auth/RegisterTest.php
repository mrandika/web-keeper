<?php

namespace Tests\Feature\Auth;

use App\Http\Livewire\Auth\RegisterView;
use App\Models\User;
use App\Models\UserData;
use Livewire\Livewire;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * @test
     * Test if the Livewire register component can be accessed and seen.
     */
    public function can_access_and_see_register_component()
    {
        $this->get(route('auth.register'))
            ->assertSuccessful()
            ->assertSeeLivewire('auth.register-view');
    }

    /**
     * @test
     * Test if the login flow can register the
     */
    public function can_register_and_redirected()
    {
        $test = Livewire::test(RegisterView::class);

        $test->set('first_name', 'Test')
            ->set('last_name', 'Test')
            ->set('phone_number', '080192384756')
            ->set('email', 'test@keeper.com')
            ->set('password', 'Supertest@12345678')
            ->set('password_confirmation', 'Supertest@12345678')
            ->call('register');

        $test->assertHasNoErrors(['first_name', 'last_name', 'phone_number', 'email', 'password', 'password_confirmation']);
        $test->assertRedirect(route('auth.login'));

        $user = User::where('email', 'test@keeper.com');
        $user_exist = $user->first() != null;
        $data_exist = UserData::find($user->first()->id) != null;

        $this->assertTrue($user_exist);
        $this->assertTrue($data_exist);

        // Remove after testing complete
        $user->delete();
    }
}
