<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Online Library</title>
    <link rel="stylesheet" href="{{ asset('styles/main.css') }}">
    @livewireStyles
</head>

<body>
    <div class="page-wrapper">
        <div class="layout-wrapper">
            <!-- Left Container -->
            <aside class="left-container">
                <div class="left-inner flex-column w-full">
                    <div class="box">
                        <h2 class="section-title">Add a Book to your Library</h2>
                        @livewire('book-form')
                    </div>

                    <div class="box">
                        @livewire('export-bar')
                    </div>
                </div>
            </aside>

            <!-- Right Container -->
            <main class="right-container">
                @livewire('library-manager')
            </main>
        </div>
    </div>

    @livewireScripts
</body>

</html>
