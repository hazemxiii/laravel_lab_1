<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Laravel Lab 1</title>
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen">
    <nav class="sticky top-0 z-50 glass border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <div class="bg-indigo-600 p-2 rounded-xl shadow-lg shadow-indigo-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">Laravel Lab 1</span>
                </div>
                <div class="flex items-center gap-2">
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-full shadow-md hover:bg-indigo-700 transition-all hover:scale-105 active:scale-95">
                            Logout
                        </button>
                    </form>
                    <a href="/posts/create" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-full shadow-md hover:bg-indigo-700 transition-all hover:scale-105 active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        New Post
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <header class="mb-8 flex items-center justify-between">
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">All Posts</h1>
            <span class="px-4 py-1.5 bg-indigo-100 text-indigo-700 text-sm font-semibold rounded-full">
                {{ $posts->total() }} post{{ $posts->total() !== 1 ? 's' : '' }}
            </span>
        </header>

        @if($posts->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-slate-200 mb-12">
            <div class="bg-slate-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 mb-4">No posts yet</h3>
            <a href="/posts/create" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-full shadow-lg hover:bg-indigo-700 transition-all">
                Create First Post
            </a>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            @foreach ($posts as $post)
            <article class="group relative bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col">
                <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
                <div class="p-8 flex-grow">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover rounded-2xl mb-4">
                    @endif

                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-bold uppercase tracking-wider rounded-full">Active</span>
                        <span class="text-slate-400 text-xs">• {{ rand(5, 15) }} min read</span>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">
                        {{ $post['title'] }}
                    </h3>
                    @if($post->slug)
                        <div class="mt-2 text-xs font-mono text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md border border-slate-200 inline-block">
                            slug: {{ $post->slug }}
                        </div>
                    @endif
                    @if($post->user)
                        <div class="mt-2 text-xs text-slate-600 flex items-center gap-1">
                            <span class="font-semibold text-slate-700">Creator:</span> {{ $post->user->name }} ({{ $post->user->email }})
                        </div>
                    @endif
                    <p class="mt-4 text-slate-600 leading-relaxed line-clamp-3">
                        {{ $post['body'] }}
                    </p>
                </div>

                <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between gap-2">
                    <div class="flex gap-2">
                        <a href="/posts/{{ $post['id'] }}" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-white rounded-lg transition-colors border border-transparent hover:border-slate-200">
                            Details
                        </a>
                        <a href="/posts/edit/{{ $post['id'] }}" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-amber-600 hover:bg-white rounded-lg transition-colors border border-transparent hover:border-slate-200">
                            Edit
                        </a>
                    </div>
                    <form action="/posts/{{ $post['id'] }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                           class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                           title="Move to Trash">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </div>
            </article>
            @endforeach
        </div>
        <div class="mt-8 mb-12">
            {{ $posts->links() }}
        </div>
        @endif

        @if($deletedPost->isNotEmpty())
        <section class="mt-4">
            <header class="mb-8 flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <div class="bg-red-100 p-2 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-700">Trash</h2>
                </div>
                <span class="px-3 py-1 bg-red-100 text-red-600 text-xs font-bold rounded-full">
                    {{ $deletedPost->count() }} deleted
                </span>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($deletedPost as $post)
                <article class="group relative bg-white rounded-3xl border border-red-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col opacity-80 hover:opacity-100">
                    <div class="h-2 bg-gradient-to-r from-red-400 to-rose-500"></div>
                    @if($post->image)
                        <img
                            src="{{ asset('storage/' . $post->image) }}"
                            alt="{{ $post->title }}"
                            class="w-full h-48 object-cover rounded-2xl mb-4 opacity-70"
                        >
                    @endif

                    <div class="p-8 flex-grow">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="px-3 py-1 bg-red-50 text-red-500 text-xs font-bold uppercase tracking-wider rounded-full flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Deleted
                            </span>
                            <span class="text-slate-400 text-xs">{{ $post->deleted_at->diffForHumans() }}</span>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-500 line-through decoration-red-300 group-hover:text-slate-700 transition-colors">
                            {{ $post['title'] }}
                        </h3>
                        @if($post->slug)
                            <div class="mt-2 text-xs font-mono text-slate-400 bg-slate-50 px-2.5 py-1 rounded-md border border-slate-100 inline-block">
                                slug: {{ $post->slug }}
                            </div>
                        @endif
                        @if($post->user)
                            <div class="mt-2 text-xs text-slate-500 flex items-center gap-1">
                                <span class="font-semibold text-slate-600">Creator:</span> {{ $post->user->name }} ({{ $post->user->email }})
                            </div>
                        @endif
                        <p class="mt-4 text-slate-400 leading-relaxed line-clamp-3">
                            {{ $post['body'] }}
                        </p>
                    </div>

                    <div class="p-6 bg-red-50/40 border-t border-red-100 flex items-center justify-between gap-2">
                        <form action="/posts/{{ $post['id'] }}/restore" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                               id="restore-post-{{ $post['id'] }}"
                               class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-lg transition-all hover:scale-105 active:scale-95"
                               title="Restore Post">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Restore
                            </button>
                        </form>

                        <form action="/posts/{{ $post['id'] }}/force-delete" method="POST"
                              onsubmit="return confirm('Permanently delete this post? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                               id="force-delete-post-{{ $post['id'] }}"
                               class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg transition-all hover:scale-105 active:scale-95"
                               title="Delete Forever">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Forever
                            </button>
                        </form>
                    </div>
                </article>
                @endforeach
            </div>
        </section>
        @endif

    </main>
</body>
</html>