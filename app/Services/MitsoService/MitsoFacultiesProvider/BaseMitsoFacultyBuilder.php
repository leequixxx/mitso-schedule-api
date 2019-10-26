<?php


namespace App\Services\MitsoService\MitsoFacultiesProvider;

class BaseMitsoFacultyBuilder implements MitsoFacultyBuilder
{
    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $title
     */
    private $title;

    /**
     * Set name of faculty.
     * @param string $name of faculty
     * @return MitsoFacultyBuilder instance
     */
    public function withName(string $name): MitsoFacultyBuilder
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set title of faculty.
     * @param string $title of faculty
     * @return MitsoFacultyBuilder instance
     */
    public function withTitle(string $title): MitsoFacultyBuilder
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Build instance of <b>MitsoFaculty</b>.
     * @return MitsoFaculty instance
     */
    public function build(): MitsoFaculty
    {
        return new MitsoFaculty($this->name, $this->title);
    }
}
