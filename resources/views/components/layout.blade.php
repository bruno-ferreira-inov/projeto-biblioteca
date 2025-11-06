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
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </div>
                <ul tabindex="-1"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow ">
                    <li><a class="text-[#006D77]">Item 1</a></li>

                </ul>
            </div>
            <a href='/' class="btn btn-ghost text-xl">biblioteca</a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li>
                    @can('admin-access')
                        <details class="relative group">
                            <summary
                                class="cursor-pointer text-white px-4 py-2 rounded-md hover:bg-[#005f67] focus:outline-none">
                                Books
                            </summary>
                            <ul
                                class="absolute left-0 mt-1 w-40 bg-white border border-gray-200 rounded-md shadow-lg text-[#006D77] opacity-0 group-open:opacity-100 group-open:translate-y-1 transition ease-in-out duration-150 z-50">
                                <li>
                                    <a href="/books/create"
                                        class="block px-4 py-2 hover:bg-gray-100 rounded-t-md">Create</a>
                                </li>
                                <li>
                                    <a href="/books" class="block px-4 py-2 hover:bg-gray-100">List</a>
                                </li>
                                <li>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Requests</a>
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
                        <details class="relative group">
                            <summary
                                class="cursor-pointer text-white px-4 py-2 rounded-md hover:bg-[#005f67] focus:outline-none">
                                Authors
                            </summary>
                            <ul
                                class="absolute left-0 mt-1 w-40 bg-white border border-gray-200 rounded-md shadow-lg text-[#006D77] opacity-0 group-open:opacity-100 group-open:translate-y-1 transition ease-in-out duration-150 z-50">
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
                        <details class="relative group">
                            <summary
                                class="cursor-pointer text-white px-4 py-2 rounded-md hover:bg-[#005f67] focus:outline-none">
                                Publishers
                            </summary>
                            <ul
                                class="absolute left-0 mt-1 w-40 bg-white border border-gray-200 rounded-md shadow-lg text-[#006D77] opacity-0 group-open:opacity-100 group-open:translate-y-1 transition ease-in-out duration-150 z-50">
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
                                <li><a class="text-[#006D77]" href="{{ route('profile.show') }}">Profile</a></li>
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