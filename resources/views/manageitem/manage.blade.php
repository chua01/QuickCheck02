@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Item Management'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6>Items</h6>
                            </div>
                            <div class="col-auto">
                                <a class="btn btn-success" type="button" href="{{ route('item.create') }}">New</a>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <input type="text" id="searchInput" class="form-control" placeholder="Search items...">
                            </div>
                            <div class="col-md-4">
                                <input type="file" id="imageInput" class="form-control" accept="image/*" onchange="handleImageSearch(event)">
                            </div>
                            <div class="col-md-2">
                                <button id="cancelImageSearchButton" class="btn btn-secondary" onclick="cancelImageSearch()">Cancel Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row" id="itemContainer">
                            @foreach ($items as $item)
                                <div class="col-md-3 mb-4 item-card" data-name="{{ strtolower($item->name) }}">
                                    <div class="card h-100 border border-1 position-relative">
                                        <a href="{{ route('item.show', ['id' => $item->id]) }}">
                                            <div class="card-header mx-4 p-3 text-center">
                                                <img src="{{ Storage::url($item->pic) }}" alt="Icon" class="img-fluid rounded border" style="width: 8rem; height: 8rem; object-fit: cover;">
                                            </div>
                                            <div class="card-body pt-0 p-3 text-center">
                                                <span class="text-center mb-0">
                                                    {{ $item->name }}
                                                    <h6></h6>
                                                </span>
                                                <span class="text-xs">ID: {{ $item->id }}</span><br>
                                                <span class="text-xs">RM {{ $item->price1 }}</span>
                                                <hr class="horizontal dark my-3">
                                                <h5 class="mb-0">{{ $item->quantity }} {{ $item->unit }}</h5>
                                            </div>
                                        </a>
                                        <a class="position-absolute top-0 end-0 mt-2 me-2" href="#">
                                            <i class="fas fa-thumbtack" style="{{ (1 == 1 ? '' : 'color: red;') }}"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/mobilenet@2.1.1/dist/mobilenet.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            const searchInput = document.getElementById('searchInput');
            const itemContainer = document.getElementById('itemContainer');
            const itemCards = itemContainer.getElementsByClassName('item-card');
            const imageInput = document.getElementById('imageInput');
            const cancelImageSearchButton = document.getElementById('cancelImageSearchButton');

            // Store initial items
            const initialItems = Array.from(itemCards).map(card => card.outerHTML);

            // Load MobileNet model
            let model;
            try {
                model = await mobilenet.load();
                console.log("Model loaded.");
            } catch (error) {
                console.error("Failed to load the model:", error);
                return;
            }

            // Text search
            searchInput.addEventListener('keyup', function() {
                const filter = searchInput.value.toLowerCase();
                Array.from(itemCards).forEach(function(card) {
                    const itemName = card.getAttribute('data-name');
                    if (itemName.indexOf(filter) > -1) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });

            // Image classification search
            window.handleImageSearch = async function(event) {
                const file = event.target.files[0];
                if (file && model) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.onload = async function() {
                            try {
                                const predictions = await model.classify(imgElement);
                                console.log("Predictions:", predictions);
                                if (predictions.length > 0) {
                                    const topPrediction = predictions[0].className.toLowerCase();
                                    console.log("Top prediction:", topPrediction);
                                    fetchItemsByTag(topPrediction);
                                }
                            } catch (classificationError) {
                                console.error("Classification error:", classificationError);
                            }
                        };
                    };
                    reader.readAsDataURL(file);
                } else {
                    console.log("No file selected or model not loaded.");
                }
            };

            async function fetchItemsByTag(tag) {
                console.log("Fetching items with tag:", tag);
                try {
                    const response = await fetch(`/items/search?tag=${tag}`);
                    const items = await response.json();
                    console.log("Fetched items:", items);
                    displayItems(items);
                } catch (error) {
                    console.error("Failed to fetch items by tag:", error);
                }
            }

            function displayItems(items) {
                itemContainer.innerHTML = '';
                items.forEach(item => {
                    console.log("Displaying item:", item);
                    const card = document.createElement('div');
                    card.classList.add('col-md-3', 'mb-4', 'item-card');
                    card.setAttribute('data-name', item.name.toLowerCase());
                    card.innerHTML = `
                        <div class="card h-100 border border-1 position-relative">
                            <a href="/item/show/${item.id}">
                                <div class="card-header mx-4 p-3 text-center">
                                    <img src="/storage/${item.pic}" alt="Icon" class="img-fluid rounded border" style="width: 8rem; height: 8rem; object-fit: cover;">
                                </div>
                                <div class="card-body pt-0 p-3 text-center">
                                    <span class="text-center mb-0">
                                        ${item.name}
                                        <h6></h6>
                                    </span>
                                    <span class="text-xs">ID: ${item.id}</span><br>
                                    <span class="text-xs">RM ${item.price1}</span>
                                    <hr class="horizontal dark my-3">
                                    <h5 class="mb-0">${item.quantity} ${item.unit}</h5>
                                </div>
                            </a>
                            <a class="position-absolute top-0 end-0 mt-2 me-2" href="#">
                                <i class="fas fa-thumbtack"></i>
                            </a>
                        </div>
                    `;
                    itemContainer.appendChild(card);
                });
            }

            window.cancelImageSearch = function() {
                // Reset the image input
                imageInput.value = '';

                // Clear the search input
                searchInput.value = '';

                // Reset the item display
                itemContainer.innerHTML = initialItems.join('');
            };
        });
    </script>
@endsection
