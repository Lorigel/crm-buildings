@include('emails.template', [
    'message' => 'Nuova pratica creato. Accedi e carica la fattura.',
    'buttonText' => 'Visualizza pratica',
    'buttonLink' => env('APP_URL') . '/dashboard/contracts/' . $contract->id .'/details'
])