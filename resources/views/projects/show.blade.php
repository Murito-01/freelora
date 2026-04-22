<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Project Detail
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">

            <h3 class="text-lg font-bold mb-2">
                {{ $project->name }}
            </h3>

            <p class="text-gray-600 mb-4">
                {{ $project->description ?? 'No description' }}
            </p>

            <p class="mb-4">
                Status:
                <span class="px-2 py-1 rounded text-white
                    {{ $project->status === 'active' ? 'bg-green-500' : 'bg-gray-500' }}">
                    {{ ucfirst($project->status) }}
                </span>
            </p>

            <hr class="my-6">

            <h4 class="font-semibold mb-2">Tasks</h4>

            <!-- Add Task -->
            <form method="POST" action="{{ route('projects.tasks.store', $project->id) }}" class="flex gap-2 mb-4">
                @csrf
                <input type="text" name="title"
                    placeholder="New task..."
                    class="border px-3 py-2 rounded w-full">
                <button class="bg-blue-500 text-white px-4 py-2 rounded">Add</button>
            </form>

            <!-- Task List -->
            <div class="space-y-2">
                @foreach($project->tasks as $task)
                    <div class="flex justify-between items-center border px-3 py-2 rounded">

                        <span class="{{ $task->is_completed ? 'line-through text-gray-500' : '' }}">
                            {{ $task->title }}
                        </span>

                        <form method="POST" action="{{ route('tasks.toggle', $task->id) }}">
                            @csrf
                            @method('PATCH')

                            <button class="text-sm px-2 py-1 rounded
                                {{ $task->is_completed ? 'bg-gray-400 text-white' : 'bg-green-500 text-white' }}">
                                {{ $task->is_completed ? 'Undo' : 'Done' }}
                            </button>
                        </form>

                    </div>
                @endforeach
            </div>

            <form method="POST" action="{{ route('projects.updateStatus', $project->id) }}">
                @csrf
                @method('PATCH')

                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Toggle Status
                </button>
            </form>

        </div>
    </div>
</x-app-layout>