<?php

namespace Wijourdil\ProjectSetup\Tasks\Contracts;

// todo faire également un test pour checker que toutes les classes qui héritent de cette interface ne retournent pas un tableau vide
//  => si jamais j'ai une classe dont la méthode dependsOn() retourne un tableau vide, le test doit demander à supprimer cette interface
interface Dependable
{
    /**
     * @return array<class-string>
     */
    public function dependsOn(): array;
}
