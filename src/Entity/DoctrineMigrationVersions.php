<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DoctrineMigrationVersions
 *
 * @ORM\Table(name="doctrine_migration_versions")
 * @ORM\Entity
 */
class DoctrineMigrationVersions
{
    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=191, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $version;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="executed_at", type="datetime", nullable=true)
     */
    private $executedAt;

    /**
     * @var int|null
     *
     * @ORM\Column(name="execution_time", type="integer", nullable=true)
     */
    private $executionTime;

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @return \DateTime|null
     */
    public function getExecutedAt(): ?\DateTime
    {
        return $this->executedAt;
    }

    /**
     * @param \DateTime|null $executedAt
     */
    public function setExecutedAt(?\DateTime $executedAt): void
    {
        $this->executedAt = $executedAt;
    }

    /**
     * @return int|null
     */
    public function getExecutionTime(): ?int
    {
        return $this->executionTime;
    }

    /**
     * @param int|null $executionTime
     */
    public function setExecutionTime(?int $executionTime): void
    {
        $this->executionTime = $executionTime;
    }



}
