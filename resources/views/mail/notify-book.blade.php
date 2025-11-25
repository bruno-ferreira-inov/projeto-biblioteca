<head>
    <meta charset="UTF-8">
    <title>Book Notification</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f6f6;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            background: #ffffff;
            margin: 30px auto;
            padding: 25px;
            border-radius: 8px;
            border: 1px solid #e5e5e5;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            color: #006d77;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            background: #006d77;
            padding: 10px 20px;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: bold;
        }

        .footer {
            font-size: 12px;
            color: #777;
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="title">You're Subscribed!</div>

        <p>Hi {{ $user->name }},</p>

        <p>
            You've asked to be notified when the book:
            <strong>{{ $book->title }}</strong>
            becomes available again.
        </p>

        <p>We'll let you know the moment it's back in stock.</p>

        <a href="{{ route('books.show', $book) }}" class="button">
            View Book
        </a>

        <div class="footer">
            Thank you for using our library system.
        </div>
    </div>
</body>
