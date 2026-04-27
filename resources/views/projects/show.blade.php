<x-app-layout>
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-8">

    <!-- Back -->
    <a href="{{ route('clients.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white mb-6 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Clients
    </a>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-8">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white tracking-tight">{{ $project->name }}</h1>
            <div class="flex items-center gap-2 mt-1.5">
                <span class="text-sm text-gray-400 dark:text-gray-500">{{ $project->client->name }}</span>
                <span class="text-gray-300 dark:text-gray-700">·</span>
                <span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-0.5 rounded-full
                    {{ $project->status === 'completed'
                        ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400'
                        : 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $project->status === 'completed' ? 'bg-emerald-400' : 'bg-indigo-400' }}"></span>
                    {{ ucfirst($project->status) }}
                </span>
            </div>
        </div>
        <form method="POST" action="{{ route('projects.updateStatus', $project->id) }}">
            @csrf
            @method('PATCH')
            <button class="px-3 py-1.5 text-xs font-medium rounded-lg transition
                {{ $project->status === 'active'
                    ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-900/40'
                    : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                {{ $project->status === 'active' ? 'Mark as Completed' : 'Reopen Project' }}
            </button>
        </form>
    </div>

    <!-- Filter Tabs -->
    @php $current = request('status'); @endphp
    <div class="flex gap-1 mb-6 bg-gray-100 dark:bg-gray-800/60 p-1 rounded-lg w-fit">
        @foreach([null => 'All', 'todo' => 'Todo', 'in_progress' => 'In Progress', 'done' => 'Done'] as $val => $label)
            <a href="{{ $val ? '?status='.$val : '?' }}"
               class="px-3 py-1.5 text-xs font-medium rounded-md transition
                   {{ ($current === $val || ($current === null && $val === null))
                       ? 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm'
                       : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <!-- Add Task -->
    <form method="POST" action="{{ route('projects.tasks.store', $project->id) }}" class="flex gap-2 mb-6">
        @csrf
        <input type="text" name="title" placeholder="Add a new task..."
            class="flex-1 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-lg px-3 py-2 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
        <input type="date" name="deadline"
            class="border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
        <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition">
            Add
        </button>
    </form>

    <!-- Task List -->
    <div class="space-y-2 mb-8">
        @forelse($tasks as $task)
            <div class="flex justify-between items-center p-4 rounded-xl border transition hover:shadow-sm
                {{ ($task->deadline && $task->deadline->isPast() && $task->status !== 'done')
                    ? 'bg-rose-50 dark:bg-rose-900/10 border-rose-200 dark:border-rose-900/40'
                    : 'bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-800 dark:hover:border-gray-700' }}">

                <!-- Left -->
                <div class="flex items-center gap-3 min-w-0">
                    <!-- Status dot -->
                    <span class="w-2 h-2 rounded-full shrink-0
                        @if($task->status == 'done') bg-emerald-400
                        @elseif($task->status == 'in_progress') bg-amber-400
                        @else bg-gray-300 dark:bg-gray-600
                        @endif"></span>

                    <div class="min-w-0">
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100 {{ $task->status === 'done' ? 'line-through text-gray-400 dark:text-gray-500' : '' }}">
                            {{ $task->title }}
                        </span>
                        <div class="flex items-center gap-2 mt-0.5">
                            @if($task->deadline)
                                <span class="text-xs {{ ($task->deadline->isPast() && $task->status !== 'done') ? 'text-rose-500' : 'text-gray-400 dark:text-gray-500' }}">
                                    Due {{ $task->deadline->format('d M Y') }}
                                </span>
                            @endif
                            <span class="text-xs px-1.5 py-0.5 rounded font-medium
                                @if($task->status == 'todo') bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400
                                @elseif($task->status == 'in_progress') bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400
                                @elseif($task->status == 'done') bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400
                                @endif">
                                {{ $task->status }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right: Status Dropdown -->
                <form method="POST" action="{{ route('tasks.update', $task->id) }}" class="shrink-0">
                    @csrf
                    @method('PUT')
                    <select name="status" onchange="this.form.submit()"
                        class="text-xs border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition cursor-pointer">
                        <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>Todo</option>
                        <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                </form>
            </div>
        @empty
            <div class="text-center py-10 text-gray-400 dark:text-gray-500">
                <svg class="w-8 h-8 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="text-sm">No tasks found.</p>
            </div>
        @endforelse
    </div>

    <!-- Invoice Section -->
    <div class="border-t border-gray-200 dark:border-gray-800 pt-8">

        <!-- Create Invoice -->
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5 mb-4">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Create Invoice</h3>
            <form method="POST" action="{{ route('invoices.store', $project->id) }}" class="flex flex-col sm:flex-row gap-2">
                @csrf
                <input type="number" name="amount" placeholder="Amount (Rp)"
                    class="flex-1 border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg px-3 py-2 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                <input type="date" name="due_date"
                    class="border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition">
                    Create
                </button>
            </form>
        </div>

        <!-- Invoice List -->
        <div>
            <h3 class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">Invoices</h3>
            <div class="space-y-2">
                @forelse($project->invoices as $invoice)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 hover:shadow-sm transition">

                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $invoice->number }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Rp{{ number_format($invoice->amount, 0, ',', '.') }}</p>
                            @if($invoice->due_date)
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Due {{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</p>
                            @endif
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <!-- Status Toggle -->
                            <form method="POST" action="{{ route('invoices.updateStatus', $invoice->id) }}">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                    class="text-xs font-medium border rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition cursor-pointer
                                        {{ $invoice->status === 'paid'
                                            ? 'border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400'
                                            : 'border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400' }}">
                                    <option value="unpaid" {{ $invoice->status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="paid" {{ $invoice->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                            </form>

                            <!-- Send -->
                            <form method="POST" action="{{ route('invoices.send', $invoice->id) }}">
                                @csrf
                                <button class="px-3 py-1.5 text-xs font-medium bg-indigo-50 dark:bg-indigo-900/20 hover:bg-indigo-100 dark:hover:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 rounded-lg transition">
                                    Send
                                </button>
                            </form>

                            <!-- Download PDF -->
                            <a href="{{ route('invoices.download', $invoice->id) }}"
                               class="px-3 py-1.5 text-xs font-medium bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-lg transition">
                                PDF
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 dark:text-gray-500 py-3">No invoices yet</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-emerald-500 text-white text-sm px-4 py-2.5 rounded-xl shadow-lg animate-fade-in z-50">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="fixed bottom-4 right-4 bg-rose-500 text-white text-sm px-4 py-2.5 rounded-xl shadow-lg animate-fade-in z-50">
            {{ session('error') }}
        </div>
    @endif

</div>
</x-app-layout>