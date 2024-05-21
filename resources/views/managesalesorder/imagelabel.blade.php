<img src="{{asset('img/shit.png')}}" id='img' alt="">
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/mobilenet@2.1.1/dist/mobilenet.min.js"></script>
<script>
    const img = document.getElementById('img');

    // Load the model.
    mobilenet.load().then(model => {
        // Classify the image.
        model.classify(img).then(predictions => {
            console.log('Predictions: ');
            console.log(predictions);
        });
    });
</script>