<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-hidden overflow-x-auto p-6 bg-white border-b border-gray-200">
                        <div class="min-w-full align-middle">
                            @can('create', \App\Models\Task::class)
                            <a href="{{ route('tasks.create') }}" class="underline">Add new task</a>
                            <br /><br />
                            @endcan
                            <table class="min-w-full divide-y divide-gray-200 border">
                                <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left">
                                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">
                                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">User</span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">
                                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Due Date</span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">

                                    </th>
                                </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                @foreach($tasks as $task)
                                    <tr class="bg-white">
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            {{ $task->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            {{ $task->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            {{ $task->due_date }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            @can('update', $task)
                                                <a href="{{ route('tasks.edit', $task) }}" class="underline">Edit</a>
                                            @endcan
                                            @can('delete', $task)
                                                |
                                                <form action="{{ route('tasks.destroy', $task) }}"
                                                      method="POST"
                                                      class="inline-block"
                                                      onsubmit="return confirm('Are you sure?')">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="underline text-red-600">Delete</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
