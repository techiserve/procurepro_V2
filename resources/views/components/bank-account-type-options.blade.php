@php
    $currentAccountType = (string) ($selected ?? '');
    $selectedCode = \App\Support\BankAccountType::code($currentAccountType);
@endphp
<option value="">--Select--</option>
@if($currentAccountType !== '' && $selectedCode === null)
    <option value="{{ $currentAccountType }}" selected>{{ $currentAccountType }} (existing)</option>
@endif
@foreach(\App\Support\BankAccountType::OPTIONS as $code => $label)
    <option value="{{ $code }}" @selected($selectedCode === (string) $code)>{{ $label }}</option>
@endforeach
