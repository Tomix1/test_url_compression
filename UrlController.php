<?php

class UrlController
{
    public function __construct(
        private readonly UrlService $urlService,
        private readonly Response   $response
    ) {
    }

    public function showForm(): void
    {
        $this->response->render('views/form.php');
    }

    public function compressUrl(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->response->redirect('/');

            return;
        }

        $originalUrl = trim($_POST['url'] ?? '');

        try {
            $result = $this->urlService->compressUrl($originalUrl);

            $this->response->render('views/result.php', $result);
        } catch (InvalidArgumentException $e) {
            $this->response->render('views/form.php', [
                'error' => 'Please enter a valid URL ' . $e->getMessage(),
                'url'   => $originalUrl,
            ]);
        } catch (Exception $e) {
            $this->response->render('views/form.php', [
                'error' => 'Error: ' . $e->getMessage(),
                'url'   => $originalUrl,
            ]);
        }
    }

    public function redirectToOriginalUrl(string $shortCode): void
    {
        $originalUrl = $this->urlService->getOriginalUrl($shortCode);

        if (!is_null($originalUrl)) {
            $this->response->redirect($originalUrl);
        } else {
            $this->response->setStatusCode(404);

            echo 'URL not found';
        }
    }

    public function compressUrlApi(): void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->response->setStatusCode(405);

            echo json_encode(['error' => 'Method not allowed']);

            return;
        }

        $input       = json_decode(file_get_contents('php://input'), true);
        $originalUrl = trim($input['url'] ?? '');

        if (empty($originalUrl)) {
            $this->response->setStatusCode(400);

            echo json_encode(['error' => 'URL is required']);

            return;
        }

        try {
            $result = $this->urlService->compressUrl($originalUrl);

            echo json_encode(
                [
                    'original_url' => $result['original_url'],
                    'short_url'    => $result['short_url'],
                    'short_code'   => $result['short_code'],
                ]
            );
        } catch (InvalidArgumentException $e) {
            $this->response->setStatusCode(400);

            echo json_encode(['error' => 'Invalid URL format ' . $e->getMessage()]);
        } catch (Exception $e) {
            $this->response->setStatusCode(500);

            echo json_encode(['error' => 'Internal server error ' . $e->getMessage()]);
        }
    }
}
