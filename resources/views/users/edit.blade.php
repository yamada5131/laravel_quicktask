<x-app-layout>
    <x-slot name="header">
        <div class="space-y-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Create New User') }}
                </h2>
            </div>
            <form method="POST" action="/users/{{ $user->id }}">
                @csrf
                @method('PATCH')
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-12">
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="first_name"
                                    class="block text-sm font-medium leading-6 text-gray-900">Firstname</label>
                                <div class="mt-2">
                                    <div
                                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                        <input type="text" name="first_name" id="first_name"
                                            autocomplete="first_name" value="{{ $user->first_name }}"
                                            class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                            </div>
                                    </div>
                                </div>
                                <div class="sm:col-span-4">
                                    <label for="last_name"
                                        class="block text-sm font-medium leading-6 text-gray-900">Lastname</label>
                                    <div class="mt-2">
                                        <div
                                            class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                            <input type="text" name="last_name" id="last_name"
                                                autocomplete="last_name"
                                                class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                                value="{{ $user->last_name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="sm:col-span-4">
                                    <label for="email"
                                        class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                                    <div class="mt-2">
                                        <div
                                            class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                            <span
                                                class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">workcation.com/</span>
                                            <input type="text" name="email" id="email" autocomplete="email"
                                                class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                                value="{{ $user->email }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="sm:col-span-4">
                                    <label for="password"
                                        class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                                    <div class="mt-2">
                                        <div
                                            class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                            <input type="text" name="password" id="password" autocomplete="password"
                                                value="{{ $user->password }}"
                                                class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                            <button type="submit"
                                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                        </div>
            </form>

        </div>

    </x-slot>

</x-app-layout>
