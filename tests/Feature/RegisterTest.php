<?php

namespace Tests\Feature;

use App\Http\Livewire\Auth\Register;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function register_page_contains_livewire_componet()
    {
        $this->get('/register')
            ->assertSeeLivewire('auth.register')
             ->assertOk();
    }

    /** @test */
    public function can_regsiter()
    {
        Livewire::test(Register::class)
            ->set('name', 'user-name')
            ->set('email', 'example@example.com')
            ->set('password', 'secret')
            ->set('passwordConformation', 'secret')
            ->call('register')
            ->assertRedirect(route('dashboard'));

        $this->assertTrue(User::where('name', 'user-name')->exists()); // 检查数据库是否存在记录
        $this->assertEquals('example@example.com', auth()->user()->email); // 检查用户是否登录
    }

    /** @test */
    public function name_is_required()
    {
        Livewire::test(Register::class)
                ->set('name', '')
                ->set('email', 'example@example.com')
                ->set('password', 'secret')
                ->set('passwordConformation', 'secret')
                ->call('register')
                ->assertHasErrors(['name' => 'required']);
    }

    /** @test */
    public function name_is_unique()
    {
        User::factory()->create([
            'name' => 'user-name',
            'email' => 'email@email.com',
            'password' => 'secret'
        ]);

        Livewire::test(Register::class)
                ->set('name', 'user-name')
                ->set('email', 'exmaple@example.com')
                ->set('password', 'secret')
                ->set('passwordConformation', 'secret')
                ->call('register')
                ->assertHasErrors(['name' => 'unique']);
    }

    /** @test */
    public function see_name_hasnt_already_been_token_validation_message_as_user_types()
    {
        User::factory()->create([
            'name' => 'user-name',
            'email' => 'email@email.com',
            'password' => 'secret'
        ]);

        Livewire::test(Register::class)
                ->set('name', 'username')
                ->assertHasNoErrors()
                ->set('name', 'user-name')
                ->assertHasErrors(['name' => 'unique']);
    }

    /** @test */
    public function email_is_required()
    {
        Livewire::test(Register::class)
                ->set('name', 'user-name')
                ->set('email', '')
                ->set('password', 'secret')
                ->set('passwordConformation', 'secret')
                ->call('register')
                ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    public function email_is_email()
    {
        Livewire::test(Register::class)
                ->set('name', 'user-name')
                ->set('email', 'email')
                ->set('password', 'secret')
                ->set('passwordConformation', 'secret')
                ->call('register')
                ->assertHasErrors(['email' => 'email']);
    }
    /** @test */
    public function email_is_unique()
    {
        User::factory()->create([
            'name' => 'user-name',
            'email' => 'email@email.com',
            'password' => 'secret'
        ]);

        Livewire::test(Register::class)
                ->set('name', 'user-name')
                ->set('email', 'email@email.com')
                ->set('password', 'secret')
                ->set('passwordConformation', 'secret')
                ->call('register')
                ->assertHasErrors(['email' => 'unique']);
    }

    /** @test */
    public function see_email_hasnt_already_been_token_validation_message_as_user_types()
    {
        User::factory()->create([
            'name' => 'user-name',
            'email' => 'email@email.com',
            'password' => 'secret'
        ]);

        Livewire::test(Register::class)
                ->set('email', 'emai@email.com')
                ->assertHasNoErrors()
            ->set('email', 'email@email.com')
            ->assertHasErrors(['email' => 'unique']);
    }

    /** @test */
    public function password_is_required()
    {
        Livewire::test(Register::class)
            ->set('name', 'user-name')
            ->set('email', 'example@example.com')
            ->set('password', '')
            ->set('passwordConformation', '')
            ->call('register')
            ->assertHasErrors(['password' => 'required']);
    }

    /** @test */
    public function password_is_minimum_of_six_characters()
    {
        Livewire::test(Register::class)
            ->set('name', 'user-name')
            ->set('email', 'example@example.com')
            ->set('password', 'secre')
            ->set('passwordConformation', 'secret')
            ->call('register')
            ->assertHasErrors(['password' => 'min']);
    }

    /** @test */
    public function password_mactches_passwordConformation()
    {
        Livewire::test(Register::class)
                ->set('name', 'user-name')
                ->set('email', 'example@example.com')
                ->set('password', 'secret')
                ->set('passwordConformation', 'secre')
                ->call('register')
                ->assertHasErrors(['password' => 'same']);
    }

    /** @test */
    public function passwordConformation_is_required()
    {
        Livewire::test(Register::class)
                ->set('name', 'user-name')
                ->set('email', 'example@example.com')
                ->set('password', 'secret')
                ->set('passwordConformation', '')
                ->call('register')
                ->assertHasErrors(['passwordConformation' => 'required']);
    }

    /** @test */
    public function passwordConformation_is_minimum_six_charcaters()
    {
        Livewire::test(Register::class)
                ->set('name', 'user-name')
                ->set('email', 'example@example.com')
                ->set('password', 'secret')
                ->set('passwordConformation', 'secre')
                ->call('register')
                ->assertHasErrors(['passwordConformation' => 'min']);
    }
}
