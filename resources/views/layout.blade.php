<!doctype html>
<html>
<head>
    <title>Embed Preview</title>

    <link rel="stylesheet" type="text/css" href="/vendor/statamic-embed/dist/css/preview.css"/>
</head>
<body class="box-border overflow-hidden">

<div id="preview" class="p-3">
    @yield('body')
</div>
{{--<pre class="text-xs">{{ json_encode($embed, JSON_PRETTY_PRINT) }}</pre>--}}
<script>
    var handleResize = function() {
        window.parent.postMessage({ sender: 'resizer', message: document.body.scrollHeight })
    };

    const observer = new ResizeObserver(handleResize);
    observer.observe(document.getElementById('preview'));
    handleResize();
</script>
</body>
</html>