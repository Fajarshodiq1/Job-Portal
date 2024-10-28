<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Topup Wallet') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                <div class="flex flex-row justify-between items-center">
                    <div class="flex flex-row gap-x-5 items-center">
                        <!-- SVG icon here -->
                        <div>
                            <p class="text-slate-500 text-sm">Total Balance</p>
                            <h3 class="text-indigo-950 text-xl font-bold">Rp 0</h3>
                        </div>
                    </div>
                </div>
                <hr class="my-5">

                <div>
                    <h3 class="text-indigo-950 text-xl font-bold mb-5">Send Payment to:</h3>
                    <div class="flex flex-row gap-x-10">
                        <div>
                            <p class="text-slate-500 text-sm">Bank</p>
                            <h3 class="text-indigo-950 text-xl font-bold">Angga Capital</h3>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm">No Account</p>
                            <h3 class="text-indigo-950 text-xl font-bold">08123092093</h3>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm">Account Name</p>
                            <h3 class="text-indigo-950 text-xl font-bold">Gawebro Indonesia</h3>
                        </div>
                    </div>
                </div>

                <hr class="my-5">

                <h3 class="text-indigo-950 text-xl font-bold">Confirm Topup Wallet</h3>
                <form method="POST" action="{{ route('dashboard.wallet.topup.store') }}" enctype="multipart/form-data">
                    @csrf <!-- CSRF token for form protection -->

                    <!-- Input for Amount -->
                    <div>
                        <x-input-label for="amount" :value="__('Amount')" />
                        <x-text-input id="amount" class="block mt-1 w-full" type="text" name="amount"
                            :value="old('amount')" required autofocus />
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                    <!-- Input for Proof of Payment -->
                    <div class="mt-4">
                        <x-input-label for="proof" :value="__('Proof of Payment')" />
                        <x-text-input id="proof" class="block mt-1 w-full" type="file" name="proof" required />
                        <x-input-error :messages="$errors->get('proof')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            Confirm Topup
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
