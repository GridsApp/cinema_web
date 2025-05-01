<?php

namespace App\Livewire\EntityForms;

use Livewire\Attributes\Url;
use Livewire\Component;

class DistributorSharesReportForm extends Component
{
    public $slug;

    // #[Url]
    public $form = [];

    public $rows = [];

    public $classPath = null;

    public $filters = [];

    public function mount()
    {

   
        $this->form['date'] = null;

        $this->form['distributor_id'] = null;
        $this->form['branch_id'] = null;

    
    }

    public function applyFilters()
    {


        $this->validate([
            'form.date' => 'required',
            'form.distributor_id' => 'required',
        ], [
            'form.distributor_id.required' => 'Distributor is required.',
            'form.date.required' => 'Date is required.',
           
        ]);
        $params = [
            'date'     => $this->form['date'] ?? null,
            'distributor_id'  => $this->form['distributor_id'] ?? null, 
            'branch_id'      => $this->form['branch_id'] ?? null,
        ];
    
      
       $this->redirect(route('distributor-film-hire.render-result' , $params));  
      
    }
    
    
    public function render()
    {
        return view('pages.form.components.distributor-shares-report-form', [
            'filters' => $this->filters
        ]);
    }
}
