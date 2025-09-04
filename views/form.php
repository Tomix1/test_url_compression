<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>URL Compression</title>
    <style>
        body {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input[type="url"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }

        button {
            padding: 10px 20px;
            background: #0bdc1c;
            color: white;
            border: none;
            cursor: pointer;
        }

        .error {
            color: red;
            margin-top: 5px;
        }
    </style>
</head>
    <body>
        <h1>URL Compression</h1>

        <form method="POST" action="/compress">
            <div class="form-group">
                <label>
                    <input type="url" name="url" placeholder="Enter your long URL" value="<?= htmlspecialchars($url ?? '') ?>" required>
                </label>
            </div>

            <?php if (isset($error)): ?>
                <div class="error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <button type="submit">Compress URL</button>
        </form>
    </body>
</html>