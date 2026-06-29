@php
    /* Inline base64 PNG — no external URL, works in Gmail, Apple Mail, Outlook */
    static $emailLogoB64 = null;
    if ($emailLogoB64 === null) {
        $logoFile = public_path('images/logo_email.png');
        $emailLogoB64 = file_exists($logoFile)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoFile))
            : '';
    }
@endphp
@if($emailLogoB64)
<img src="{{ $emailLogoB64 }}"
     alt="TTSolutions Limited"
     width="200" height="70"
     style="display:block;margin:0 auto 14px;max-width:200px;height:auto;border:0;outline:none;">
@else
<p style="color:#ffffff;font-size:18px;font-weight:bold;margin:0 0 14px;text-align:center;">
    TTSolutions Limited
</p>
@endif
