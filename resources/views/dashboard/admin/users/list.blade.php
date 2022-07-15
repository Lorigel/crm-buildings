<x-app-layout pageName="User">
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
              <li class="breadcrumb-item active">Utenti</li>
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
      <div class="col-xs-12 col-sm-12 col-md-8"> @if(!$users->isEmpty()) <h2>Lista di Agenti</h2>
        <div class="table-responsive"><table class="table table-striped">
          <tr>
            <th>{{__('Nome')}}</th>
            <th>{{__('Cognome')}}</th>
            <th>{{__('Ruolo')}}</th>
            <th>{{__('Email')}}</th>
            <th>{{__('Verificato')}}</th>
            <th colspan="2">{{__('Opzioni')}}</th>
            
          </tr> @foreach($users as $user) <tr>
            <td>
              <b>{{$user->name}}</b>
            </td>
            <td>
              <b>{{$user->surname}}</b>
            </td>
            <td>{{$user->getRelationValue('role')->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->account_verified_at ? 'si' : 'no'}}</td>
            <td>
              <a href="users/{{$user->id}}/edit">Modifica</a>
            </td>
            <td>
                <a class="user-delete" data-user="{{$user->id}}" style="cursor: pointer"><i class="ri-delete-bin-line font-size-18"></i></a>
            </td>
          </tr> @endforeach
        </table></div> @else <p>{{__('Nessun utenti')}}</p> @endif
      </div>
    </div>
    <!-- end row -->
    <!-- end row -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Elimina utente</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Sei sicuro di voler eliminare questo utente?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiusi</button>
            <button type="button" class="btn btn-primary submit">Elimina</button>
          </div>
        </div>
      </div>
    </div>
</x-app-layout>
