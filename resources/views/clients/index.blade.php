<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Clients
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Add Client Form -->
            <div class="bg-white shadow rounded p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Add Client</h3>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('clients.store') }}" class="space-y-4">
                    @csrf

                    <input type="text" name="name"
                        value="{{ old('name') }}"
                        class="w-full border rounded px-3 py-2" required>

                    <input type="email" name="email"
                        value="{{ old('email') }}"
                        class="w-full border rounded px-3 py-2">

                    <input type="text" name="company"
                        value="{{ old('company') }}"
                        class="w-full border rounded px-3 py-2">

                    <textarea name="notes"
                        class="w-full border rounded px-3 py-2">{{ old('notes') }}</textarea>

                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded">
                        Add Client
                    </button>
                </form>
            </div>

            <!-- Client List -->
            <div class="bg-white shadow rounded p-6">
                <h3 class="text-lg font-semibold mb-4">Client List</h3>

                @if($clients->isEmpty())
                    <p class="text-gray-500">No clients yet.</p>
                @else
                    <ul class="space-y-2">
                        @foreach($clients as $client)
                            <li class="border p-3 rounded flex justify-between items-center">
                                <div>
                                    <strong>{{ $client->name }}</strong><br>
                                    <span class="text-sm text-gray-600">
                                        {{ $client->email ?? 'No email' }}
                                    </span>
                                </div>

                                <div class="flex gap-2">
                                    <a href="{{ route('clients.edit', $client) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded">
                                        Edit
                                    </a>

                                    <form action="{{ route('clients.destroy', $client) }}" method="POST"
                                            onsubmit="return confirm('Delete this client?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="bg-red-600 text-white px-3 py-1 rounded">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>