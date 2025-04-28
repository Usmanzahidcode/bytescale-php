<?php declare(strict_types=1);

namespace UsmanZahid\Bytescale\Client\Upload;

use UsmanZahid\Bytescale\Client\ErrorResponse;

class UploadResponse {
    public string $accountId;
    public string $etag;
    public string $filePath;
    public string $fileUrl;

    public ?ErrorResponse $error;

    public function wasSuccessful(): bool {
        return true;
    }

    public function wasNotSuccessful(): bool {
        return false;
    }
}