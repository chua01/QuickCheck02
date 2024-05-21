<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
</head>
<body>
    <form method="POST" action="{{ route('save.temporary') }}">
        @csrf
        <!-- Form fields go here -->
        <input type="text" name="name" placeholder="Name">
        <input type="email" name="email" placeholder="Email">
        <button type="submit">Save Temporarily</button>
    </form>
</body>
</html>
