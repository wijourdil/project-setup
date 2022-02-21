<?php

namespace Wijourdil\ProjectSetup\Tasks\Contracts;

// todo test unitaire qui vérifie que toutes les classes qui implémentent Ouputable utilisent le trait CanWriteToOutput
interface Outputable
{
    public function info(string $message): void;

    public function note(string $message): void;
}
