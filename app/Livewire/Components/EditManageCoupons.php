<?php

namespace App\Livewire\Components;

use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Coupon;
use Livewire\Attributes\Url;
use Livewire\Component;
use twa\uikit\Traits\ToastTrait;
use Illuminate\Support\Facades\DB;

class EditManageCoupons extends Component
{

    use ToastTrait;


    #[Url]
    public $form = [];


    public $editingCoupon = null;



    public function mount($id = null)
    {



        // dd($id);
        if ($id) {
            $coupon = Coupon::find($id);
            if ($coupon) {
                if ($coupon->used_at) {
                    $this->sendError("Error", "This coupon has already been used and cannot be edited.");
                    redirect()->route('manage-coupons');
                    return;
                }
                $this->editingCoupon = $coupon;
                $this->form = [
                    'label' => $coupon->label,
                    'code' => $coupon->code,
                    'discount_flat' => $coupon->discount_flat,
                    'expires_at' => $coupon->expires_at,
                ];
            }
        }
    }


    public function editCoupon()
    {
        if ($this->editingCoupon && $this->editingCoupon->used_at) {
            $this->sendError("Error", "This coupon has already been used and cannot be edited.");
            return redirect()->route('manage-coupons');
        }
        // Check if another coupon with the same code exists
        $exists = Coupon::where('code', $this->form['code'])
            ->where('id', '!=', $this->editingCoupon->id)
            ->whereNull('deleted_at')
            ->exists();

        if ($exists) {
            $this->sendError("Error", "A coupon with this code already exists.");
            return;
        }

        $this->editingCoupon->label = $this->form['label'];
        $this->editingCoupon->code = $this->form['code'];
        $this->editingCoupon->discount_flat = $this->form['discount_flat'];
        $this->editingCoupon->expires_at = $this->form['expires_at'];
        $this->editingCoupon->save();
        // $this->sendSuccess("Success", "Success");

     
        return redirect()->route('manage-coupons', ['form[coupon_code]' => $this->editingCoupon->code]);
    }

    public function render()
    {



        return view('components.form.edit-manage-coupons');
    }
}
