<?php

namespace App\Livewire\EntityForms;

use Livewire\Attributes\Url;
use Livewire\Component;

class BoxOfficeReportSummaryForm extends Component
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
        $this->validate([
            'form.start_date' => 'required',
            'form.end_date' => 'required',
        ], [
            'form.start_date.required' => 'Start date is required.',
            'form.end_date.required' => 'End date is required.',
           
        ]);
    
        $params = [
            'start_date'     => $this->form['start_date'],
            'end_date'       => $this->form['end_date'],
            'distributor_id' => $this->form['distributor_id'],
            'branch_id'      => $this->form['branch_id'],
        ];
    
      
       $this->redirect(route('box-office-report-summary.render-result' , $params));  
      
    }
    
    
    public function render()
    {
        return view('pages.form.components.box-office-report-summary-form', [
            'filters' => $this->filters
        ]);
    }
}
