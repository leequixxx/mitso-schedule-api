<?php


namespace App\Services\MitsoService\MitsoStudyModelsProvider;


class BaseMitsoStudyModelBuilder implements MitsoStudyModelBuilder
{
    /**
     * @var string $name of study model
     */
    private $name;

    /**
     * @var string $title of study model
     */
    private $title;

    /**
     * Set name of faculty.
     * @param string $name of faculty
     * @return MitsoStudyModelBuilder instance
     */
    public function withName(string $name): MitsoStudyModelBuilder
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set title of faculty.
     * @param string $title of study model
     * @return MitsoStudyModelBuilder instance
     */
    public function withTitle(string $title): MitsoStudyModelBuilder
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Build instance of <b>MitsoStudyModel</b>.
     * @return MitsoStudyModel instance
     */
    public function build(): MitsoStudyModel
    {
        return new MitsoStudyModel($this->name, $this->title);
    }
}
