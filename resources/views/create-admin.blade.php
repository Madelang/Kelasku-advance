<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Create admin') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Crate user with role admin can login dashboard.") }}
                            </p>
                        </header>



                        <form method="post" action="{{ route('admins.store') }}" class="mt-6 space-y-6"
                            enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <img id="image-preview" class="mt-2 w-36 h-36 hidden" />
                            <img id="image-preview" class="mt-2 w-36 h-36 hidden" />
                            <div>
                                <x-input-label for="image" :value="__('Image')" />
                                <x-text-input id="image" name="image" type="file" class="mt-1 block w-full"
                                    :value="old('image')" required autofocus autocomplete="image" />
                                <x-input-error class="mt-2" :messages="$errors->get('image')" />
                                <!-- Image preview -->
                            </div>
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                    :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                    :value="old('email')" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>
                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                                    :value="old('password')" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>
                            <div>
                                <label for="school_id"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an
                                    option</label>
                                <select id="school_id" name="school_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option disabled selected>Pilih sekolah</option>
                                    @foreach($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->school_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                </div>

                <div class="flex items-center gap-4 mt-3">
                    <x-primary-button>{{ __('Create') }}</x-primary-button>

                    @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
                    @endif
                </div>
                </form>
                </section>
            </div>
        </div>
    </div>
    </div>

    <x-slot name="footer">
        <script>
            document.getElementById('image').addEventListener('change', function(event) {
                const file = event.target.files[0];
                const preview = document.getElementById('image-preview');
                
                if (file) {
                    const reader = new FileReader();
                    preview.classList.remove('hidden');
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.src = '';
                    preview.classList.add('hidden');
                }
            });
        </script>
    </x-slot>
</x-app-layout>