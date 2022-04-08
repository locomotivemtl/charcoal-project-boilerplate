<?php

// Default, strict CSP (report only)
header("Content-Security-Policy-Report-Only: "
    ."default-src 'self'; "
    ."style-src 'self'; "
    ."script-src 'self'; "
    ."img-src 'self' data:;"
    ."font-src 'self' data:; "
    ."connect-src 'self'; "
    ."frame-src 'self'; "
    ."form-action 'self'; "
    ."upgrade-insecure-requests; "
    ."block-all-mixed-content; "
    ."report-uri /csp.php");
