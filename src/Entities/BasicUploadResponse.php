<?php declare(strict_types=1);

namespace UsmanZahid\Bytescale\Entities;

class BasicUploadResponse {
    public string $accountId;
    public string $etag;
    public string $filePath;
    public string $fileUrl;

    public function __construct(
        string $accountId,
        string $etag,
        string $filePath,
        string $fileUrl
    ) {
        $this->accountId = $accountId;
        $this->etag = $etag;
        $this->filePath = $filePath;
        $this->fileUrl = $fileUrl;
    }
}
