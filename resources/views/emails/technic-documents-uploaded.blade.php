@include('emails.template', [
    'message' => 'Il tecnico ha caricato i documenti necessari. Pratica è in attesa di approvazione',
    'buttonText' => 'Visualizza pratica',
    'buttonLink' => env('APP_URL') . '/dashboard/contracts/' . $contract->id .'/details'
])
