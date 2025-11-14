<x-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-semibold mb-6">Import Books from Google Books</h1>

        <!-- Search Form -->
        <form id="search-form" class="mb-6 flex">
            <input type="text" id="search-query" name="q" class="w-full input input-bordered"
                placeholder="Search for a book...">
            <button type="submit" class="bg-[#006D77] text-white px-4 ml-2">Search</button>
        </form>

        <!-- Results Section -->
        <div id="results" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4"></div>
    </div>

    <script>
        document.getElementById('search-form').addEventListener('submit', async function (e) {
            e.preventDefault();
            const query = document.getElementById('search-query').value.trim();
            if (!query) return alert('Please enter a search term.');

            const resultsDiv = document.getElementById('results');
            resultsDiv.innerHTML = '<p>Searching...</p>';

            const response = await fetch(`/books/import/result?q=${encodeURIComponent(query)}`);
            const books = await response.json();

            resultsDiv.innerHTML = '';

            if (!books.length) {
                resultsDiv.innerHTML = '<p>No results found.</p>';
                return;
            }

            books.forEach(book => {
                const info = book.volumeInfo || {};
                const title = info.title || 'Untitled';
                const authors = (info.authors || []).join(', ');

                let thumbnail = '';
                if (info.imageLinks) {
                    const imageLinks = info.imageLinks;
                    const sizes = ['extraLarge', 'large', 'medium', 'small', 'thumbnail', 'smallThumbnail'];

                    for (const size of sizes) {
                        if (imageLinks[size]) {
                            thumbnail = imageLinks[size];
                            break;
                        }
                    }
                }

                const card = document.createElement('div');
                card.classList.add('border', 'rounded', 'p-4', 'shadow');

                card.innerHTML = `
                <img src="${thumbnail}" alt="${title}" class="w-full mb-2" />
                <h2 class="font-bold">${title}</h2>
                <p class="text-sm text-gray-600">${authors}</p>

                <label class="text-sm mt-2 block">Quantity:</label>
    <input type="number" value="1" min="1" class="quantity-input border rounded px-2 py-1 w-20">

                <button class="bg-[#006D77] text-white px-3 py-1 mt-3 import-btn" data-id="${book.id}">
                    Import
                </button>
            `;

                resultsDiv.appendChild(card);
            });

            document.querySelectorAll('.import-btn').forEach(btn => {
                btn.addEventListener('click', async function () {
                    const volumeId = this.getAttribute('data-id');
                    const quantityInput = this.parentElement.querySelector('.quantity-input');
                    const quantity = parseInt(quantityInput.value) || 1;

                    this.disabled = true;
                    this.innerText = 'Importing...';

                    const importResponse = await fetch(`/books/import/confirm`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            volume_id: volumeId,
                            quantity: quantity
                        }),
                    });

                    const result = await importResponse.json();

                    if (importResponse.ok) {
                        this.innerText = 'Imported!';
                        this.classList.remove('bg-green-600');
                        this.classList.add('bg-gray-500');
                    } else {
                        this.innerText = 'Error';
                        alert(result.message || 'Import failed');
                    }

                    this.disabled = false;
                });
            });
        });
    </script>
</x-layout>