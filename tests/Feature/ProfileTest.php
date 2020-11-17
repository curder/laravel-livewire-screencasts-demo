<?php

namespace Tests\Feature;

use App\Http\Livewire\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function profile_page_contains_livewire_component()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->withoutExceptionHandling()
             ->get(route('profile'))
             ->assertOk()
            ->assertSeeLivewire('profile');
    }

    /** @test */
    public function can_update_profile()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
                ->test(Profile::class)
                ->set('name', 'foo')
                ->set('about', 'bar')
                ->call('save');

        $user->refresh();

        $this->assertEquals('foo', $user->name);
        $this->assertEquals('bar', $user->about);
    }

    /** @test */
    public function profile_info_is_pre_populated()
    {
        $user = User::factory()->create([
            'name' => 'foo',
            'about' => 'bar',
        ]);

        Livewire::actingAs($user)
                ->test(Profile::class)
                ->assertSet('name', 'foo')
                ->assertSet('about', 'bar');
    }


    /** @test */
    public function user_name_must_be_less_then_24_characters()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
                ->test(Profile::class)
                ->set('name', str_repeat(1, 24))
                ->set('about', 'bar')
                ->call('save')
                ->assertHasNoErrors();

        Livewire::actingAs($user)
                ->test(Profile::class)
                ->set('name', str_repeat(1, 25))
                ->set('about', 'bar')
                ->call('save')
                ->assertHasErrors(['name' => 'max']);
    }

    /** @test */
    public function user_about_must_be_less_then_120_characters()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
                ->test(Profile::class)
                ->set('name', 'foo')
                ->call('save')
                ->set('about', str_repeat(1, 120))
                ->assertHasNoErrors();

        Livewire::actingAs($user)
                ->test(Profile::class)
                ->set('name', 'foo')
                ->set('about', str_repeat(1, 121))
                ->call('save')
                ->assertHasErrors(['about' => 'max']);
    }

    /** @test */
    public function message_is_shown_on_save()
    {
        $user = User::factory()->create();
        Livewire::actingAs($user)
                ->test(Profile::class)
                ->set('name', 'foo')
                ->set('about', 'bar')
                ->call('save')
                ->assertEmitted('notify-saved');
                // ->assertDispatchedBrowserEvent('notify');
    }
}
