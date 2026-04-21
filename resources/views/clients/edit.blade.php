<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Client
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded p-6">

                <form method="POST" action="{{ route('clients.update', $client) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <input type="text" name="name"
                        value="{{ old('name', $client->name) }}"
                        class="w-full border rounded px-3 py-2" required>

                    <input type="email" name="email"
                        value="{{ old('email', $client->email) }}"
                        class="w-full border rounded px-3 py-2">

                    <input type="text" name="company"
                        value="{{ old('company', $client->company) }}"
                        class="w-full border rounded px-3 py-2">

                    <textarea name="notes"
                        class="w-full border rounded px-3 py-2">{{ old('notes', $client->notes) }}</textarea>

                    <button class="bg-blue-600 text-white px-4 py-2 rounded">
                        Update Client
                    </button>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>