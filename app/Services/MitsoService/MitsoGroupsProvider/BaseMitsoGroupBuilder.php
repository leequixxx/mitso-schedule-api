<?php


namespace App\Services\MitsoService\MitsoGroupsProvider;

class BaseMitsoGroupBuilder implements MitsoGroupBuilder
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
     * Set name of group.
     * @param string $name of group
     * @return MitsoGroupBuilder instance
     */
    public function withName(string $name): MitsoGroupBuilder
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set title of group.
     * @param string $title of group
     * @return MitsoGroupBuilder instance
     */
    public function withTitle(string $title): MitsoGroupBuilder
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Build instance of <b>MitsoGroup</b>.
     * @return MitsoGroup instance
     */
    public function build(): MitsoGroup
    {
        return new MitsoGroup($this->name, $this->title);
    }
}
