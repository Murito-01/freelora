<x-app-layout>
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white tracking-tight">Clients</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage your client relationships</p>
        </div>

        <!-- Add Client (toggle button) -->
        <button onclick="document.getElementById('add-client-form').classList.toggle('hidden')"
                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Client
        </button>
    </div>

    <!-- Add Client Form (hidden by default) -->
    <div id="add-client-form" class="hidden mb-6">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-6">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">New Client</h3>
            <form method="POST" action="{{ route('clients.store') }}" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @csrf
                <input type="text" name="name" placeholder="Client Name" required
                    class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg px-3 py-2 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">

                <input type="email" name="email" placeholder="Email (optional)"
                    class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg px-3 py-2 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">

                <input type="text" name="company" placeholder="Company (optional)"
                    class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg px-3 py-2 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">

                <textarea name="notes" placeholder="Notes (optional)" rows="1"
                    class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg px-3 py-2 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none"></textarea>

                <div class="sm:col-span-2 flex gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition">
                        Save Client
                    </button>
                    <button type="button"
                        onclick="document.getElementById('add-client-form').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-medium rounded-lg transition">
                        Cancel
                    </button>
                </div>
            </form>

            @if ($errors->any())
                <ul class="mt-3 text-sm text-rose-500 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <!-- Search -->
    <div class="mb-6">
        <form method="GET" action="{{ route('clients.index') }}" class="flex gap-2">
            <div class="relative flex-1">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search clients..."
                    class="w-full pl-9 pr-3 py-2 text-sm border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            </div>
            <button class="px-4 py-2 bg-gray-900 dark:bg-gray-700 hover:bg-gray-700 dark:hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition">
                Search
            </button>
        </form>
    </div>

    <!-- Client List -->
    @if($clients->isEmpty())
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-12 text-center">
            <svg class="w-10 h-10 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
            </svg>
            <p class="text-gray-400 dark:text-gray-500 text-sm">No clients found. Add your first client above.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach($clients as $client)
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5 hover:shadow-sm dark:hover:border-gray-700 transition">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">

                    <!-- Client Info -->
                    <div class="flex items-start gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center shrink-0">
                            <span class="text-indigo-600 dark:text-indigo-400 text-sm font-semibold">{{ strtoupper(substr($client->name, 0, 1)) }}</span>
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $client->name }}</p>
                            <div class="flex flex-wrap gap-x-4 gap-y-0.5 mt-0.5">
                                @if($client->email)
                                    <p class="text-xs text-gray-400 dark:text-gray-500">{{ $client->email }}</p>
                                @endif
                                @if($client->company)
                                    <p class="text-xs text-gray-400 dark:text-gray-500">{{ $client->company }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('clients.edit', $client->id) }}"
                           class="px-3 py-1.5 text-xs font-medium bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-lg transition">
                            Edit
                        </a>
                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="inline"
                              onsubmit="return confirm('Delete this client?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1.5 text-xs font-medium bg-rose-50 dark:bg-rose-900/20 hover:bg-rose-100 dark:hover:bg-rose-900/40 text-rose-600 dark:text-rose-400 rounded-lg transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Projects -->
                @if($client->projects->count() > 0 || true)
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <div class="flex flex-wrap items-center gap-2">
                        @foreach($client->projects as $project)
                            <a href="{{ route('projects.show', $project->id) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium rounded-full
                                   {{ $project->status === 'completed'
                                       ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400'
                                       : 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-400' }}
                                   hover:opacity-80 transition">
                                <span class="w-1.5 h-1.5 rounded-full {{ $project->status === 'completed' ? 'bg-emerald-400' : 'bg-indigo-400' }}"></span>
                                {{ $project->name }}
                            </a>
                        @endforeach

                        <!-- Add Project inline -->
                        <form method="POST" action="{{ route('projects.store', $client->id) }}" class="flex gap-1.5">
                            @csrf
                            <input type="text" name="name" placeholder="New project..."
                                class="text-xs border border-dashed border-gray-300 dark:border-gray-700 bg-transparent text-gray-700 dark:text-gray-300 rounded-full px-3 py-1 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-32 transition">
                            <button class="w-6 h-6 flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white rounded-full text-sm transition shrink-0">
                                +
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $clients->links() }}
        </div>
    @endif

</div>
</x-app-layout>
