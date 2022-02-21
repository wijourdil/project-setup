<?php

namespace Wijourdil\ProjectSetup\Tasks\Traits;

trait CanWriteInFiles
{
    protected function appendContentInFile(string $newContent, string $textBeforeNewContent, string $filename): void
    {
        file_put_contents(
            $filename,
            str_replace(
                "$textBeforeNewContent",
                "$textBeforeNewContent{$newContent}",
                file_get_contents($filename)
            )
        );
    }
}
