<x-layout>
    <div class=" max-w-3xl ml-12 py-12 px-12 text-white">
        <!-- Model A Section -->
        <section class="mb-16">
            <h2 class="text-2xl font-semibold mb-4  flex items-center gap-2">
                <span class="h-6 w-1  rounded-full"></span>
                Create Author
            </h2>
            <p class=" mb-6">
                Fill out the details below to create a new <strong>Author</strong>.
            </p>

            <form action="/authors" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('POST')
                <div>
                    <label for="nameA" class="block text-sm font-medium mb-2 ">Name</label>
                    <input type="text" name="name" id="name" required
                        class="w-full px-4 py-2 rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                </div>

                <div>
                    <label for="pictureA" class="block text-sm font-medium mb-2 ">Picture</label>
                    <input type="file" name="photo" id="photo" accept="image/*" required
                        class=" text-sm  border border-gray-300 cursor-pointer text-black bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>

                <button type="submit"
                    class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition">
                    Create Author
                </button>
            </form>
        </section>

        <!-- Divider -->
        <div class="flex items-center mb-16">
            <div class="flex-grow border-t border-gray-300"></div>
        </div>

        <!-- Model B Section -->
        <section>
            <h2 class="text-2xl font-semibold mb-4  flex items-center gap-2">
                <span class="h-6 w-1 bg-emerald-500 rounded-full"></span>
                Create Publisher
            </h2>
            <p class="text-white mb-6">
                Fill out the details below to create a new <strong>Publisher</strong>.
            </p>

            <form action="/publishers" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('POST')
                <div>
                    <label for="nameB" class="block text-sm font-medium mb-2 ">Name</label>
                    <input type="text" name="name" id="name" required
                        class="w-full px-4 py-2 rounded-lg border-gray-300 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400">
                </div>

                <div>
                    <label for="pictureB" class="block text-sm font-medium mb-2 text-gray-700">Picture</label>
                    <input type="file" name="logo" id="logo" accept="image/*" required
                        class="w-fit text-sm  border border-gray-300 cursor-pointer text-black bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                </div>

                <button type="submit"
                    class="w-full py-2 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition">
                    Create Publisher
                </button>
            </form>
        </section>
    </div>
</x-layout>
