@include('emails.template', [
    'name' => $user->name,
    'message' => 'Sei registrato in Ecosisma-bonus. Fare clic sul pulsante per impostare la password.',
    'buttonText' => 'Impostare la password',
    'buttonLink' => env('APP_URL') . '/reset-password-from-invite/?t=' . $token
])