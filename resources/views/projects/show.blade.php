<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">

        <!-- TITLE -->
        <h2 class="text-2xl font-semibold tracking-tight mb-2">
            {{ $project->name }}
        </h2>

        <p class="text-gray-600 mb-6">
            Project Tasks
        </p>

        <!-- FILTER -->
        @php $current = request('status'); @endphp

        <div class="flex gap-2 mb-6">
            <a href="?"
               class="px-3 py-1 rounded {{ !$current ? 'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition' : 'bg-gray-200' }}">
                All
            </a>

            <a href="?status=todo"
               class="px-3 py-1 rounded {{ $current=='todo' ? 'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition' : 'bg-gray-200' }}">
                Todo
            </a>

            <a href="?status=in_progress"
               class="px-3 py-1 rounded {{ $current=='in_progress' ? 'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition' : 'bg-gray-200' }}">
                In Progress
            </a>

            <a href="?status=done"
               class="px-3 py-1 rounded {{ $current=='done' ? 'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition' : 'bg-gray-200' }}">
                Done
            </a>
        </div>

        <!-- ADD TASK -->
        <form method="POST"
                action="{{ route('projects.tasks.store', $project->id) }}"
                class="flex gap-2 mb-6">
            @csrf

            <input type="text"
                name="title"
                placeholder="New task..."
                class="border px-3 py-2 rounded w-full">

            <input type="date"
                name="deadline"
                class="border px-3 py-2 rounded">

            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Add
            </button>
        </form>

        <!-- TASK LIST -->
        <div class="space-y-3">

            @forelse($tasks as $task)
            <div class="flex justify-between items-center border p-4 rounded-xl hover:shadow-sm transition
                {{ ($task->deadline && $task->deadline->isPast() && $task->status !== 'done')
                    ? 'bg-red-100 border-red-300'
                        : 'border-gray-200' }}">

                    <!-- LEFT SIDE -->
                    <div class="flex items-center gap-2">

                        <!-- TITLE -->
                        <span class="{{ $task->is_completed ? 'line-through text-gray-400' : '' }}">
                            {{ $task->title }}
                        </span>

                        @if($task->deadline)
                            <div class="text-xs text-gray-500">
                                Due: {{ $task->deadline->format('d M Y') }}
                            </div>
                        @endif

                        <!-- STATUS BADGE -->
                        <span class="px-2 py-1 text-xs rounded
                            @if($task->status == 'todo') bg-gray-300
                            @elseif($task->status == 'in_progress') bg-yellow-400
                            @elseif($task->status == 'done') bg-gradient-to-r from-green-400 to-green-600 text-white
                            @endif
                        ">
                            {{ $task->status }}
                        </span>

                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="flex items-center gap-2">

                        <!-- STATUS -->
                        <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                            @csrf
                            @method('PUT')

                            <select name="status"
                                    onchange="this.form.submit()"
                                    class="border rounded text-sm px-2 py-1">

                                <option value="todo" {{ $task->status=='todo' ? 'selected' : '' }}>
                                    Todo
                                </option>

                                <option value="in_progress" {{ $task->status=='in_progress' ? 'selected' : '' }}>
                                    In Progress
                                </option>

                                <option value="done" {{ $task->status=='done' ? 'selected' : '' }}>
                                    Done
                                </option>

                            </select>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No tasks found.</p>
            @endforelse
        </div>

        <!-- CREATE INVOICE -->
        <div class="mt-8 bg-white border border-gray-200 p-5 rounded-xl">
            <h3 class="font-semibold mb-4">Create Invoice</h3>

            <form method="POST" action="{{ route('invoices.store', $project->id) }}" class="flex gap-2">
                @csrf

                <input type="number" name="amount" placeholder="Amount"
                    class="border px-3 py-2 rounded w-full">

                <input type="date" name="due_date"
                    class="border px-3 py-2 rounded">

                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Create
                </button>
            </form>
        </div>

        <!-- INVOICE LIST -->
        <div class="mt-6">
            <h3 class="font-semibold mb-3">Invoices</h3>

            @forelse($project->invoices as $invoice)
                <div class="border border-gray-200 p-3 rounded-xl mb-2 flex justify-between items-center">

                    <span>{{ $invoice->number }}</span>

                    <div class="flex gap-2 items-center">
                        <span>Rp{{ number_format($invoice->amount, 0, ',', '.') }}</span>

                        <form method="POST" action="{{ route('invoices.updateStatus', $invoice->id) }}">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()"
                                class="border rounded text-sm px-2 py-1 {{ $invoice->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <option value="unpaid" {{ $invoice->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                        </form>

                        <form method="POST" action="{{ route('invoices.send', $invoice->id) }}">
                            @csrf

                            <button class="text-sm bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">
                                Send
                            </button>
    </form>

                        <a href="{{ route('invoices.download', $invoice->id) }}"
                            class="text-sm bg-gray-200 px-2 py-1 rounded hover:bg-gray-300">
                            PDF
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">No invoices yet</p>
            @endforelse
        </div>
    </div>
</x-app-layout>