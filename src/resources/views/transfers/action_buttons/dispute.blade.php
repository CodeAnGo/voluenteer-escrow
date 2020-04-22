<div @click.away="open = false" x-data="{ open: false }" class="items-center">
    <button @click="open = !open" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg border-b-2 border-red-500 hover:border-red-700 bg-white hover:bg-red-500 text-md font-medium text-red-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
        <span class="mr-2 hidden md:inline-flex">{{ __('transfers.dispute_transfer') }}</span>
        <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.dispute') }}</span>
        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
            <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </button>
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
         class="origin-center mt-2 rounded-md shadow-lg absolute w-auto">
        <div class="py-1 rounded-md bg-white shadow-xs p-5">
            <div class="mt-6">
                <form>
                    <label for="disputeReason" class="block text-sm font-medium leading-5 text-gray-700">
                        Dispute Reason
                    </label>
                    <div class="mt-1 rounded-md shadow-sm">
                            <textarea id="disputeReason" name="disputeReason" required rows="3" col="50" class="appearance-none block w-full text-sm px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="Please write the reason for raising the dispute."></textarea>
                    </div>
                    <label for="disputeReason" class="block text-sm font-medium leading-5 text-gray-500">
                        This information will be used to support your dispute.
                    </label>
                    <br/>
                    <label for="disputeEvidence" class="font-bold block text-sm font-medium leading-5 text-gray-700">
                        Attach Evidence
                    </label>
                    <div class="mt-1 rounded-md shadow-sm">
                        <input id="disputeEvidence" name="disputeEvidence" type="file" required accept="image/x-png,image/jpeg" class="appearance-none block w-full text-sm px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out"/>
                    </div>
                    <label for="disputeEvidence" class="block text-sm font-medium leading-5 text-gray-500">
                        Please include any relevant images to support your dispute claim.
                    </label>
                    <div class="mt-1 rounded-md shadow-sm flex flex-row justify-end py-1">
                        <button type="button" @click="open = !open" class="ml-2 inline-flex items-center justify-center py-2 px-4 rounded bg-transparent text-md font-medium text-red-500 hover:text-red-700 focus:outline-none transition duration-150 ease-in-out">
                            <span class="mr-2 inline-flex">{{ __('common.cancel') }}</span>
                        </button>
                        <button type="submit" form="submitDisputeForm" class="ml-2 inline-flex items-center justify-center py-2 px-4 rounded bg-transparent text-md font-medium text-green-500 hover:text-green-700 focus:outline-none transition duration-150 ease-in-out">
                            <span class="mr-2 inline-flex">{{ __('common.submit') }}</span>
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
