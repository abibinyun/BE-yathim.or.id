<?php

namespace App\View\Components;

use Closure;
use App\Models\Category;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class CampaignSlider extends Component
{
    public $category;
    public $campaigns;

    /**
     * Create a new component instance.
     */
    public function __construct($categoryId)
    {
        $this->category = Category::findOrFail($categoryId);
        $this->campaigns = $this->category->campaigns; // Asumsi ada relasi dengan campaign
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.campaign-slider');
    }
}
