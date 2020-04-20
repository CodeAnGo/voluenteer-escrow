<a href="{{ route('transfers.edit', $transfer->id) }}" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg border-b-2 border-indigo-500 hover:border-indigo-700 bg-white hover:bg-indigo-500 text-md font-medium text-indigo-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
    <span class="mr-2 hidden md:inline-flex">{{ __('transfers.edit_transfer') }}</span>
    <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.edit') }}</span>
    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
    </svg>
</a>
<form class="hidden" action="{{ route('transfers.update', $transfer->id) }}" method="POST" id="acceptForm">
    @csrf
    @method('PUT')
    <input type="hidden" name="statusTransition" value="{{\App\TransferStatusTransitions::ToAccepted}}"/>
</form>
