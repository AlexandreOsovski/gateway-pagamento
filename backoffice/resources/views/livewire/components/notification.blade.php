@php
    $notification = App\Models\NotificationModel::where('client_id', Auth::guard('client')->user()->id)
        ->where('status', false)
        ->count();
@endphp

@if ($notification == 0)
    <span class=""></span>
@else
    <span class="option-badge">{{ $notification }}</span>
@endif
