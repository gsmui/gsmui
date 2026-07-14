<div class="min-h-screen bg-zinc-900">
    <header class="bg-zinc-800 border-b border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-white">GraphQL Explorer</h1>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-4">
                <h2 class="font-semibold text-white mb-4">Query</h2>
                <div class="bg-zinc-900 rounded-lg p-4 font-mono text-sm text-green-400 h-64 overflow-auto">
                    <pre>{
  users {
    id
    name
    email
    posts {
      title
      createdAt
    }
  }
}</pre>
                </div>
                <button class="mt-4 px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium w-full">Execute Query</button>
            </div>

            <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-4">
                <h2 class="font-semibold text-white mb-4">Response</h2>
                <div class="bg-zinc-900 rounded-lg p-4 font-mono text-sm text-blue-400 h-64 overflow-auto">
                    <pre>{
  "data": {
    "users": [
      {
        "id": 1,
        "name": "John",
        "email": "john@example.com",
        "posts": [...]
      }
    ]
  }
}</pre>
                </div>
                <div class="mt-4 flex items-center gap-4 text-xs text-zinc-400">
                    <span>⏱️ 45ms</span>
                    <span>📦 1.2 KB</span>
                    <span>✅ 200 OK</span>
                </div>
            </div>
        </div>
    </main>
</div>
