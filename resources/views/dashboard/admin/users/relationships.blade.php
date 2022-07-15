<x-app-layout>
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
      <div> 
        @if($users)
            @dump($users)
        @endif  
    
      </div>
    </div>
      <script src="https://balkan.app/js/orgchart.js"></script>

    <div id="tree"/>
<script> 
    var chart = new OrgChart(document.getElementById("tree"), {
        nodeBinding: {
            field_0: "name"
        },
        nodes: [
            { id: 1, name: "Amber McKenzie" },
            { id: 2, pid: 1, name: "Ava Field" },
            { id: 3, pid: 1, name: "Peter Stevens" }
        ]
    });
    </script>
 
    <!-- end row -->
    <!-- end row -->
</x-app-layout>