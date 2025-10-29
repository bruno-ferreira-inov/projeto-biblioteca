@props(['book'])

<div
    class="p-4 bg-white/5 rounded-xl border border-transparent hover:border-blue-600 group transition-colors duration-300">

    <div class="self-start text-sm">{{$book->title}}</div>
    <div class="py-8">
        <h3 class="group-hover:text-blue-600 text-xl font-bold transition-colors duration-300">
            <a href="{{ $book->title }}" target="_blank">
                {{$book->title}}
            </a>
        </h3>
        <p class="text-sm mt-4">{{$book->isbn}}
        </p>
    </div>

    <div class="flex justify-between items-center mt-auto">
        <div>

        </div>

    </div>
</div>
