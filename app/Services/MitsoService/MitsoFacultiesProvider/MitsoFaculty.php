<?php


namespace App\Services\MitsoService\MitsoFacultiesProvider;

class MitsoFaculty
{
    /**
     * @var string $name of faculty
     */
    protected $name;

    /**
     * @var string $title of faculty
     */
    protected $title;

    /**
     * MitsoFaculty constructor.
     * @param string $name
     * @param string title
     */
    public function __construct(string $name, string $title)
    {
        $this->name = $name;
        $this->title = $title;
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

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
