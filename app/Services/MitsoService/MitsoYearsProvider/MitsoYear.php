<?php


namespace App\Services\MitsoService\MitsoYearsProvider;

class MitsoYear
{
    /**
     * @var string $name of year
     */
    protected $name;

    /**
     * @var int $number year number
     */
    protected $number;

    /**
     * MitsoYear constructor.
     * @param string $name
     * @param int $number
     */
    public function __construct(string $name, int $number)
    {
        $this->name = $name;
        $this->number = $number;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @param int $number
     */
    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
