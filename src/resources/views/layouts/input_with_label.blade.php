<div class="w-full">
    <dt>
        <label for="{{ $input_id }}" class="text-sm leading-5 font-medium text-gray-500">
            {{ $label }}
        </label>
    </dt>
    <dd>
        <div class="mt-1 rounded-md shadow-sm">
            @if(!isset($input_type) || ($input_type !== 'select' && $input_type !== 'textarea'))
                <input
                    id="{{ $input_id }}"
                    name="{{ $input_id }}"
                    type="{{ $input_type ?? 'text' }}"
                    @isset($value) value="{{ $value }}" @endif
                    @if($required ?? false) required @endif
                    class="@error($input_id) border-red-500 @enderror appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                />
            @elseif($input_type === 'textarea')
                <textarea
                    id="{{ $input_id }}"
                    name="{{ $input_id }}"
                    type="textarea"
                    @if($required ?? false) required @endif
                    class="@error($input_id) border-red-500 @enderror appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                >@isset($value){{ $value }}@endif</textarea>
            @elseif($input_type === 'select')
                <select
                    id="{{ $input_id }}"
                    name="{{ $input_id }}"
                    class="@error($input_id) border-red-500 @enderror mt-1 block form-select w-full py-2 px-3 py-0 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                >
                    @if(isset($input_default_value) || !isset($value))
                        <option value="@isset($input_default_id){{ $input_default_id }}@endif">{{ $input_default_value ?? '-' }}</option>
                    @endif
                    @if(isset($input_items))
                        @foreach ($input_items  as $item)
                            <option value="{{ $item->id }}" @if(isset($value) && $item->id === $value) selected @endif>{{ $item->name }}</option>
                        @endforeach
                    @endif
                </select>
            @endif
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
