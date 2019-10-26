<?php


namespace App\Services\MitsoService\MitsoStudyModelsProvider;

interface MitsoStudyModelBuilder
{
    /**
     * Set name of faculty.
     * @param string $name of faculty
     * @return MitsoStudyModelBuilder instance
     */
    public function withName(string $name): MitsoStudyModelBuilder;

    /**
     * Set title of faculty.
     * @param string $title of study model
     * @return MitsoStudyModelBuilder instance
     */
    public function withTitle(string $title): MitsoStudyModelBuilder;

    /**
     * Build instance of <b>MitsoStudyModel</b>.
     * @return MitsoStudyModel instance
     */
    public function build(): MitsoStudyModel;
}
