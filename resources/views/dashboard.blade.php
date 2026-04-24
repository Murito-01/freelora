<x-app-layout>
    <div class="max-w-5xl mx-auto py-8">

        <h2 class="text-2xl font-bold mb-6">
            Dashboard
        </h2>

        <!-- STATS GRID -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">

            <div class="bg-white shadow p-4 rounded text-center">
                <p class="text-sm text-gray-500">Clients</p>
                <p class="text-xl font-bold">{{ $clients }}</p>
            </div>

            <div class="bg-white shadow p-4 rounded text-center">
                <p class="text-sm text-gray-500">Projects</p>
                <p class="text-xl font-bold">{{ $projects }}</p>
            </div>

            <div class="bg-white shadow p-4 rounded text-center">
                <p class="text-sm text-gray-500">Tasks</p>
                <p class="text-xl font-bold">{{ $totalTasks }}</p>
            </div>

            <div class="bg-white shadow p-4 rounded text-center">
                <p class="text-sm text-gray-500">Completed</p>
                <p class="text-xl font-bold text-green-600">
                    {{ $completedTasks }}
                </p>
            </div>

            <div class="bg-white shadow p-4 rounded text-center">
                <p class="text-sm text-gray-500">Overdue</p>
                <p class="text-xl font-bold text-red-600">
                    {{ $overdueTasks }}
                </p>
            </div>

        </div>

        <!-- PROGRESS BAR -->
        @php
            $progress = $totalTasks > 0
                ? round(($completedTasks / $totalTasks) * 100)
                : 0;
        @endphp

        <div class="bg-white shadow p-4 rounded">
            <p class="text-sm text-gray-500 mb-2">Task Progress</p>

            <div class="w-full bg-gray-200 rounded h-3">
                <div class="bg-blue-500 h-3 rounded"
                    style="width: {{ $progress }}%"></div>
            </div>

            <p class="text-sm mt-2">
                {{ $progress }}% completed
            </p>
        </div>
    </div>
</x-app-layout>