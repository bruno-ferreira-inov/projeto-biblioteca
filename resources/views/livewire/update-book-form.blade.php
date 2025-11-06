<div class="flex justify-center items-start min-h-screen bg-base-200 py-10">
    <form action="/books/{{$book->id}}" method="POST" enctype="multipart/form-data"
        class="card w-full max-w-2xl bg-base-100 shadow-xl p-8 space-y-6 text-base-content">
        @csrf
        @method('PATCH')
        <h2 class="text-2xl font-semibold text-center mb-6">Edit Book</h2>

        <!-- Title -->
        <fieldset class="fieldset space-y-2">
            <legend class="fieldset-legend text-lg font-medium text-[#005f67]">Title</legend>
            <input type="text" class="input input-bordered w-full" name="title" id="title" wire:model="title"
                placeholder="Title" />
            @error('title')
                <p class="text-error text-sm mt-1">{{ $message }}</p>
            @enderror
        </fieldset>

        <!-- ISBN -->
        <fieldset class="fieldset space-y-2">
            <legend class="fieldset-legend text-lg font-medium text-[#005f67]">ISBN</legend>
            <input type="text" class="input input-bordered w-full" name="isbn" id="isbn" wire:model="isbn"
                placeholder="ISBN" />
            @error('isbn')
                <p class="text-error text-sm mt-1">{{ $message }}</p>
            @enderror
        </fieldset>

        <!-- Price -->
        <fieldset class="fieldset space-y-2">
            <legend class="fieldset-legend text-lg font-medium text-[#005f67]">Price</legend>
            <input type="text" class="input input-bordered w-full" name="price" id="price" wire:model="price"
                placeholder="Price" />
            @error('price')
                <p class="text-error text-sm mt-1">{{ $message }}</p>
            @enderror
        </fieldset>

        <!-- Cover -->
        <fieldset class="fieldset space-y-2">
            <legend class="fieldset-legend text-lg font-medium text-[#005f67]">Select the Book Cover</legend>
            <input type="file" class="file-input file-input-bordered w-full" wire:model="cover" name="cover"
                id="cover" />
            <label class="label text-sm text-neutral">Max size 2MB</label>
            @error('cover')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
            @enderror
        </fieldset>

        <!-- Bibliography -->
        <fieldset class="fieldset space-y-2">
            <legend class="fieldset-legend text-lg font-medium text-[#005f67]">Bibliography</legend>
            <input type="text" class="input input-bordered w-full" name="bibliography" id="bibliography"
                wire:model="bibliography" placeholder="Bibliography" />
            @error('bibliography')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
            @enderror
        </fieldset>

        <!-- Authors -->
        <div wire:ignore>
            <fieldset class="fieldset space-y-2">
                <legend class="fieldset-legend text-lg font-medium text-[#005f67]">Authors</legend>
                <select wire:model="authors" multiple class="select select-bordered multi-author w-full h-32">
                    <option disabled>Authors...</option>
                    @foreach ($this->allAuthors as $a)
                        <option value="{{ $a->id }}">{{ $a->name }}</option>
                    @endforeach
                </select>
            </fieldset>
        </div>

        <!-- Publisher -->
        <fieldset class="fieldset space-y-2">
            <legend class="fieldset-legend text-lg font-medium text-[#005f67]">Publishers</legend>
            <select wire:model.live="publisher_id" name="publisher_id" id="publisher_id"
                class="select select-bordered w-full publisher-select">
                <option>Publishers...</option>
                @foreach ($this->allPublishers as $p)
                    <option value="{{ $p->id }}">
                        {{ $p->name }}
                    </option>
                @endforeach
            </select>
            @error('publisher_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
            @enderror
        </fieldset>

        <!-- Quantity -->
        <fieldset class="fieldset space-y-2">
            <legend class="fieldset-legend text-lg font-medium text-[#005f67]">Available Copies</legend>
            <input wire:model="quantity" type="number" name="quantity" id="quantity" class="input input-bordered w-full"
                placeholder="Quantity" />
        </fieldset>

        <!-- Submit -->
        <div class="flex justify-end pt-4">
            <button type="submit" class="btn btn-success px-6">Submit</button>
        </div>
    </form>
</div>

@script()
<script>
    $(document).ready(function () {
        let $select = $('.multi-author').select2();

        let initialAuthors = @json($authors);
        if (initialAuthors.length > 0) {
            $select.val(initialAuthors).trigger('change');
        }

        $('.multi-author').on('change', function () {
            let data = $(this).val();
            $wire.set('authors', data);
        });
        $('.publisher-select').on('change', function () {
            $wire.set('publisher_id', $(this).val());
        });
    });


</script>
@endscript