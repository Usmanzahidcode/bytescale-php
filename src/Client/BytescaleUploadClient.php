<?php declare(strict_types=1);

namespace UsmanZahid\Bytescale\Client;

class BytescaleUploadClient {
    private string $bytescaleBaseUrl = "https://api.bytescale.com";
    private string $bytescaleUploadPath = "/v2/accounts/{accountId}/uploads/binary";
    private string $accountId;
    private string $apiKey;

    private string $folderPath;
    private string $fileName;
    private string $originalFileName;
    private string $fileNameFallback;
    private bool $fileNameVariables;
    private string $tag;

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

}
