<x-mail::message>
# Password Reset Request  
## طلب إعادة تعيين كلمة المرور
 
Dear {{ $email }},  
عزيزي {{ $email }}،
 
You requested to reset your password.  
لقد قمت بطلب إعادة تعيين كلمة المرور.
 
Please use the OTP below to proceed:  
يرجى استخدام رمز التحقق أدناه للمتابعة:
 
## 🔐 {{ $otp }}
 
This OTP is valid for a limited time. Do **not** share it with anyone.  
هذا الرمز صالح لفترة محدودة. **لا** تقم بمشاركته مع أي شخص.
  
Thanks,<br>
{{ config('app.name') }}  
شكراً،<br>
{{ config('app.name') }}
</x-mail::message>