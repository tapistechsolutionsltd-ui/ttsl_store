@php
    static $emailLogoSmB64 = null;
    if ($emailLogoSmB64 === null) {
        $logoFile = public_path('images/logo_email.png');
        $emailLogoSmB64 = file_exists($logoFile)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoFile))
            : '';
    }
@endphp
@if($emailLogoSmB64)
<img src="{{ $emailLogoSmB64 }}"
     alt="TTSolutions Limited"
     width="120" height="42"
     style="display:block;margin:0 auto;max-width:120px;height:auto;border:0;outline:none;opacity:0.85;">
@endif
