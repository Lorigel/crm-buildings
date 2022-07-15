@include('emails.template', [
    'name' => $user->name,
    'message' => 'Il tuo account è attivato. ',
    'buttonText' => 'Login',
    'buttonLink' => env('APP_URL')
])