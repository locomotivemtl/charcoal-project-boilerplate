<?php

/** Content-Security-Policy headers */
header("Content-Security-Policy-Report-Only: "
    ."default-src 'self'; "
    ."style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com https://*.bootstrapcdn.com; "
    ."script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com; "
    ."img-src 'self' data: https://cdnjs.cloudflare.com; "
    ."font-src 'self' data: https://*.bootstrapcdn.com https://fonts.gstatic.com; "
    ."form-action 'self'; "
    ."upgrade-insecure-requests; "
    ."block-all-mixed-content; "
    ."report-uri /csp.php");


