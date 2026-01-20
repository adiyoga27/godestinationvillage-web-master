<?php
if (function_exists('openssl_sign')) {
    echo "OpenSSL enabled.\n";
} else {
    echo "OpenSSL NOT enabled.\n";
}
