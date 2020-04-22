<div class="p-2 flex flex-row sm:flex-col items-center">
    @if($transfer->status > $status_id)
        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 mx-2 text-green-500">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    @elseif($transfer->status === $status_id)
        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 mx-2 text-indigo-500">
            <path class="inline-flex sm:hidden" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            <path class="hidden sm:inline-flex" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"></path>
        </svg>
    @else
        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 mx-2 text-gray-400">
            <path d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    @endif
    <div class="flex flex-col mx-2">
        <span class="font-medium tracking-wide @if($transfer->status >= $status_id) text-gray-900 @else text-gray-500 @endif">{{ $status_title }}</span>
        <span class="text-sm @if($transfer->status >= $status_id) text-gray-700 @else text-gray-500 @endif">{{ $status_message }}</span>
    </div>
</div>
