<?php

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Http\Controllers\Front\PageController;
use App\Models\User;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Mock Auth
$user = User::first();
if (!$user) exit("No user found.\n");
Auth::login($user);
echo "Logged in as: " . $user->name . "\n";

// Get Blog
$blog = Blog::first();
if (!$blog) exit("No blog found.\n");
echo "Blog Slug: " . $blog->slug . "\n";

// Test postComment
$controller = new PageController();
$request = Request::create("/blog/comment/" . $blog->slug, 'POST', [
    'comment' => 'Manual comment test from script.'
]);

// We need to bypass the redirect->back() in the script environment or catch the response
// Since it returns a RedirectResponse, we can check that.

try {
    $response = $controller->postComment($request, $blog->slug);
    
    if ($response->isRedirect()) {
        echo "VERIFICATION SUCCESS: Controller returned redirect.\n";
        if (session('success')) echo "Session Success: " . session('success') . "\n";
        if (session('error')) echo "Session Error: " . session('error') . "\n";
    } else {
        echo "VERIFICATION FAILURE: Controller did not redirect.\n";
    }

} catch (\Exception $e) {
    echo "VERIFICATION ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}

// Verify comment in DB
$comment = \App\Models\PostComment::where('comment', 'Manual comment test from script.')->latest()->first();
if ($comment) {
    echo "VERIFICATION SUCCESS: Comment found in DB.\n";
    // Cleanup
    $comment->delete();
} else {
    echo "VERIFICATION FAILURE: Comment not found in DB.\n";
}
