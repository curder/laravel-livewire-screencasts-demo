<?php

namespace Tests\Feature;

use App\Http\Livewire\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
                ->set('user.name', 'foo')
                ->set('user.about', 'bar')
                ->call('save');

        $user->refresh();

        $this->assertEquals('foo', $user->name);
        $this->assertEquals('bar', $user->about);
    }

    /** @test */
    public function can_upload_avatar()
    {
        $user = User::factory()->create();

        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.jpg');

        Livewire::actingAs($user)
                ->test(Profile::class)
                ->set('user.name', 'foo')
                ->set('user.about', 'bar')
                ->set('upload', $file)
                ->call('save');

        $user->refresh();

        self::assertNotNull($user->avatar);
        Storage::disk('avatars')->assertExists($user->avatar);
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
                ->assertSet('user.name', 'foo')
                ->assertSet('user.about', 'bar');
    }


    /** @test */
    public function user_name_must_be_less_then_24_characters()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
                ->test(Profile::class)
                ->set('user.name', str_repeat(1, 24))
                ->set('user.about', 'bar')
                ->call('save')
                ->assertHasNoErrors();

        Livewire::actingAs($user)
                ->test(Profile::class)
                ->set('user.name', str_repeat(1, 25))
                ->set('user.about', 'bar')
                ->call('save')
                ->assertHasErrors(['user.name' => 'max']);
    }

    /** @test */
    public function user_about_must_be_less_then_120_characters()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
                ->test(Profile::class)
                ->set('user.name', 'foo')
                ->set('user.about', str_repeat(1, 120))
                ->call('save')
                ->assertHasNoErrors();

        Livewire::actingAs($user)
                ->test(Profile::class)
                ->set('user.name', 'foo')
                ->set('user.about', str_repeat(1, 121))
                ->call('save')
                ->assertHasErrors(['user.about' => 'max']);
    }

    /** @test */
    public function message_is_shown_on_save()
    {
        $user = User::factory()->create();
        Livewire::actingAs($user)
                ->test(Profile::class)
                ->set('user.name', 'foo')
                ->set('user.about', 'bar')
                ->call('save')
                ->assertEmitted('notify-saved');
                // ->assertDispatchedBrowserEvent('notify');
    }
}
