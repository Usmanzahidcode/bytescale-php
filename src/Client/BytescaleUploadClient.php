<?php declare(strict_types=1);

namespace UsmanZahid\Bytescale\Client;


use GuzzleHttp\Client;

class BytescaleUploadClient {
    /// API access point information
    private string $bytescaleBaseUrl = "https://api.bytescale.com";
    private string $bytescaleUploadPath = "/v2/accounts/{accountId}/uploads/binary";

    // Auth information
    private string $accountId;
    private string $apiKey;

    /// File information
    private string $fileName;
    private string $fileNameFallback;
    private string $originalFileName;
    private bool $fileNameVariables;
    private string $folderPath;
    private string $tag;

    /// Headers
    private string $contentType;
    private int $contentLength;
    private array $metadata;

    public function __construct(
        string $accountId, $apiKey
    ) {
        $this->accountId = $accountId;
        $this->apiKey = $apiKey;

        /// Add the account ID to the Upload path.
        str_replace(
            '{accountId}',
            $accountId,
            $this->bytescaleUploadPath
        );
    }

    public function withFolderPath(string $path): BytescaleUploadClient {
        $this->folderPath = $path;
        return $this;
    }

    public function withFileName(string $fileName): BytescaleUploadClient {
        $this->fileName = $fileName;
        return $this;
    }

    public function withOriginalFileName(string $originalFileName): BytescaleUploadClient {
        $this->originalFileName = $originalFileName;
        return $this;
    }

    public function withFileNameFallback(string $fileNameFallback): BytescaleUploadClient {
        $this->fileNameFallback = $fileNameFallback;
        return $this;
    }

    public function withFileNameVariables(bool $fileNameVariables): BytescaleUploadClient {
        $this->fileNameVariables = $fileNameVariables;
        return $this;
    }

    public function withTag(string $tag): BytescaleUploadClient {
        $this->tag = $tag;
        return $this;
    }

    public function withMetadata(array $metadata): BytescaleUploadClient {
        $this->metadata = $metadata;
        return $this;
    }

    public function withContentType(string $contentType): BytescaleUploadClient {
        $this->contentType = $contentType;
        return $this;
    }

    public function withContentLength(int $contentLength): BytescaleUploadClient {
        $this->contentLength = $contentLength;
        return $this;
    }

    /// Make the request
    public function upload(): BytescaleUploadClient {
        $client = new Client();

        $client->post($this->bytescaleBaseUrl . $this->bytescaleUploadPath,
            [

            ]
        );

        return $this;
    }

}
