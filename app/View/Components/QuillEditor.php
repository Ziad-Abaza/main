<?php

namespace App\View\Components;

use Illuminate\View\Component;

class QuillEditor extends Component
{
    public $name;
    public $value;
    public $id;
    public $height;

    public function __construct($name, $value = '', $id = null, $height = '300px')
    {
        $this->name = $name;
        $this->value = $value;
        $this->id = $id;
        $this->height = $height;
    }

    public function render()
    {
        return view('components.quill-editor');
    }
}
