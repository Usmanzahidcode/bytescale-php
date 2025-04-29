<?php declare(strict_types=1);

namespace UsmanZahid\Bytescale\Client\Upload;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use UsmanZahid\Bytescale\Entities\BasicUploadResponse;
use UsmanZahid\Bytescale\Exceptions\BytescaleUploadException;
use UsmanZahid\Bytescale\Exceptions\GeneralBytescaleException;

class BytescaleUploadClient {
    /// Api end points
    private string $bytescaleBaseUrl = "https://api.bytescale.com/";
    private string $bytescaleUploadPath = "v2/accounts/{accountId}/uploads/binary/";

    // Auth
    private string $accountId;
    private string $apiKey;

    /// Source file
    private ?string $sourceFilePath = null;
    private ?string $sourceFileContent = null;

    /// Request parameters
    private ?string $filePath = null;
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
        $this->bytescaleUploadPath = str_replace('{accountId}', $this->accountId, $this->bytescaleUploadPath);
    }


    public function withSourceFilePath(string $filePath): BytescaleUploadClient {
        $this->sourceFilePath = $filePath;
        return $this;
    }

    public function withSourceFileContent(string $sourceFileContent): BytescaleUploadClient {
        $this->sourceFileContent = $sourceFileContent;
        return $this;
    }

    public function withFilePath(string $path): self {
        $this->sourceFilePath = $path;
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

    /**
     * Send the upload request with the provided options.
     *
     * @throws BytescaleUploadException
     * @throws GeneralBytescaleException
     */
    public function upload(): BasicUploadResponse {
        var_dump($this->sourceFilePath);
        var_dump($this->sourceFileContent);

        /// Check if either file path or file content is provided
        if (empty($this->fileContent) && (empty($this->sourceFilePath) || !file_exists($this->sourceFilePath))) {
            throw new \InvalidArgumentException("You must provide either a valid file path or file content.");
        }

        /// If the file path is provided, read the content of the file
        if (!empty($this->sourceFilePath) && file_exists($this->sourceFilePath)) {
            $this->sourceFileContent = file_get_contents($this->sourceFilePath);
        }

        /// Set up the client
        $client = new Client([
            'base_uri' => $this->bytescaleBaseUrl,
            'timeout' => 15,
        ]);

        /// Add the query parameters
        $queryParams = [];

        if ($this->fileName!==null) $queryParams['fileName'] = $this->fileName;
        if ($this->fileName!==null) $queryParams['filePath'] = $this->filePath;
        if ($this->originalFileName!==null) $queryParams['originalFileName'] = $this->originalFileName;
        if ($this->fileNameFallback!==null) $queryParams['fileNameFallback'] = $this->fileNameFallback;
        if ($this->fileNameVariables!==null) $queryParams['fileNameVariables'] = $this->fileNameVariables ? 'true':'false';
        if ($this->tag!==null) $queryParams['tag'] = $this->tag;
        if ($this->metadata!==null) $queryParams['metadata'] = json_encode($this->metadata);

        /// Add headers
        $headers = [
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type' => $this->contentType ?? $this->guessMimeType($this->sourceFilePath),
            'Content-Length' => $this->contentLength,
        ];

        /// Make the request
        try {
            $response = $client->post($this->bytescaleUploadPath, [
                'headers' => $headers,
                'query' => $queryParams,
                'body' => fopen($this->sourceFilePath, 'r'),
            ]);
        } catch (GuzzleException $exception) {
            throw new BytescaleUploadException($exception->getMessage(), $exception->getCode(), $exception);
        } catch (\Throwable $exception) {
            throw new GeneralBytescaleException(previous: $exception);
        }

        // Extract the response body and decode JSON if necessary
        $responseContents = $response->getBody()->getContents();
        $responseData = json_decode($responseContents, true);

        // If the response is valid and contains expected data
        if (!isset($responseData['accountId'], $responseData['etag'], $responseData['filePath'], $responseData['fileUrl'])) {
            throw new GeneralBytescaleException("Invalid response from the Bytescale API.");
        }

        return new BasicUploadResponse(
            $responseData['accountId'],
            $responseData['etag'],
            $responseData['filePath'],
            $responseData['fileUrl']
        );
    }

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
