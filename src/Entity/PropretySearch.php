<?php

namespace App\Entity;
class PropretySearch{
    /**
     * @var string|null
     */
    private $sujet;

    /**
     * @return string|null
     */
    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    /**
     * @param string|null $sujet
     */
    public function setSujet(string $sujet): void
    {
        $this->sujet = $sujet;
    }

}
