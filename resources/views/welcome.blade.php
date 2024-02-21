<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/js/app.js')
        <title>Laravel</title>

       
    </head>
    <body id="app">
        <example-component> </example-component>
        <div id="app">
            <task-list></task-list>
            <task-create></task-create>
            <task-update></task-update>
        </div>

        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
