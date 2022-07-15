@include('emails.template', [
    'message' => 'Praticha e approvato e in stato di lavorazione.',
    'buttonText' => 'Visualizza pratica',
    'buttonLink' => env('APP_URL') . '/dashboard/contracts/' . $contract->id .'/details'
])