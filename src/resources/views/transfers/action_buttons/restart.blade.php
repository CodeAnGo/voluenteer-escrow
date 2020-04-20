<button type="submit" form="restartForm" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg border-b-2 border-green-500 hover:border-green-700 bg-white hover:bg-green-500 text-md font-medium text-green-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
    <span class="mr-2 hidden md:inline-flex">{{ __('transfers.restart_transfer') }}</span>
    <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.restart') }}</span>
    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
    </svg>
</button>
<form class="hidden" action="{{ route('transfers.update', $transfer->id) }}" method="POST" id="restartForm">
    @csrf
    @method('PUT')
    <input type="hidden" name="statusTransition" value="{{\App\TransferStatusTransitions::ToAwaitingAcceptance}}"/>
</form>
