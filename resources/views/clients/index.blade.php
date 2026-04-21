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

                <form method="POST" action="{{ route('clients.store') }}" class="space-y-4">
                    @csrf

                    <input type="text" name="name" placeholder="Name"
                        class="w-full border rounded px-3 py-2" required>

                    <input type="email" name="email" placeholder="Email"
                        class="w-full border rounded px-3 py-2">

                    <input type="text" name="company" placeholder="Company"
                        class="w-full border rounded px-3 py-2">

                    <textarea name="notes" placeholder="Notes"
                        class="w-full border rounded px-3 py-2"></textarea>

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
                            <li class="border p-3 rounded">
                                <strong>{{ $client->name }}</strong><br>
                                <span class="text-sm text-gray-600">
                                    {{ $client->email ?? 'No email' }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>