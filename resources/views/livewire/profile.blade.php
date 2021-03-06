<div>
    <h1 class="text-2xl font-semibold text-gray-900">Profile</h1>

    <form wire:submit.prevent="save" method="POST" action="#">
        <div class="mt-6 sm:mt-5 space-y-6">
            <x-input.group label="Username" for="name" :error="$errors->first('user.name')"
                           help-text="Write a few sentences about yourself.">
                <x-input.text wire:model="user.name" id="name" leading-add-on="workcation.com/"></x-input.text>
            </x-input.group>

            <x-input.group label="Birthday" for="birthday" :error="$errors->first('user.birthday')"
                           help-text="Write a few sentences about yourself.">
                <x-input.date wire:model="user.birthday" id="birthday" placeholder="YYYY-MM-DD"></x-input.date>
            </x-input.group>

            <x-input.group label="About" for="about" :error="$errors->first('user.about')"
                           help-text="Write a few sentences about yourself.">
                <x-input.trix-text wire:model.defer="user.about" :initial-value="$user->about" id="about"
                                   rows="3"></x-input.trix-text>
            </x-input.group>

            <x-input.group label="Photo" for="upload" :error="$errors->first('upload')">

                 <span class="w-12 rounded-full overflow-hidden bg-gray-100">
                    @if (!$upload)
                         <img src="{{ auth()->user()->avatar_url }}" alt="Profile Photo">
                     @endif
                </span>
                <x-input.filepond wire:model="upload" id="upload"></x-input.filepond>

                {{--                <x-input.file-upload wire:model="newAvatar" id="newAvatar">--}}
                {{--                    <span class="w-12 rounded-full overflow-hidden bg-gray-100">--}}
                {{--                        @if ($upload)--}}
                {{--                            <img src="{{ $this->newAvatar->temporaryUrl() }}" alt="Profile Photo">--}}
                {{--                        @else--}}
                {{--                            <img src="{{ auth()->user()->avatar_url }}" alt="Profile Photo">--}}
                {{--                        @endif--}}
                {{--                    </span>--}}
                {{--                </x-input.file-upload>--}}
            </x-input.group>
        </div>

        <div class="mt-8 border-t border-gray-200 pt-5">
            <div class="space-x-3 flex justify-end items-center">

                <span x-data="{ open: false }"
                      x-show.transition.out.duration.1000ms="open"
                      x-init="
                        @this.on('notify-saved', () => {
                            setTimeout(() => { open = false }, 2500)
                            open = true
                        })
                      "
                      style="display: none;"
                      class="text-green-500">
                        Saved!
                </span>

                <span class="inline-flex rounded-md shadow-sm">
                    <button type="button"
                            class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                        Cancel
                    </button>
                </span>

                <span class="inline-flex rounded-md shadow-sm">
                    <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        Save
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>
