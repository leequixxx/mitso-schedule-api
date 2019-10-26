<?php


namespace App\Services\MitsoService\MitsoYearsProvider;

interface MitsoYearBuilder
{
    /**
     * Set name of year.
     * @param string $name of year
     * @return MitsoYearBuilder instance
     */
    public function withName(string $name): MitsoYearBuilder;

    /**
     * Set number of year.
     * @param int $number of year
     * @return MitsoYearBuilder instance
     */
    public function withNumber(int $number): MitsoYearBuilder;

    /**
     * Build instance of <b>MitsoYear</b>
     * @return MitsoYear instance
     */
    public function build(): MitsoYear;
}
