<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public $name,$inputTitle,$type,$value,$form;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name="name",$inputTitle="Input Title",$type="text",$value=null,$form=null)
    {
        $this->name=$name;
        $this->inputTitle=$inputTitle;
        $this->type=$type;
        $this->value=$value;
        $this->form=$form;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input');
    }
}
