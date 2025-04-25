<?php

namespace App\Livewire\EntityForms;

use Livewire\Attributes\Url;
use Livewire\Component;

class BoxOfficeReportForm extends Component
{
    public $slug;

    // #[Url]
    public $form = [];

    public $rows = [];

    public $classPath = null;

    public $filters = [];

    public function mount()
    {

   
        $this->form['start_date'] = null;
        $this->form['end_date'] = null;
        $this->form['distributor_id'] = null;
        $this->form['branch_id'] = null;

    
    }

    public function applyFilters()
    {
        $params = [
            'start_date'     => $this->form['start_date'] ?? null,
            'end_date'       => $this->form['end_date'] ?? null,
            'distributor_id'  => $this->form['distributor_id'] ?? null, 
            'branch_id'      => $this->form['branch_id'] ?? null,
        ];
    
      
       $this->redirect(route('box-office-report.render-result' , $params));  
      
    }
    
    
    public function render()
    {
        return view('pages.form.components.box-office-report-form', [
            'filters' => $this->filters
        ]);
    }
}
