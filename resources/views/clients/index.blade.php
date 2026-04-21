<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Clients
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Add Client Form -->
            <div class="bg-white shadow rounded p-6">
                <form method="POST" action="{{ route('clients.store') }}" class="space-y-4">
                    @csrf

                    <input type="text" name="name" placeholder="Client Name"
                        class="w-full border rounded px-3 py-2" required>

                    <input type="email" name="email" placeholder="Email"
                        class="w-full border rounded px-3 py-2">

                    <input type="text" name="company" placeholder="Company"
                        class="w-full border rounded px-3 py-2">

                    <textarea name="notes" placeholder="Notes"
                        class="w-full border rounded px-3 py-2"></textarea>

                    <button class="bg-blue-600 text-white px-4 py-2 rounded">
                        Add Client
                    </button>
                </form>

                <!-- Error Messages -->
                @if ($errors->any())
                    <ul class="mt-4 list-disc pl-5 text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Search -->
            <div class="bg-white shadow rounded p-6">
                <form method="GET" action="{{ route('clients.index') }}" class="flex gap-2">
                    <input type="text" name="search"
                        value="{{ request('search') }}"
                        placeholder="Search client..."
                        class="w-full border rounded px-3 py-2">

                    <button class="bg-gray-800 text-white px-4 py-2 rounded">
                        Search
                    </button>
                </form>
            </div>

            <!-- Client Table -->
            <div class="bg-white shadow rounded p-6">

                @if($clients->isEmpty())
                    <p class="text-gray-500">No clients found.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-4 py-2 text-left">Name</th>
                                    <th class="px-4 py-2 text-left">Email</th>
                                    <th class="px-4 py-2 text-left">Company</th>
                                    <th class="px-4 py-2 text-left">Created</th>
                                    <th class="px-4 py-2 text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($clients as $client)
                                    <tr class="border-t hover:bg-gray-50">

                                        <td class="px-4 py-2 font-medium">
                                            {{ $client->name }}
                                        </td>

                                        <td class="px-4 py-2 text-sm text-gray-600">
                                            {{ $client->email ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2 text-sm text-gray-600">
                                            {{ $client->company ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2 text-sm text-gray-500">
                                            {{ $client->created_at->diffForHumans() }}
                                        </td>

                                        <td class="px-4 py-2 text-right">
                                            <div class="flex justify-end gap-2">

                                                <!-- Edit -->
                                                <a href="{{ route('clients.edit', $client->id) }}"
                                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                                    Edit
                                                </a>

                                                <!-- Delete -->
                                                <form method="POST"
                                                      action="{{ route('clients.destroy', $client->id) }}"
                                                      onsubmit="return confirm('Delete this client?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                        Delete
                                                    </button>
                                                </form>

                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $clients->links() }}
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>