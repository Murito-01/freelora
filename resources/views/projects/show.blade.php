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
            <div class="flex justify-between items-center border border-gray-200 p-4 rounded-xl hover:shadow-sm transition"
                @if($task->deadline && $task->deadline->isPast() && $task->status !== 'done')
                    bg-red-100 border-red-300
                @endif
            ">

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

                        <!-- DROPDOWN STATUS -->
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
    </div>
</x-app-layout>