<?php

class UrlRepository
{
    public function __construct(private readonly PDO $db)
    {
    }

    public function findByOriginalUrl(string $originalUrl): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM urls WHERE original_url = :original_url");

        $stmt->execute(['original_url' => $originalUrl]);

        return $stmt->fetch() ?: null;
    }

    public function findByShortCode(string $shortCode): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM urls WHERE short_code = :short_code");

        $stmt->execute(['short_code' => $shortCode]);

        return $stmt->fetch() ?: null;
    }

    public function save(string $originalUrl, string $shortCode): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO urls (original_url, short_code, created_at) VALUES (:original_url, :short_code, NOW())"
        );

        return $stmt->execute(
            [
                'original_url' => $originalUrl,
                'short_code'   => $shortCode,
            ]
        );
    }
}
