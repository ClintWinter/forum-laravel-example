<x-master>
    <div class="w-1/2 py-20 mx-auto">
        @if ($errors->any())
            <div class="mb-4">
                <div class="font-medium text-red-600">{{ 'Whoops! Something went wrong.' }}</div>

                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <label class="block font-medium text-sm text-gray-700">Email</label>
                <input class="form-input rounded-md shadow-sm block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <label class="block font-medium text-sm text-gray-700">Password</label>
                <input class="form-input rounded-md shadow-sm block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <label class="block font-medium text-sm text-gray-700">Confirm Password</label>
                <input class="form-input rounded-md shadow-sm block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="inline-flex items-center ml-4 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"
                >{{ __('Reset Password') }}</button>
            </div>
        </form>
    </div>
</x-master>
