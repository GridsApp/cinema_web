<?php

namespace App\Livewire\EntityForms;

use App\Entities\CmsUsers;
use App\Models\CmsUser;
use App\Traits\FormTrait;
use App\Traits\ToastTrait;
use Livewire\Component;

class LoginForm extends Component
{
    use FormTrait , ToastTrait;


    public function mount(){

        $this->fields = [
            config('fields.email'), config('fields.password')
        ];

        $this->resetForm();
    }

    public function handleLogin(){

        $this->validate([
            'form.email' => 'required|email',
            'form.password' => 'required'
        ], [] , ['form.email' => 'email' , 'form.password' => 'password']);

        $email = str($this->form['email'])->lower();
        $password = md5($this->form['password']);


        $cms_user = CmsUser::where('email' , $email)->where('password' , $password)->whereNull('deleted_at')->first();


        if(!$cms_user){
            $this->sendError("Wrong Credentials" , "You have entered an invalid email and password");
            return;
        }

        session([
            'cms_user' => $cms_user
        ]);

        $this->redirect("/" , navigate: true);     
    }


    public function render()
    {
        return view('pages.form.components.login-form');
    }

}
