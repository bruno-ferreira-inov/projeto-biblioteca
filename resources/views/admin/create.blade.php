<x-layout>
    <div class="flex justify-center items-start min-h-screen bg-base-200 py-10">
        <form action="/admin" method="POST" enctype="multipart/form-data"
            class="card w-full max-w-2xl bg-base-100 shadow-xl p-8 space-y-6 text-base-content">
            @csrf
            <h2 class="text-2xl font-semibold text-center mb-6">Register New Administrator</h2>

            <!-- Name -->
            <fieldset class="fieldset space-y-2">
                <legend class="fieldset-legend text-lg font-medium text-[#005f67]">Name</legend>
                <input type="text" class="input input-bordered w-full" name="name" id="name" placeholder="Name" />
                @error('name')
                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                @enderror
            </fieldset>

            <!-- ISBN -->
            <fieldset class="fieldset space-y-2">
                <legend class="fieldset-legend text-lg font-medium text-[#005f67]">E-mail</legend>
                <input type="text" class="input input-bordered w-full" name="email" id="email"
                    placeholder="Insert E-mail" />
                @error('email')
                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                @enderror
            </fieldset>

            <!-- Cover -->
            <fieldset class="fieldset space-y-2">
                <legend class="fieldset-legend text-lg font-medium text-[#005f67]">Insert a Picture</legend>
                <input type="file" class="file-input file-input-bordered w-full" name="picture" id="picture" />
                <label class="label text-sm text-neutral">Max size 2MB</label>
            </fieldset>

            <!-- Submit -->
            <div class="flex justify-end pt-4">
                <button type="submit" class="btn btn-success px-6">Submit</button>
            </div>
        </form>
    </div>
</x-layout>