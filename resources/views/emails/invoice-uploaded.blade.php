@include('emails.template', [
    'message' => 'Azienda ha caricato la fattura. Pratica è in attesa di approvazione.',
    'buttonText' => 'Visualizza pratica',
    'buttonLink' => env('APP_URL') . '/dashboard/contracts/' . $contract->id .'/details'
])