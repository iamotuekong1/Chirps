<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('chirps.store') }}">
            @csrf
            <textarea
                name="message"
                placeholder="{{ __('What\'s on your mind?') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <x-primary-button class="mt-4">{{ __('Chirp') }}</x-primary-button>
        </form>

        <div class="mt-6 bg-white shadow-sm rounded-lg">
            @foreach ($chirps as $chirp)
                <div class="p-4 border-b">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <svg class="h-6 w-6 text-gray-600" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <!-- Your SVG icon -->
                            </svg>
                            <div>
                                <span class="font-semibold">{{ $chirp->user->name }}</span>
                                <small class="text-gray-600">{{ $chirp->created_at->format('j M Y, g:i a') }}</small>
                                @unless ($chirp->created_at->eq($chirp->updated_at))
                                    <small class="text-gray-600">{{ __('edited') }}</small>
                                @endunless
                            </div>
                        </div>
                        @if ($chirp->user->is(auth()->user()))
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <button>
                                        <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <!-- Your dropdown trigger icon -->
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('chirps.edit', $chirp)">
                                        {{ __('Edit') }}
                                    </x-dropdown-link>
                                    <form method="POST" action="{{ route('chirps.destroy', $chirp) }}">
                                        @csrf
                                        @method('delete')
                                        <x-dropdown-link :href="route('chirps.destroy', $chirp)" onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('Delete') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        @endif
                    </div>
                    <p class="mt-2 text-gray-800">{{ $chirp->message }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
