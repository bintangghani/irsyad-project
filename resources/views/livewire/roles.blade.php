<div>
    <x-innerpage-layout>
        @section('title', 'Customers')
        <x-slot name="header">
            <x-slot name="title">
                {{ __('Customers') }}
            </x-slot>

            <x-slot name="subtitle">
                {{ __('Manage All Customers.') }}
            </x-slot>
            <x-slot name="action">
                {{-- modal action --}}
                <button wire:click="confirmCreate" wire:loading.attr="disabled" class="btn btn-primary d-none d-sm-inline-block">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
                    Create new customer
                </button>
                <button wire:click="confirmCreate" wire:loading.attr="disabled" class="btn btn-primary d-sm-none btn-icon" aria-label="Create new report">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
                </button>
            </x-slot>
        </x-slot>


        @include('livewire.customers.create')
        @include('livewire.customers.delete')
        <div class="row row-cards">
            <div class="col-12">
                <x-table :columns="$columns" :page="$page" :perPage="$perPage" :items="$customers" :sortColumn="$sortColumn" :sortDirection="$sortDirection" isModalEdit="true">
                    <x-slot name="title">
                        {{ __('Customer') }}
                    </x-slot>
                </x-table>
            </div>
        </div>
    </x-innerpage-layout>
</div>