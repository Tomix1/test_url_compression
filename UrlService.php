<?php

class UrlService
{
    public function __construct(
        private readonly UrlRepository $repository,
        private readonly string $baseUrl
    ) {
    }

    /**
     * @throws Random\RandomException
     */
    public function compressUrl(string $originalUrl): array
    {
        if (!filter_var($originalUrl, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Invalid URL format');
        }

        $existingUrl = $this->repository->findByOriginalUrl($originalUrl);

        if (!is_null($existingUrl)) {
            return [
                'original_url'   => $existingUrl['original_url'],
                'short_code'     => $existingUrl['short_code'],
                'short_url'      => $this->baseUrl . $existingUrl['short_code'],
                'already_exists' => true,
            ];
        }

        $attempts = 0;

        do {
            $shortCode    = $this->generateShortCode();
            $existingCode = $this->repository->findByShortCode($shortCode);
            $attempts++;
        } while ($existingCode && $attempts < 10);

        if (!is_null($existingCode)) {
            throw new RuntimeException('Failed generate unique short code');
        }

        if (!$this->repository->save($originalUrl, $shortCode)) {
            throw new RuntimeException('Failed to save URL to database');
        }

        return [
            'original_url'   => $originalUrl,
            'short_code'     => $shortCode,
            'short_url'      => $this->baseUrl . $shortCode,
            'already_exists' => false,
        ];
    }

    /**
     * @throws Random\RandomException
     */
    public function generateShortCode(int $length = 6): string
    {
        $characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $shortCode        = '';

        for ($i = 0; $i < $length; $i++) {
            $shortCode .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $shortCode;
    }

    public function getOriginalUrl(string $shortCode): ?string
    {
        $url = $this->repository->findByShortCode($shortCode);

        return $url ? $url['original_url'] : null;
    }
}
