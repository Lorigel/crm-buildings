<x-app-layout>
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Panello</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Pratiche</a>
                        </li>
                        <li class="breadcrumb-item active">Profitto</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div>
        <p>Percentuale di profitto di General Contractor: {{$profit['general_contractor_percentage']}}%</p>
        <p>Profitto dell'agente:</p>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>{{__('Agente')}}</th>
                    <th>{{__('Ruolo')}}</th>
                    <th>{{__('Percentuale')}}</th>
                    <th>{{__('Importo')}}</th>
                </tr>
                <tr>
                    <td><b>{{$user->name . ' ' . $user->surname}}</b></td>
                    <td><b>{{$user->getRelationValue('role')->name}}</b></td>
                    <td><b>{{$profit['agent_percentage']}}%</b></td>
                    <td><b>{{$profit['agent_profit']}}€</b></td>
                </tr>
            </table>
        </div>

    </div>
    
</x-app-layout>