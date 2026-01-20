<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$comment = \App\Models\PostComment::where('comment', 'Manual comment test from script.')->latest()->first();
if ($comment) {
    echo "FOUND: " . $comment->comment . "\n";
    $comment->delete();
    echo "DELETED\n";
} else {
    echo "NOT FOUND\n";
}
