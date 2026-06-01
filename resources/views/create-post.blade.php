<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Create New Post</title>
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen flex flex-col">
    <nav class="glass border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="/posts" class="flex items-center gap-2 group">
                    <div class="bg-indigo-600 p-2 rounded-xl shadow-lg shadow-indigo-200 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">Laravel Lab 1</span>
                </a>
                <a href="/posts" class="text-sm font-medium text-slate-600 hover:text-indigo-600 flex items-center transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Posts
                </a>
            </div>
        </div>
    </nav>
    <main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full">
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <div class="p-8 sm:p-12">
                    <div class="mb-10 text-center">
                        <h1 class="text-3xl font-extrabold text-slate-900">Create a New Post</h1>
                    </div>

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4">
                            <p class="text-sm font-semibold text-red-700 mb-2">Please fix the following errors:</p>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-sm text-red-600">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="/posts" method="POST" class="space-y-6" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <label for="title" class="block text-sm font-semibold text-slate-700 mb-2 ml-1">Title</label>
                            <input type="text" name="title" id="title"
                                value="{{ old('title') }}"
                                placeholder="Title..."
                                class="w-full px-5 py-4 bg-slate-50 border {{ $errors->has('title') ? 'border-red-400 focus:ring-red-100 focus:border-red-500' : 'border-slate-200 focus:ring-indigo-100 focus:border-indigo-500' }} rounded-2xl focus:ring-4 transition-all outline-none text-slate-900 placeholder:text-slate-400">
                            @error('title')
                                <p class="mt-1 ml-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="body" class="block text-sm font-semibold text-slate-700 mb-2 ml-1">Content</label>
                            <textarea name="body" id="body" rows="8"
                                placeholder="Content..."
                                class="w-full px-5 py-4 bg-slate-50 border {{ $errors->has('body') ? 'border-red-400 focus:ring-red-100 focus:border-red-500' : 'border-slate-200 focus:ring-indigo-100 focus:border-indigo-500' }} rounded-2xl focus:ring-4 transition-all outline-none text-slate-900 placeholder:text-slate-400 resize-none">{{ old('body') }}</textarea>
                            @error('body')
                                <p class="mt-1 ml-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="image" class="block text-sm font-semibold text-slate-700 mb-2 ml-1">Image</label>
                            <input type="file" name="image" id="image"
                                class="w-full px-5 py-4 bg-slate-50 border {{ $errors->has('image') ? 'border-red-400 focus:ring-red-100 focus:border-red-500' : 'border-slate-200 focus:ring-indigo-100 focus:border-indigo-500' }} rounded-2xl focus:ring-4 transition-all outline-none text-slate-900 placeholder:text-slate-400">
                            @error('image')
                                <p class="mt-1 ml-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-4 flex flex-col sm:flex-row gap-4">
                            <button type="submit" class="flex-grow bg-indigo-600 text-white font-bold py-4 px-8 rounded-2xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                Create Post
                            </button>
                            <a href="/posts" class="sm:w-32 py-4 px-8 border border-slate-200 text-slate-600 font-semibold rounded-2xl hover:bg-slate-50 hover:text-slate-900 transition-all text-center">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

</body>
</html>