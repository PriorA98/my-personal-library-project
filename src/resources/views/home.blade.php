<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My online library</title>
    @livewireStyles
</head>

<body>
    <h1>My library</h1>

    @livewire('book-form')
    <br>
    @livewire('export-bar')
    <br>
    @livewire('library-manager')

    @livewireScripts
</body>

</html>
