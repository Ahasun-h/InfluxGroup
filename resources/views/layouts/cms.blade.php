<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CMS Admin')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body class="bg-gray-50 dark:bg-surface-900">
    <div class="min-h-screen flex">
        <!-- CMS Sidebar -->
        <aside class="w-64 bg-white dark:bg-surface-800 border-r border-gray-200 dark:border-surface-700 flex flex-col h-screen sticky top-0">
            <!-- CMS Header -->
            <div class="p-4 border-b border-gray-200 dark:border-surface-700">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-brand-500 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-bold text-gray-900 dark:text-white">CMS Admin</h1>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Home Page Sections</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto p-4">
                @yield('cms-navigation')
            </nav>

            <!-- Footer -->
            <div class="p-4 border-t border-gray-200 dark:border-surface-700">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            @yield('cms-content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>