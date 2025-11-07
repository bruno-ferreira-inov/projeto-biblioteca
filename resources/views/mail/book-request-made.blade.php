<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Book Request Confirmation</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            padding: 20px;
            margin: 0;
        }

        .container {
            background: #fff;
            border-radius: 6px;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #222;
        }

        .book-info {
            border-top: 1px solid #ddd;
            margin-top: 15px;
            padding-top: 15px;
        }

        .book-info p {
            margin: 6px 0;
        }

        .footer {
            font-size: 0.9em;
            color: #666;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Book Request Received</h2>

        <p>Hello {{ $user->name }},</p>

        <p>We've received your request for the following book:</p>

        <div class="book-info">
            <p><strong>Title:</strong> {{ $book->title }}</p>
            <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
            <p><strong>Publisher:</strong> {{ optional($book->publisher)->name ?? 'Unknown' }}</p>
            <p><strong>Bibliography:</strong> {{ $book->bibliography }}</p>

            @php
                $coverPath = storage_path('app/public/' . $book->cover);
            @endphp

            @if (file_exists($coverPath))
                <img src="{{ $message->embed($coverPath) }}" class="flex justify-center" alt="{{ $book->title }}"
                    style="width: 200px; border-radius: 8px;">
            @else
                <p>[Cover not available]</p>
            @endif
        </div>

        <p>We'll notify you once the book is ready for pickup or if more information is needed.</p>

        <div class="footer">
            <p>Thank you for your request.</p>
            <p>Please do not reply directly to this message.</p>
        </div>
    </div>
</body>

</html>