<x-app-layout pageName="Contract">
        <div class="container-fluid">
          <!-- start page title -->
          <div class="row">
            <div class="col-12">
              <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Panello</h4>
                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                      <a href="javascript: void(0);">AMSZEROAD</a>
                    </li>
                    <li class="breadcrumb-item active">Crea Pratica</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- end page title -->
          <!-- end row -->
          <div class="row">
            <!-- <a href="{{route('users.import')}}">{{__('Importa utente')}}</a> --> 
        <div class="col-sm-8">
        <form method="POST" data-action="{{ route('contract.create') }}" data-form="contract-create" data-contract-form>
          
            @csrf
            
            @include('dashboard.contracts.create.client-data')

            @include('dashboard.contracts.create.products')

            @include('dashboard.contracts.create.details', ['technics' => $technics, 'companies' => $companies])

            @include('dashboard.contracts.create.condominiums')

            @include('dashboard.contracts.create.documents', ['options' => config('document-type.agent')])
            <br><hr><br>

            <p class="js-response"></p>
            <x-button class="btn btn-primary">{{__('Crea Pratica')}}</x-button>
        </form>
</x-app-layout>
