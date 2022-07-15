<x-app-layout>
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Dashboard</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">AMSZEROAD</a>
                        </li>
                        <li class="breadcrumb-item active">Lista Pratiche</li>
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
        <div> @if(!$contracts->isEmpty()) <h2>{{__('Pratiche')}}</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <tr>
                        <th>{{__('ID')}}</th>
                        <th>{{__('Agente')}}</th>
                        <th>{{__('Prodotto')}}</th>
                        <th>{{__('Importo')}}</th>
                        <th>{{__('Stato')}}</th>
                        <th>{{__('Data')}}</th>
                        <th></th>
                    </tr>
                    @foreach($contracts as $contract)
                    <tr>
                        <td><b>{{$contract->id}}</b></td>
                        <td><b>{{$contract->user->name . ' ' . $contract->user->surname}}</b></td>
                        <td><b>{{$contract->getRelationValue('product')->name}}</b></td>
                        <td><b>{{format_price($contract->amount)}}</b></td>
                        <td><b>{{$contract->status ? App\Models\Contract::STATUSES[$contract->status] : ''}}</b></td>
                        <td><b>{{format_date($contract->created_at)}}</b></td>
                        <td>
                            <a href="{{route('contract.single', ['id' => $contract->id])}}"><i class="ri-eye-line mr-4"></i></a>
                            @if(Auth::user()->canApproveContract())
                                <a href="{{route('contract.edit', ['id' => $contract->id])}}"><i class="ri-pencil-line"></i></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div> @else <p>{{__('Nessun pratica')}}</p> @endif
        </div>
    </div>
    <!-- end row -->
    <!-- end row -->
</x-app-layout>