@component('mail::message')
# Account Deletion Confirmation

Hello **{{ $username }}**,  

You recently requested to delete your account.  
Please confirm this action by clicking the button below:

@component('mail::button', ['url' => $url])
Confirm Account Deletion
@endcomponent

This link will expire in **30 minutes**.  
If you did not make this request, you can safely ignore this email.

---

Thanks,  
**The Timedoor Marketplace Team**

@endcomponent