<div class="p-2 flex flex-row sm:flex-col items-center">
    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 mx-2 text-red-500">
        @if($status_final)
            <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        @else
            <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        @endif
    </svg>
    <div class="flex flex-col mx-2">
        <span class="font-medium tracking-wide @if($transfer->status >= $status_id) text-gray-900 @else text-gray-500 @endif">{{ $status_title }}</span>
        <span class="text-sm @if($transfer->status >= $status_id) text-gray-700 @else text-gray-500 @endif">{{ $status_message }}</span>
    </div>
</div>
