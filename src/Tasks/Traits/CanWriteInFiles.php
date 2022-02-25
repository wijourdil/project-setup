<?php

namespace Wijourdil\ProjectSetup\Tasks\Traits;

use Exception;

trait CanWriteInFiles
{
    protected function appendContentInFile(string $newContent, string $textBeforeNewContent, string $filename): void
    {
        $fileContent = file_get_contents($filename);

        if ($fileContent === false) {
            throw new Exception("Can't get content for file $filename");
        }

        file_put_contents(
            $filename,
            str_replace(
                "$textBeforeNewContent",
                "$textBeforeNewContent{$newContent}",
                $fileContent
            )
        );
    }
}
