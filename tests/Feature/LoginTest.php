<?php

namespace Tests\Feature;

use App\Http\Livewire\Auth\Login;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_page_contains_login_livewire()
    {
        $this->get(route('login'))
             ->assertOk()
            ->assertSeeLivewire('auth.login');
    }

    /** @test */
    public function is_redirected_if_already_logged_in()
    {
        auth()->login(User::factory()->create());

        $this->get(route('login'))
             ->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function can_login()
    {
        $user = User::factory()->create();

        Livewire::test('auth.login')
                ->set('email', $user->email)
                ->set('password', 'password')
                ->call('login');

        $this->assertTrue(
            auth()->user()->is(User::where('email', $user->email)->first())
        );
    }

    /** @test */
    public function is_redirected_to_intended_after_login_prompt_from_auth_guard()
    {
        Route::get('/intended')->middleware(['auth']);
        $this->get('/intended')->assertRedirect('/login');

        $user = User::factory()->create();

        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect('intended');
    }

    /** @test */
    public function is_redirected_to_root_after_login()
    {
        $user = User::factory()->create();

        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect(route('index'));
    }

    /** @test */
    public function email_is_required()
    {
        User::factory()->create();

        Livewire::test(Login::class)
                ->set('email', '')
                ->set('password', 'password')
                ->call('login')
                ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    public function email_must_be_valid_email()
    {
        User::factory()->create();

        Livewire::test(Login::class)
                ->set('email', 'example')
                ->set('password', 'password')
                ->call('login')
                ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    public function password_is_required()
    {
        $user = User::factory()->create();

        Livewire::test(Login::class)
                ->set('email', $user->email)
                ->set('password', '')
                ->call('login')
                ->assertHasErrors(['password' => 'required']);
    }

    /** @test */
    public function bad_login_attempt_shows_message()
    {
        $user = User::factory()->create();

        Livewire::test(Login::class)
                ->set('email', $user->email)
                ->set('password', 'bad-password')
                ->call('login')
                ->assertHasErrors(['email']);
    }
}
