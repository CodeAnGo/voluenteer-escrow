<form action="{{ route('transfers.evidence.store', $transfer_id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="evidence[]" class="text-sm leading-5 font-medium text-gray-500">
        Evidence
    </label>
    <div class="mt-1 rounded-md shadow-sm">
        <input id="evidence[]" name="evidence[]" type="file" value="{{ old('evidence[]') }}" multiple required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
    </div>
    @error('evidence.*')
        <div class="mt-1 rounded-md shadow-sm">
            <p class="text-red-600 text-sm tracking-wide font-light">
                {{ $message }}
            </p>
        </div>
    @enderror
    <button type="submit" class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
        Upload Evidence
    </button>
</form>
