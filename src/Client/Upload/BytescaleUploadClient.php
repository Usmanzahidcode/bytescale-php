<?php declare(strict_types=1);

namespace UsmanZahid\Bytescale\Client\Upload;

use GuzzleHttp\Client;
use UsmanZahid\Bytescale\Exceptions\GeneralBytescaleException;

class BytescaleUploadClient {
    private string $bytescaleBaseUrl = "https://api.bytescale.com/";
    private string $bytescaleUploadPath = "v2/accounts/{accountId}/uploads/binary/";

    private string $accountId;
    private string $apiKey;

    private string $filePath;
    private ?string $fileName = null;
    private ?string $originalFileName = null;
    private ?string $fileNameFallback = null;
    private ?bool $fileNameVariables = null;
    private ?string $tag = null;
    private ?array $metadata = null;
    private ?string $contentType = null;
    private ?int $contentLength = null;

    public function __construct(string $accountId, string $apiKey) {
        /// Set the auth information
        $this->accountId = $accountId;
        $this->apiKey = $apiKey;

        /// Update the upload path with the accountId
        $this->bytescaleUploadPath = str_replace('{accountId}', $accountId, $this->bytescaleUploadPath);
    }

    public function withFilePath(string $path): self {
        $this->filePath = $path;
        return $this;
    }

    public function withFileName(string $name): self {
        $this->fileName = $name;
        return $this;
    }

    public function withOriginalFileName(string $original): self {
        $this->originalFileName = $original;
        return $this;
    }

    public function withFileNameFallback(string $fallback): self {
        $this->fileNameFallback = $fallback;
        return $this;
    }

    public function withFileNameVariables(bool $variables): self {
        $this->fileNameVariables = $variables;
        return $this;
    }

    public function withTag(string $tag): self {
        $this->tag = $tag;
        return $this;
    }

    public function withMetadata(array $metadata): self {
        $this->metadata = $metadata;
        return $this;
    }

    public function withContentType(string $contentType): self {
        $this->contentType = $contentType;
        return $this;
    }

    public function withContentLength(int $length): self {
        $this->contentLength = $length;
        return $this;
    }

    public function upload(): array {
        if (!isset($this->filePath) || !file_exists($this->filePath)) {
            throw new \InvalidArgumentException("Invalid file path provided.");
        }

        $client = new Client([
            'base_uri' => $this->bytescaleBaseUrl,
            'timeout' => 15,
        ]);

        $queryParams = [];

        if ($this->fileName!==null) $queryParams['fileName'] = $this->fileName;
        if ($this->originalFileName!==null) $queryParams['originalFileName'] = $this->originalFileName;
        if ($this->fileNameFallback!==null) $queryParams['fileNameFallback'] = $this->fileNameFallback;
        if ($this->fileNameVariables!==null) $queryParams['fileNameVariables'] = $this->fileNameVariables ? 'true':'false';
        if ($this->tag!==null) $queryParams['tag'] = $this->tag;
        if ($this->metadata!==null) $queryParams['metadata'] = json_encode($this->metadata);

        $headers = [
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type' => $this->contentType ?? $this->guessMimeType($this->filePath),
        ];

        try {
            $response = $client->post($this->bytescaleUploadPath, [
                'headers' => $headers,
                'query' => $queryParams,
                'body' => fopen($this->filePath, 'r'),
            ]);

        } catch (\Throwable $exception) { // TODO: Better exception handling
            throw new GeneralBytescaleException($exception->getMessage(), $exception->getCode(), $exception);
        }


        return json_decode($response->getBody()->getContents(), true);
    }

    // TODO: Move to Helper for easier access.
    private function guessMimeType(string $filePath): string {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        return match ($extension) { 
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'pdf' => 'application/pdf',
            'zip' => 'application/zip',
            'txt' => 'text/plain',
            'json' => 'application/json',
            'csv' => 'text/csv',
            'mp4' => 'video/mp4',
            'mp3' => 'audio/mpeg',
            default => 'application/octet-stream',
        };
    }


}
