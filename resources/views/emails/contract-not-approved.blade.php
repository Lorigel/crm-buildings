@include('emails.template', [
    'message' => 'Pratica non non è approvato',
    'buttonText' => 'Visualizza pratica',
    'buttonLink' => env('APP_URL') . '/dashboard/contracts/' . $contract->id .'/details'
])