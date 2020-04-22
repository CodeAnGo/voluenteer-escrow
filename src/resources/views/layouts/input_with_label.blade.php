<div class="w-full">
    <dt>
        <label for="{{ $input_id }}" class="text-sm leading-5 font-medium text-gray-500">
            {{ $label }}
        </label>
    </dt>
    <dd>
        <div class="mt-1 rounded-md shadow-sm">
            <input
                id="{{ $input_id }}"
                name="{{ $input_id }}"
                type="{{ $input_type ?? 'text' }}"
                @isset($value) value="{{ $value }}" @endif
                @if($required ?? false) required @endif
                class="@error($input_id) border-red-500 @enderror appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
            />
        </div>
        @error($input_id)
        <div class="mt-1 rounded-md shadow-sm">
            <p class="text-red-600 text-sm tracking-wide font-light">
                {{ $message }}
            </p>
        </div>
        @enderror
    </dd>
</div>
