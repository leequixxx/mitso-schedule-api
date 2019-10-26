<?php


namespace App\Services\MitsoService\MitsoYearsProvider;

class BaseMitsoYearBuilder implements MitsoYearBuilder
{
    /**
     * @var string $name
     */
    private $name;

    /**
     * @var int $number
     */
    private $number;

    /**
     * Set name of year.
     * @param string $name of year
     * @return MitsoYearBuilder instance
     */
    public function withName(string $name): MitsoYearBuilder
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set number of year.
     * @param int $number of year
     * @return MitsoYearBuilder instance
     */
    public function withNumber(int $number): MitsoYearBuilder
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Build instance of <b>MitsoYear</b>
     * @return MitsoYear instance
     */
    public function build(): MitsoYear
    {
        return new MitsoYear($this->name, $this->number);
    }
}
