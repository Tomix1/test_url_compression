<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>URL Compressed</title>
    <style>
        body {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
        }

        .result {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
        }

        .short-url {
            font-size: 18px;
            color: #007bff;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <h1>URL Compressed Successfully</h1>

    <div class="result">
        <p>
            <strong>Original URL:</strong><br>
            <a href="<?= htmlspecialchars($original_url) ?>"><?= htmlspecialchars($original_url) ?></a>
        </p>

        <p>
            <strong>Short URL:</strong><br>
            <a href="<?= htmlspecialchars($short_url) ?>" class="short-url"><?= htmlspecialchars($short_url) ?></a>
        </p>

        <?php if ($already_exists): ?>
            <p><em>This URL already compressed</em></p>
        <?php endif; ?>
    </div>

    <p><a href="/">Compress another URL</a></p>
</body>
</html>