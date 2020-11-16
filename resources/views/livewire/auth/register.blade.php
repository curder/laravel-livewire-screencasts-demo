<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div>
            <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/v1/workflow-mark-on-white.svg"
                 alt="Workflow">
            <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                Sign up to your account
            </h2>
        </div>
        <form class="mt-8" action="#" method="POST" wire:submit.prevent="register">
            <div class="rounded-md shadow-sm">
                <div>
                    <input wire:model="name" aria-label="Name" name="name" type="text" required
                           class="@error('name') border-red-600 @enderror appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5"
                           placeholder="Name">
                    @error('name')
                    <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
                <div class="-mt-px">
                    <input wire:model="email" aria-label="Email address" name="email" type="email" required
                           class="@error('email') border-red-600 @enderror appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5"
                           placeholder="Email address">
                    @error('email')
                    <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
                <div class="-mt-px">
                    <input wire:model.lazy="password" aria-label="Password" name="password" type="password" required
                           class="@error('password') border-red-600 @enderror appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5"
                           placeholder="Password">
                    @error('password')
                    <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
                <div class="-mt-px">
                    <input wire:model.lazy="passwordConformation" aria-label="Password" name="passwordConformation" type="password" required
                           class="@error('passwordConformation') border-red-600 @enderror appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5"
                           placeholder="password Confirmation">
                    @error('passwordConformation')
                    <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                  <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400 transition ease-in-out duration-150"
                         fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd"
                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                            clip-rule="evenodd"/>
                    </svg>
                  </span>
                    Register
                </button>
            </div>
            <div class="mt-6 flex items-center justify-center">
                <div class="text-sm leading-5">
                    <a href="/login"
                       class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                        Already have an account?
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
