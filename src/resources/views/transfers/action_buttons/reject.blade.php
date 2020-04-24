<button type="submit" form="rejectForm" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md border-b-2 border-red-500 hover:border-red-700 focus:border-red-700 bg-white hover:bg-red-500 focus:bg-red-500 text-md font-medium text-red-500 hover:text-white focus:text-white transition duration-150 ease-in-out">
    <span class="mr-2 hidden md:inline-flex">{{ __('transfers.reject_transfer') }}</span>
    <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.reject') }}</span>
    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
        <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
</button>
<form class="hidden" action="{{ route('transfers.update.status', [$transfer->id, \App\TransferStatusTransitions::ToRejected]) }}" method="POST" id="rejectForm">
    @csrf
</form>
