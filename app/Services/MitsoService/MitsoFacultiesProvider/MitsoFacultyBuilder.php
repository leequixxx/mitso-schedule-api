<?php


namespace App\Services\MitsoService\MitsoFacultiesProvider;

interface MitsoFacultyBuilder
{
    /**
     * Set name of faculty.
     * @param string $name of faculty
     * @return MitsoFacultyBuilder instance
     */
    public function withName(string $name): MitsoFacultyBuilder;

    /**
     * Set title of faculty.
     * @param string $title of faculty
     * @return MitsoFacultyBuilder instance
     */
    public function withTitle(string $title): MitsoFacultyBuilder;

    /**
     * Build instance of <b>MitsoFaculty</b>.
     * @return MitsoFaculty instance
     */
    public function build(): MitsoFaculty;
}
