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
              <li class="breadcrumb-item active">Organigramma</li>
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
    
    </div>
    
      </div>
    </div>
      <script src="https://balkan.app/js/orgchart.js"></script>

    <div id="tree"/>
<script>

        function pdf(nodeId) {
            chart.exportPDF({filename: "OrganigrammaExport.pdf", expandChildren: true, nodeId: nodeId});
        }
        function png(nodeId) {
            chart.exportPNG({filename: "MyFileName.png", expandChildren: true, nodeId: nodeId});
        }
        function svg(nodeId) {
            chart.exportSVG({filename: "MyFileName.svg", expandChildren: true, nodeId: nodeId});
        }

var chart = new OrgChart(document.getElementById("tree"), {
		    showXScroll: OrgChart.scroll.visible, 
        showYScroll: OrgChart.scroll.visible, 
        mouseScrool: OrgChart.action.zoom,
        layout: OrgChart.mixed,

        enableSearch: true,   
        nodeBinding: {
            field_0: "name",
            field_1: "role",
            field_2: "id"

        },
        nodes: [
          @foreach($users->sortBy('role') as $user)
            { id: {{$user->id}}, pid:"{{$user->assigned_to}}", name: "{{$user->name }} {{$user->surname }}", role: "{{$user->getRelationValue('role')->name}}" },
          @endforeach  
            
        ],
	menu: {
                export_pdf: {
                    text: "Export PDF",
                    icon: OrgChart.icon.pdf(24, 24, "#7A7A7A"),
                    onClick: pdf
                },
                export_png: {
                    text: "Export PNG",
                    icon: OrgChart.icon.png(24, 24, "#7A7A7A"),
                    onClick: png
                },
                export_svg: {
                    text: "Export SVG",
                    icon: OrgChart.icon.svg(24, 24, "#7A7A7A"),
                    onClick: svg
                }
            },
            nodeMenu: {
                export_pdf: {
                    text: "Export PDF",
                    icon: OrgChart.icon.pdf(24, 24, "#7A7A7A"),
                    onClick: pdf
                },
                export_png: {
                    text: "Export PNG",
                    icon: OrgChart.icon.png(24, 24, "#7A7A7A"),
                    onClick: png
                },
                export_svg: {
                    text: "Export SVG",
                    icon: OrgChart.icon.svg(24, 24, "#7A7A7A"),
                    onClick: svg
                }
            }
    }); </script>
    <!-- end row -->
    <!-- end row -->
</x-app-layout>
