<div>
    <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>

    <div class="py-4 space-y-4">

        <div class="flex justify-between items-center">
            <div class="flex items-center w-1/2 space-x-2">
                <x-input.text wire:model="filters.search" placeholder="Search Transactions..."></x-input.text>
                <div>
                    <x-button.link wire:click="$toggle('showFilters', true)">@if($showFilters) Hide @endif Advanced
                        Search
                    </x-button.link>
                </div>
            </div>

            <div>

                <x-dropdown label="Bulk Actions">
                    <x-dropdown.item type="button" wire:click="exportSelected" class="flex items-center space-x-2">
                        <x-icon.download class="text-cool-gray-400"></x-icon.download>
                        <span>Export</span>
                    </x-dropdown.item>
                    <x-dropdown.item type="button" wire:click="deleteSelected" class="flex items-center space-x-2">
                        <x-icon.trash class="text-cool-gray-400"></x-icon.trash>
                        <span>Delete</span>
                    </x-dropdown.item>
                </x-dropdown>

                <x-button.primary wire:click="create">
                    <x-icon.plus></x-icon.plus>
                    New
                </x-button.primary>
            </div>

        </div>

        <div>
            @if($showFilters)
                <div class="bg-cool-gray-200 p-4 rounded shadow-inner flex relative">
                    <div class="w-1/2 pr-2 space-y-4">
                        <x-input.group inline for="filter-status" label="Status">
                            <x-input.select wire:model="filters.status" id="filter-status">
                                <option value="" disabled>Select Status...</option>

                                @foreach (App\Models\Transaction::STATUSES as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>

                        <x-input.group inline for="filter-amount-min" label="Minimum Amount">
                            <x-input.money wire:model.lazy="filters.amount-min" id="filter-amount-min"></x-input.money>
                        </x-input.group>

                        <x-input.group inline for="filter-amount-max" label="Maximum Amount">
                            <x-input.money wire:model.lazy="filters.amount-max" id="filter-amount-max"></x-input.money>
                        </x-input.group>
                    </div>

                    <div class="w-1/2 pl-2 space-y-4">
                        <x-input.group inline for="filter-date-min" label="Minimum Date">
                            <x-input.date wire:model="filters.date-min" id="filter-date-min"
                                          placeholder="YYYY-MM-DD"></x-input.date>
                        </x-input.group>

                        <x-input.group inline for="filter-date-max" label="Maximum Date">
                            <x-input.date wire:model="filters.date-max" id="filter-date-max"
                                          placeholder="YYYY-MM-DD"></x-input.date>
                        </x-input.group>

                        <x-button.link wire:click="resetFilters" class="absolute right-0 bottom-0 p-4">Reset Filters
                        </x-button.link>
                    </div>
                </div>
            @endif
        </div>

        <div class="flex-col space-y-4">
            @json($selected)
            <x-table>
                <x-slot name="head">
                    <x-table.heading class="pr-0 w-4">
                        <x-input.checkbox wire:model="selectPage"></x-input.checkbox>
                    </x-table.heading>
                    <x-table.heading wire:click="sortBy('title')" sortable
                                     :direction="$sortField === 'title' ? $sortDirection: null">Title
                    </x-table.heading>
                    <x-table.heading wire:click="sortBy('amount')" sortable
                                     :direction="$sortField === 'amount' ? $sortDirection: null">Amount
                    </x-table.heading>
                    <x-table.heading wire:click="sortBy('status')" sortable
                                     :direction="$sortField === 'status' ? $sortDirection: null">Status
                    </x-table.heading>
                    <x-table.heading wire:click="sortBy('date')" sortable
                                     :direction="$sortField === 'date' ? $sortDirection: null">Date
                    </x-table.heading>
                    <x-table.heading></x-table.heading>
                </x-slot>

                <x-slot name="body">
                    @if($selectPage)
                        <x-table.row class="bg-cool-gray-200">
                            <x-table.cell colspan="6">
                                @unless ($selectAll)
                                    You selected <strong>10</strong> transactions, do you want to select all
                                    <strong>{{ $transactions->total() }}</strong> transactions?
                                    <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select all
                                    </x-button.link>
                                @else
                                    You are currently selecting all <strong>{{ $transactions->total() }}</strong>
                                    transactions.
                                @endif
                            </x-table.cell>
                        </x-table.row>
                    @endif
                    @forelse ($transactions as $transaction)
                        <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{$transaction->id}}">
                            <x-table.cell class="pr-0">
                                <x-input.checkbox wire:model="selected"
                                                  value="{{ $transaction->id }}"></x-input.checkbox>
                            </x-table.cell>
                            <x-table.cell>
                            <span href="#" class="inline-flex space-x-2 truncate text-sm leading-5">
                                <x-icon.cash class="text-cool-gray-400"></x-icon.cash>

                                <p class="text-cool-gray-600 truncate">
                                    {{ $transaction->title }}
                                </p>
                            </span>
                            </x-table.cell>
                            <x-table.cell>
                                <span class="text-cool-gray-500 font-medium">${{ $transaction->amount }}</span> USD
                            </x-table.cell>
                            <x-table.cell>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-{{ $transaction->status_color }}-100 text-{{ $transaction->status_color }}-800 capitalize">
                                {{ $transaction->status }}
                            </span>
                            </x-table.cell>
                            <x-table.cell>
                                {{ $transaction->date_for_humans }}
                            </x-table.cell>
                            <x-table.cell>
                                <x-button.link wire:click="edit({{ $transaction->id }})">Edit</x-button.link>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="6">
                                <div class="py-8 flex justify-center items-center">
                                    <x-icon.inbox class="h-8 w-8 text-cool-gray-400"></x-icon.inbox>
                                    <span class="ml-1 font-medium text-cool-gray-400 text-xl">No transaction found...</span>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot>
            </x-table>

            <div>
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
    <form wire:submit.prevent="save">
        <x-modal.dialog wire:model.defer="showEditModal">
            <x-slot name="title">Edit Transaction</x-slot>
            <x-slot name="content">
                <x-input.group for="title" label="Title" :error="$errors->first('editing.title')">
                    <x-input.text name="title" id="title" wire:model="editing.title" placeholder="Title"></x-input.text>
                </x-input.group>

                <x-input.group for="amount" label="Amount" :error="$errors->first('editing.amount')">
                    <x-input.money name="amount" id="amount" wire:model="editing.amount"
                                   placeholder="Amount"></x-input.money>
                </x-input.group>

                <x-input.group for="status" label="Status" :error="$errors->first('editing.status')">
                    <x-input.select name="status" id="status" wire:model="editing.status">
                        @foreach(App\Models\Transaction::STATUSES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-input.select>
                </x-input.group>

                <x-input.group for="date_for_editing" label="Date" :error="$errors->first('editing.date_for_editing')">
                    <x-input.date name="date_for_editing" id="date_for_editing"
                                  wire:model="editing.date_for_editing"></x-input.date>
                </x-input.group>
            </x-slot>
            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showEditModal', false)">Cancel</x-button.secondary>
                <x-button.primary type="submit">Save</x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
