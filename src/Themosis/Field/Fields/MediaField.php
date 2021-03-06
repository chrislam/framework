<?php
namespace Themosis\Field\Fields;

use Themosis\View\ViewFactory;

class MediaField extends FieldBuilder implements IField
{
    /**
     * Build a MediaField instance.
     *
     * @param array $properties
     * @param ViewFactory $view
     */
    public function __construct(array $properties, ViewFactory $view)
    {
        $this->properties = $properties;
        $this->view = $view;
        $this->setTitle();
        $this->setType();
        $this->setSize();
        $this->fieldType();
    }

    /**
     * Set the type data of the media to insert.
     * If no type is defined, default to 'image'.
     *
     * @return void
     */
    protected function setType()
    {
        $allowed = ['image', 'application', 'video', 'audio'];

        if (isset($this['type']) && !in_array($this['type'], $allowed))
        {
            $this['type'] = 'image';
        }
        elseif (!isset($this['type']))
        {
            $this['type'] = 'image';
        }
    }

    /**
     * Set the size data of the media to insert.
     * If no size is defined, default to 'full'.
     *
     * @return void
     */
    protected function setSize()
    {
        $sizes = get_intermediate_image_sizes();

        if (isset($this['size']) && !in_array($this['size'], $sizes))
        {
            $this['size'] = 'full';
        }
        elseif (!isset($this['size']))
        {
            $this['size'] = 'full';
        }
    }

    /**
     * Define the input type that handle the data.
     *
     * @return void
     */
    protected function fieldType()
    {
        $this->type = 'hidden';
    }

    /**
     * Set a default label title, display text if not defined.
     *
     * @return void
     */
    protected function setTitle()
    {
        $this['title'] = isset($this['title']) ? ucfirst($this['title']) : ucfirst($this['name']);
    }

    /**
     * Method that handle the field HTML code for
     * metabox output.
     *
     * @return string
     */
    public function metabox()
    {
        return $this->view->make('metabox._themosisMediaField', ['field' => $this])->render();
    }

    /**
     * Handle the field HTML code for the
     * Settings API output.
     *
     * @return string
     */
    public function page()
    {
        return $this->metabox();
    }

    /**
     * Handle the HTML code for user output.
     *
     * @return string
     */
    public function user()
    {
        return $this->metabox();
    }


}