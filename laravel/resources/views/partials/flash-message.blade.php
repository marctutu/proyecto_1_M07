<!-- Bootstrap version
<div class="alert alert-{{$type}} alert-dismissible fade show" role="alert">
   {{ $message }} 
   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
 -->

<!-- Tailwind version -->
@php
   $tailwindClass = [
      'success' => 'p-5 text-[#0f5132] bg-[#d1e7dd] border border-[#badbcc] rounded',
      'danger'  => 'p-5 text-[#842029] bg-[#f8d7da] border border-[#f5c2c7] rounded',
      'warning' => 'p-5 text-[#664d03] bg-[#fff3cd] border border-[#ffecb5] rounded',
      'info'    => 'p-5 text-[#055160] bg-[#cff4fc] border border-[#b6effb] rounded',
   ]
@endphp
<div class="{{ $tailwindClass[$type] }}" role="alert">
   {{ $message }} 
   <button type="button" class="float-right close-flash-message" data-dismiss-target="alert" aria-label="Close">X</button>
</div>