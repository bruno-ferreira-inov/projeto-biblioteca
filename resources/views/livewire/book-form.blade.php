<div class="flex items-center pl-10">
    <form wire:submit="save" class="text-black">
        @csrf
        <fieldset class="fieldset">
            <legend class="fieldset-legend ">Title</legend>
            <input type="text" class="input" name="title" id="title" wire:model="title" placeholder="Title" />
            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="fieldset">
            <legend class="fieldset-legend ">ISBN</legend>
            <input type="text" class="input" name="isbn" id="isbn" wire:model="isbn" placeholder="ISBN" />
            @error('isbn')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="fieldset">
            <legend class="fieldset-legend ">Price</legend>
            <input type="text" class="input" name="price" id="price" wire:model="price" placeholder="Price" />
            @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="fieldset">
            <legend class="fieldset-legend ">Select the Book Cover</legend>
            <input type="file" class="file-input" wire:model="cover" name="cover" id="cover" />
            <label class="label ">Max size 2MB</label>
        </fieldset>

        <fieldset class="fieldset">
            <legend class="fieldset-legend ">Bibliography</legend>
            <input type="text" class="input" name="bibliography" id="bibliography" wire:model="bibliography"
                placeholder="Bibliography" />
        </fieldset>

        <div wire:ignore>
            <fieldset class="fieldset">
                <legend class="fieldset-legend ">Authors</legend>
                <select wire:model="authors" multiple class="select-neutral multi-author">
                    <option disabled selected>Authors...</option>
                    @foreach ($this->allAuthors as $a)
                        <option value="{{ $a->id }}">{{ $a->name }}</option>
                    @endforeach
                </select>
            </fieldset>
        </div>

        <fieldset class="fieldset">
            <legend class="fieldset-legend ">Publishers</legend>
            <select wire:model.live="publisher_id" class="select publisher-select">
                <option disabled>Publishers...</option>
                @foreach ($this->allPublishers as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </fieldset>
        <button type="submit" class="btn btn-success"> Submit </button>
    </form>
</div>

@script()
<script>
    $(document).ready(function () {
        $('.multi-author').select2();

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