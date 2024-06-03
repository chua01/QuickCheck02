@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Add Item'])

    <div class="container-fluid py-4">
        <form method="POST" action="{{ route('item.store') }}" enctype="multipart/form-data">
            @csrf
            <style>
                .file-upload-container {
                    position: relative;
                    display: inline-block;
                }

                .file-upload-input {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    opacity: 0;
                    cursor: pointer;
                }

                .file-upload-image {
                    width: 100%;
                    height: auto;
                    border: 2px dashed #ccc;
                    padding: 10px;
                    box-sizing: border-box;
                    display: block;
                    border-radius: 10px;
                    aspect-ratio: 1/1;
                    object-fit: cover;
                }

                .file-upload-image:hover {
                    opacity: 0.7;
                }

                #loading-message {
                    display: none;
                    font-weight: bold;
                    color: red;
                }
            </style>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">New Item</p>
                                <button id="submit-button" class="btn btn-primary btn-sm ms-auto" type="submit">Submit</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-md-6">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="file-upload-container">
                                            <input class="form-control file-upload-input" type="file" id="pic" name="pic" onchange="handleImageUpload(event)">
                                            <img id="selected-image" class="file-upload-image" src="{{ asset('img/plus.png') }}" alt="Upload Photo">
                                        </div>
                                    </div>
                                </div>

                                <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
                                <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/mobilenet@2.1.1/dist/mobilenet.min.js"></script>
                                <script>
                                    let model;
                                    let imageElement = null;

                                    document.addEventListener("DOMContentLoaded", async () => {
                                        console.log("Loading model...");
                                        model = await mobilenet.load();
                                        console.log("Model loaded.");
                                        if (imageElement) {
                                            classifyImage(imageElement);
                                        }
                                    });

                                    function handleImageUpload(event) {
                                        var input = event.target;
                                        if (input.files && input.files[0]) {
                                            document.getElementById('loading-message').style.display = 'block';
                                            document.getElementById('submit-button').disabled = true;

                                            var reader = new FileReader();
                                            reader.onload = function (e) {
                                                var imgElement = document.getElementById('selected-image');
                                                imgElement.src = e.target.result;
                                                imageElement = imgElement;
                                                imgElement.onload = function() {
                                                    if (model) {
                                                        classifyImage(imgElement);
                                                    }
                                                };
                                            };
                                            reader.readAsDataURL(input.files[0]);
                                        } else {
                                            document.getElementById('classification-results').value = '';
                                            document.getElementById('submit-button').disabled = false;
                                        }
                                    }

                                    async function classifyImage(imgElement) {
                                        if (model) {
                                            console.log("Classifying image...");
                                            try {
                                                // Clear previous predictions
                                                document.getElementById('predictions-container').innerHTML = '';

                                                // Ensure the image is loaded and has proper dimensions
                                                imgElement.width = imgElement.width || 224;
                                                imgElement.height = imgElement.height || 224;

                                                // Classify the image
                                                const predictions = await model.classify(imgElement);
                                                console.log('Predictions:', predictions);
                                                displayPredictions(predictions);
                                                document.getElementById('classification-results').value = JSON.stringify(predictions);
                                            } catch (error) {
                                                console.error("Error during classification:", error);
                                            }
                                            document.getElementById('loading-message').style.display = 'none';
                                            document.getElementById('submit-button').disabled = false;
                                        } else {
                                            console.error("Model is not loaded yet.");
                                        }
                                    }

                                    function displayPredictions(predictions) {
                                        const predictionsContainer = document.getElementById('predictions-container');
                                        predictionsContainer.innerHTML = '';
                                        predictions.forEach(prediction => {
                                            const p = document.createElement('p');
                                            p.textContent = `${prediction.className}: ${prediction.probability.toFixed(2)}`;
                                            predictionsContainer.appendChild(p);
                                        });
                                    }
                                </script>

                                <div id="predictions-container"></div>
                                <input type="hidden" id="classification-results" name="classification_results">
                                <div id="loading-message">Classifying image, please wait...</div>
                            </div>
                            <p class="text-uppercase text-sm">Item Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Item Name</label>
                                        <input class="form-control" type="text" name="name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Description</label>
                                        <input class="form-control" type="text" name="description">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Quantity</label>
                                        <input class="form-control" type="number" name="quantity">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-select" class="form-control-label">Unit</label>
                                        <select class="form-control" name="unit" id="example-select">
                                            <option value="pcs">pcs</option>
                                            <option value="kg">kg</option>
                                            <option value="meter">meter</option>
                                            <option value="roll">roll</option>
                                            <!-- Add more options as needed -->
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Price 1</label>
                                        <input class="form-control" type="text" name="price1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Price 2</label>
                                        <input class="form-control" type="text" name="price2">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Price 3</label>
                                        <input class="form-control" type="text" name="price3">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Min Quantity</label>
                                        <input class="form-control" type="text" name="minlevel">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
