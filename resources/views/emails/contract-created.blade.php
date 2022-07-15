@include('emails.template', [
    'message' => 'Nuova pratica creato da '. $user->name . ' ' . $user->surname,
    'buttonText' => 'Visualizza pratica',
    'buttonLink' => env('APP_URL') . '/dashboard/contracts/' . $contract->id .'/details'
])