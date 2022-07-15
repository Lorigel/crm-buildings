<x-app-layout pageName="Contract">
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
                        <li class="breadcrumb-item">Panello</li>
                        <li class="breadcrumb-item active">Pratica - Dettagli</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <!-- end row -->
    <div class="row">
        <!-- <a href="{{route('users.import')}}">{{__('Importa utente')}}</a> -->
    </div>
    <div class="row">
        <div class="col-sm-6"> 
            @if($contract) 
            <div class="ml-3">
                <h2>{{__('Pratica')}}</h2>

                <hr class="my-3">

               

            </div>
            <div>
<div class="progress" style="height:24px;background-color: #c6d7df;margin:auto;max-width: 100%;">
  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%;height:24px;"></div>
</div><br>
                <table class="table-fill" style="max-width:100%;">
                  <thead>
                    <tr>
                      <th class="text-left">Dettagli della pratica </th>
                     <th class="text-left" style="font-weight:400!important;"> @if(Auth::user()->canApproveContract())
                    <a style="color:#69baff;" onMouseOver="this.style.color='#146ab3'"
   onMouseOut="this.style.color='#69baff'" href="{{route('contract.edit', ['id' => $contract->id])}}"><b>Modifica Pratica</b> <i class="ri-edit-box-line"></i></a>
                @endif</th>
                    </tr>
                  </thead>
                  <tbody class="table-hover">
                    <tr>
                      <td class="text-left">Committente</td>
                      <td class="text-left">{{$contract->client_name . ' ' . $contract->client_name}}</td>
                    </tr>
                    <tr>
                      <td class="text-left">Prodotto</td>
                      <td class="text-left">{{$contract->getRelationValue('product')->name}}</td>
                    </tr>
                    <tr>
                      <td class="text-left">Data</td>
                      <td class="text-left">{{format_date($contract->created_at)}}</td>
                    </tr>
                    <tr>
                      <td class="text-left">Importo</td>
                      <td class="text-left">{{format_price($contract->amount)}}</td>
                    </tr>
                    <tr>
                      <td class="text-left">Indirizzo</td>
                      <td class="text-left">{{$contract->address}}</td>
                    </tr>

                    @if($contract->note)
                        <tr>
                            <td class="text-left">Note</td>
                            <td class="text-left">{{$contract->client_name . ' ' . $contract->client_name}}</td>
                        
                        </tr>
                    @endif

                    @if($technic)
                    <tr>
                            <td class="text-left">Tecnico</td>
                            <td class="text-left">{{$technic->name . ' ' . $technic->surname}}</td>
                    </tr>
                   
                    @endif

                    @if($company)
                      <tr>
                            <td class="text-left">Azienda</td>
                            <td class="text-left">{{$company->name . ' ' . $company->surname}}</td>
                 </tr>
                    @endif    
                        <tr>
                            <td class="text-left">Stato</td>
                            <td class="text-left">{{$contract->status ? App\Models\Contract::STATUSES[$contract->status] : ''}}</td>
                        
                        </tr>                
                  </tbody>
                </table>

               <hr class=m-5>
             
                
                
            </div>

            

            @if($contract->hasStatus('open') && Auth::user()->hasRole('technic')) 
                @include('dashboard.contracts.edit.technic-documents')
            @endif

            @if($contract->hasStatus('in_approval') && Auth::user()->hasRole('company') && !$contract->invoice)
                @include('dashboard.contracts.edit.invoice')
            @endif

            @if($invoice)
                <div>
                    <p class="mt-4 mb-2">Fattura</p>
                    <p>
                        <a download href="{{config('app.url') . '/storage/invoices' . $invoice->pdf}}">{{__('Scarica fattura')}}</a>
                    </p>
                </div>
            @endif

            @if(($contract->hasStatus('processing') || $contract->hasStatus('finished')) && Auth::user()->canViewProfitDetails())
                <hr>
                <div class="py-2">
                    <p><a href="{{route('contract.profit',['id' => $contract->id])}}">Visualizza i dettagli del profitto</a></p>
                </div>
            @endif
        @endif
        </div>
        <div class="col-sm-6">
            @if($documents)
                <div>
                    <h2>Documenti</h2>
                    <hr class="my-3">
                   <div class="progress" style="height:24px;background-color: #c6d7df;margin:auto;max-width: 100%;">
  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%;height:24px;"></div>
</div><br>

                    <div class="">
                         <table class="table-fill" style="max-width:100%;">
                            <tbody>
                             <thead>
                 <tr>
                      <th class="text-left">Documento</th>
                     <th class="text-left" style="font-weight:400!important;">                     <a style="color:#69baff;" ><b>Scarica</b></a>
                </th>
                    </tr>
                  </thead>
                    @foreach($documents as $document)
                           
                                <tr>
                                    <td><b>{{$document->title}}</b></td>
                                    <td style="text-align:center;padding:10px!important;"><b><a style="text-align:center;"download href="{{config('app.url') . '/storage/' . $document->pdf}}"><i style="font-size:31px;color:#69baff;" onmouseover="this.style.color='#146ab3'" onmouseout="this.style.color='#69baff'" class="ri-file-download-line"></i></b></td>

                                </tr>



                        </div>
                    @endforeach
                </tbody>    
                </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- end row -->
    <!-- end row -->
</x-app-layout>