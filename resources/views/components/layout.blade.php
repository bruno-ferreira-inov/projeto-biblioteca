<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"
        integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    @livewireStyles
</head>

<body class="min-h-screen bg-[#EDF6F9]">

    <div class="navbar bg-[#006D77] text-[#EDF6F9] shadow-sm">
        <div class="navbar-start">
            <a href='/' class="btn btn-ghost text-xl">biblioteca</a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                @can('admin-access')
                    <li>
                        <details class="">
                            <summary
                                class="cursor-pointer text-white px-4 py-2 rounded-md hover:bg-[#005f67] focus:outline-none">
                                Admin
                            </summary>
                            <ul
                                class="absolute left-0 mt-1 w-40 bg-white border border-gray-200 rounded-md shadow-lg text-[#006D77] z-50">
                                <li>
                                    <a href="/admin/create" class="block px-4 py-2 hover:bg-gray-100 rounded-t-md">Register
                                        Admin Account</a>
                                </li>
                                <li>
                                    <a href="/books/import/search"
                                        class="block px-4 py-2 hover:bg-gray-100 rounded-t-md">Import
                                        Books to Catalog</a>
                                </li>
                                <li>
                                    <a href="/admin/reviews" class="block px-4 py-2 hover:bg-gray-100 rounded-t-md">Review
                                        Moderation</a>
                                </li>
                            </ul>
                        </details>
                    </li>
                    <li>
                        <a href="/admin/requests"
                            class="cursor-pointer text-white px-4 py-2 rounded-md hover:bg-[#005f67] focus:outline-none">
                            Requests
                        </a>
                    </li>
                @endcan
                <li>
                    @can('admin-access')
                        <details>
                            <summary
                                class="relative cursor-pointer text-white px-4 py-2 rounded-md hover:bg-[#005f67] focus:outline-none">
                                Books
                            </summary>
                            <ul
                                class="absolute left-0 mt-1 w-40 bg-white border border-gray-200 rounded-md shadow-lg text-[#006D77] z-50">
                                <li>
                                    <a href="/books/create"
                                        class="block px-4 py-2 hover:bg-gray-100 rounded-t-md">Create</a>
                                </li>
                                <li>
                                    <a href="/books" class="block px-4 py-2 hover:bg-gray-100">List</a>
                                </li>
                                <li>
                                    <a href="/books/export" class="block px-4 py-2 hover:bg-gray-100 rounded-b-md">Export
                                        Books</a>
                                </li>
                            </ul>
                        </details>
                    @else
                        <a href="/books"
                            class="cursor-pointer text-white px-4 py-2 rounded-md hover:bg-[#005f67] focus:outline-none">
                            Books
                        </a>
                    @endcan
                </li>
                <li>
                    @can('admin-access')
                        <details>
                            <summary
                                class="cursor-pointer text-white px-4 py-2 rounded-md hover:bg-[#005f67] focus:outline-none">
                                Authors
                            </summary>
                            <ul
                                class="absolute left-0 mt-1 w-40 bg-white border border-gray-200 rounded-md shadow-lg text-[#006D77] z-50">
                                <li>
                                    <a href="/authors/create"
                                        class="block px-4 py-2 hover:bg-gray-100 rounded-t-md">Create</a>
                                </li>
                                <li>
                                    <a href="/authors" class="block px-4 py-2 hover:bg-gray-100">List</a>
                                </li>
                            </ul>
                        </details>
                    @else
                        <a href="/authors"
                            class="cursor-pointer text-white px-4 py-2 rounded-md hover:bg-[#005f67] focus:outline-none">
                            Authors
                        </a>
                    @endcan
                </li>
                <li>
                    @can('admin-access')
                        <details>
                            <summary
                                class="cursor-pointer text-white px-4 py-2 rounded-md hover:bg-[#005f67] focus:outline-none">
                                Publishers
                            </summary>
                            <ul
                                class="absolute left-0 mt-1 w-40 bg-white border border-gray-200 rounded-md shadow-lg text-[#006D77] z-50">
                                <li>
                                    <a href="/publishers/create"
                                        class="block px-4 py-2 hover:bg-gray-100 rounded-t-md">Create</a>
                                </li>
                                <li>
                                    <a href="/publishers" class="block px-4 py-2 hover:bg-gray-100">List</a>
                                </li>
                            </ul>
                        </details>
                    @else
                        <a href="/publishers"
                            class="cursor-pointer text-white px-4 py-2 rounded-md hover:bg-[#005f67] focus:outline-none">
                            Publishers
                        </a>
                    @endcan
                </li>
            </ul>
        </div>
        <div class="navbar-end">
            <ul class="menu menu-horizontal px-1">
                @auth
                    <li>
                        <details>
                            <summary>{{Auth::user()->name}}</summary>
                            <ul class="bg-base-100 rounded-t-none p-2">
                                <li><a class="text-[#006D77]" href="{{ route('profile.show') }}">Profile</a>
                                </li>
                                <li>
                                    <a class="text-[#006D77]" href="/books/requests">Requests</a>
                                </li>
                                <form method='post' action="/logout">
                                    @csrf
                                    <li><button class="text-[#006D77]" type="submit">Logout</button></li>
                                </form>
                            </ul>
                        </details>
                    </li>
                @endauth
                @guest
                    <li><a href="/register">Register</a></li>
                    <li><a href="/login">Log In</a></li>
                @endguest

            </ul>
        </div>
    </div>


    <main class="">
        {{  $slot }}
    </main>
    @livewireScripts
</body>

</html>