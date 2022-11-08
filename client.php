<html>
    <head>
        <title>Mercure client</title>
    </head>
    <body>
        <h1>Real time entities</h1>
        <ul id="logs">
            <li>!!!!!!!</li>
        </ul>
        <script>
            // The subscriber subscribes to updates for the https://example.com/users/dunglas topic
            // and to any topic matching https://example.com/books/{id}
            const url = new URL('https://localhost/.well-known/mercure');
            url.searchParams.append('topic', 'https://localhost/demo/books/1.jsonld');
            url.searchParams.append('topic', 'https://example.com/users/dunglas');
            // The URL class is a convenient way to generate URLs such as https://localhost/.well-known/mercure?topic=https://example.com/books/{id}&topic=https://example.com/users/dunglas

            const eventSource = new EventSource(url);

            // The callback will be called every time an update is published
            // eventSource.onmessage = e => console.log(e); // do something with the payload
            eventSource.onmessage = e => {
                console.log("data : ", event.data);
                const data = JSON.parse(event.data)
                console.log("data JSON: ", data);
                const li = document.createElement('li')
                li.innerText = data.title
                logs.append(li)
            }
        </script>
    </body>
</html>