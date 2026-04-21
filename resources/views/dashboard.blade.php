<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Total Clients -->
                <div class="bg-white shadow rounded p-6">
                    <h3 class="text-gray-500 text-sm">Total Clients</h3>
                    <p class="text-3xl font-bold">{{ $totalClients }}</p>
                </div>

                <!-- Placeholder -->
                <div class="bg-white shadow rounded p-6">
                    <h3 class="text-gray-500 text-sm">Projects</h3>
                    <p class="text-3xl font-bold">0</p>
                </div>

                <div class="bg-white shadow rounded p-6">
                    <h3 class="text-gray-500 text-sm">Tasks</h3>
                    <p class="text-3xl font-bold">0</p>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>