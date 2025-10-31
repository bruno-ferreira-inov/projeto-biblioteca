<div class="flex items-center pl-10">
    <form wire:submit="save" class="text-black">
        @csrf
        <fieldset class="fieldset">
            <legend class="fieldset-legend text-white">Title</legend>
            <input type="text" class="input" name="title" id="title" wire:model="title" placeholder="Title"
                value="{{ $book->title }}" />
        </fieldset>

        <fieldset class="fieldset">
            <legend class="fieldset-legend text-white">ISBN</legend>
            <input type="text" class="input" name="isbn" id="isbn" wire:model="isbn" placeholder="ISBN" />
        </fieldset>

        <fieldset class="fieldset">
            <legend class="fieldset-legend text-white">Price</legend>
            <input type="text" class="input" name="price" id="price" wire:model="price" placeholder="Price" />
        </fieldset>

        <fieldset class="fieldset">
            <legend class="fieldset-legend text-white">Select the Book Cover</legend>
            <input type="file" class="file-input" wire:model="cover" name="cover" id="cover" />
            <label class="label text-white">Max size 2MB</label>
        </fieldset>

        <fieldset class="fieldset">
            <legend class="fieldset-legend text-white">Bibliography</legend>
            <input type="text" class="input" name="bibliography" id="bibliography" wire:model="bibliography"
                placeholder="Bibliography" />
        </fieldset>

        <div wire:ignore>
            <fieldset class="fieldset">
                <legend class="fieldset-legend text-white">Authors</legend>
                <select wire:model="authors" multiple class="select-neutral multi-author">
                    @foreach ($this->bookAuthors as $ba)
                        <option selected value="{{ $ba->id }}"> {{ $ba->name }}</option>
                    @endforeach

                    @foreach ($this->allAuthors as $a)
                        {{ $checked = false }}
                        @foreach($this->bookAuthors as $ba)
                            @if ($a->id == $ba->id)
                                {{ $checked = true }}
                            @endif
                        @endforeach
                        @if($checked == false)
                            <option value="{{ $a->id }}">
                                {{ $a->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </fieldset>
        </div>

        <fieldset class="fieldset">
            <legend class="fieldset-legend text-white">Publishers</legend>
            <select wire:model.live="publisher_id" class="select publisher-select">
                <option selected>Publishers...</option>
                @foreach ($this->allPublishers as $p)
                    <option value="{{ $p->id }}">
                        {{ $p->name }}
                    </option>
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
