<?php

namespace App\Support;

use Illuminate\Http\Client\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class CloudinaryUploader
{
    public function upload(UploadedFile $file, string $folder): string
    {
        $cloudName = (string) config('services.cloudinary.cloud_name');
        $apiKey = (string) config('services.cloudinary.api_key');
        $apiSecret = (string) config('services.cloudinary.api_secret');

        if (blank($cloudName) || blank($apiKey) || blank($apiSecret)) {
            throw new RuntimeException('Cloudinary is not configured.');
        }

        $timestamp = time();
        $params = [
            'folder' => trim($folder, '/'),
            'timestamp' => $timestamp,
        ];

        $signature = $this->sign($params, $apiSecret);

        $response = Http::asMultipart()
            ->attach('file', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName())
            ->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                ...$params,
                'api_key' => $apiKey,
                'signature' => $signature,
            ]);

        return $this->extractSecureUrl($response);
    }

    public function delete(string $url): void
    {
        $cloudName = (string) config('services.cloudinary.cloud_name');
        $apiKey = (string) config('services.cloudinary.api_key');
        $apiSecret = (string) config('services.cloudinary.api_secret');
        $publicId = $this->extractPublicId($url, $cloudName);

        if (blank($cloudName) || blank($apiKey) || blank($apiSecret) || blank($publicId)) {
            return;
        }

        $timestamp = time();
        $params = [
            'public_id' => $publicId,
            'timestamp' => $timestamp,
        ];

        $signature = $this->sign($params, $apiSecret);

        Http::asForm()->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/destroy", [
            ...$params,
            'api_key' => $apiKey,
            'signature' => $signature,
        ])->throw();
    }

    /**
     * @return array{name: string, size: int, type: string, url: string}
     */
    public function getUploadedFile(string $url): array
    {
        $path = parse_url($url, PHP_URL_PATH) ?: '';
        $name = basename($path) ?: 'image';
        $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));

        return [
            'name' => $name,
            'size' => 0,
            'type' => match ($extension) {
                'png' => 'image/png',
                'gif' => 'image/gif',
                'webp' => 'image/webp',
                'avif' => 'image/avif',
                default => 'image/jpeg',
            },
            'url' => $url,
        ];
    }

    /**
     * @param  array<string, string|int>  $params
     */
    protected function sign(array $params, string $apiSecret): string
    {
        ksort($params);

        return sha1(
            collect($params)
                ->map(fn (string | int $value, string $key): string => "{$key}={$value}")
                ->implode('&')
            . $apiSecret
        );
    }

    protected function extractSecureUrl(Response $response): string
    {
        $response->throw();

        $secureUrl = $response->json('secure_url');

        if (! is_string($secureUrl) || blank($secureUrl)) {
            throw new RuntimeException('Cloudinary did not return a secure URL.');
        }

        return $secureUrl;
    }

    protected function extractPublicId(string $url, string $cloudName): ?string
    {
        $path = parse_url($url, PHP_URL_PATH);

        if (! is_string($path) || ! str_contains($path, "/{$cloudName}/image/upload/")) {
            return null;
        }

        $segments = explode('/upload/', $path, 2);

        if (count($segments) !== 2) {
            return null;
        }

        $assetPath = preg_replace('#^v\d+/#', '', $segments[1]);

        if (! is_string($assetPath) || blank($assetPath)) {
            return null;
        }

        return Str::beforeLast($assetPath, '.');
    }
}
