<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BooksExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function headings(): array
    {
        return [
            '#',
            'publisher_id',
            'title',
            'isbn',
            'bibiography',
            'cover',
            'price',
            'created_at',
            'updated_at',
        ];
    }

    public function collection()
    {
        return Book::all();
    }
}
