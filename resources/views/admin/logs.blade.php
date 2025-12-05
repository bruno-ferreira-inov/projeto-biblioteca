<x-layout>
    <h1 class="text-2xl font-bold ml-2 mb-4">Activity Logs</h1>

    <!-- Filters -->
    <form method="GET" class="flex gap-4 mb-6">
        <select name="module" class="border ml-2 p-2 rounded">
            <option value="">All Modules</option>
            @foreach ($modules as $module)
                <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>
                    {{ $module }}
                </option>
            @endforeach
        </select>

        <select name="action" class="border p-2 rounded">
            <option value="">All Actions</option>
            <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Created</option>
            <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Updated</option>
            <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Deleted</option>
        </select>

        <button class="btn-primary">Filter</button>
    </form>

    <!-- Logs Table -->
    <table class="w-full text-sm border-collapse">
        <thead class="bg-[#006D77] text-white">
            <tr class=" text-left">
                <th class="p-2 border">Date</th>
                <th class="p-2 border">User</th>
                <th class="p-2 border">Action</th>
                <th class="p-2 border">Module</th>
                <th class="p-2 border">Object ID</th>
                <th class="p-2 border">IP</th>
                <th class="p-2 border">Browser</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td class="p-2 border">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                    <td class="p-2 border">{{ $log->user->name ?? 'System' }}</td>
                    <td class="p-2 border capitalize">{{ $log->action }}</td>
                    <td class="p-2 border">{{ $log->module }}</td>
                    <td class="p-2 border">{{ $log->object_id }}</td>
                    <td class="p-2 border">{{ $log->ip_address }}</td>
                    <td class="p-2 border text-sm">
                        {{ Str::limit($log->browser, 25) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</x-layout>