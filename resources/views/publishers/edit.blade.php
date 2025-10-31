<x-layout>
    <div class="max-w-3xl ml-12 py-12 px-12 text-[#006D77] flex items-start gap-12">
        <section>
            <h2 class="text-2xl font-semibold mb-4  flex items-center gap-2">
                <span class="h-6 w-1 bg-emerald-500 rounded-full"></span>
                Update Publisher Details
            </h2>
            <p class=" mb-6">
                Edit the details below to update <strong>{{$publisher->name}}</strong>.
            </p>

            <form action="/publishers/{{ $publisher->id }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PATCH')
                <div>
                    <label for="nameB" class="block text-sm font-medium mb-2 ">Name</label>
                    <input type="text" name="name" id="name" required value="{{ $publisher->name }}"
                        class="w-full px-4 py-2 rounded-lg border-gray-300 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400">
                </div>

                <div>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend ">Publisher Logo</legend>
                        <input class="file-input" type="file" name="logo" id="logo" accept="image/*" required />
                    </fieldset>
                </div>

                <button type="submit"
                    class="w-full py-2 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition">
                    Update Publisher Information
                </button>
            </form>
        </section>
        <div class="w-64 flex-shrink-0">
            <img src="{{ asset('storage/' . $publisher->logo) }}" alt="Publisher Logo"
                class="w-full h-auto rounded-lg shadow-lg object-cover">
        </div>
    </div>
</x-layout>
