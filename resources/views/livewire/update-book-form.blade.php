<div class="flex items-center pl-10">
    <form action="/books/{{$book->id}}" method="POST" enctype="multipart/form-data" class="text-black">
        @csrf
        @method('PATCH')
        <fieldset class="fieldset">
            <legend class="fieldset-legend ">Title</legend>
            <input type="text" class="input" name="title" id="title" wire:model="title" placeholder="Title"
                value="{{ $book->title }}" />
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
            @error('cover')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="fieldset">
            <legend class="fieldset-legend ">Bibliography</legend>
            <input type="text" class="input" name="bibliography" id="bibliography" wire:model="bibliography"
                placeholder="Summary" />
            @error('bibliography')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
            @enderror
        </fieldset>

        <div wire:ignore>
            <fieldset class="fieldset">
                <legend class="fieldset-legend ">Authors</legend>
                <select wire:model="authors" name="authors[]" id="authors" multiple class="select-neutral multi-author">

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
                @error('author')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </fieldset>
        </div>

        <fieldset class="fieldset">
            <legend class="fieldset-legend ">Publishers</legend>
            <select wire:model.live="publisher_id" name="publisher_id" id="publisher_id"
                class="select publisher-select">
                <option disabled>Publishers...</option>
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
        <button type="submit" class="btn btn-success"> Submit </button>
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