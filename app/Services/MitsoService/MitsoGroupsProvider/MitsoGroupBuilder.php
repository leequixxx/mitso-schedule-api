<?php


namespace App\Services\MitsoService\MitsoGroupsProvider;

interface MitsoGroupBuilder
{
    /**
     * Set name of group.
     * @param string $name of group
     * @return MitsoGroupBuilder instance
     */
    public function withName(string $name): MitsoGroupBuilder;

    /**
     * Set title of group.
     * @param string $title of group
     * @return MitsoGroupBuilder instance
     */
    public function withTitle(string $title): MitsoGroupBuilder;

    /**
     * Build instance of <b>MitsoGroup</b>.
     * @return MitsoGroup instance
     */
    public function build(): MitsoGroup;
}
