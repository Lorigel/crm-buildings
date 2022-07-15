<x-app-layout>
        <div class="container-fluid">
          <!-- start page title -->
          <div class="row">
            <div class="col-12">
              <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Panello</h4>
                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                      <a href="javascript: void(0);">Ecosisma Bonus</a>
                    </li>
                    <li class="breadcrumb-item active">Panello</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- end page title -->
          <!-- end row -->
          <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div class="flex-1 overflow-hidden">
                                        <p class="text-truncate font-size-14 mb-2">Numero di pratiche</p>
                                        <h4 class="mb-0">{{$total}}</h4>
                                    </div>
                                    <div class="text-primary ms-auto">
                                        <ri-stack-line font-size-24></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                      <div class="card">
                          <div class="card-body">
                              <div class="d-flex justify-content-between">
                                  <div class="flex-1 overflow-hidden">
                                      <p class="text-truncate font-size-14 mb-2">Pratiche in corso</p>
                                      <h4 class="mb-0">{{$open}}</h4>
                                  </div>
                                  <div class="text-primary ms-auto">
                                      <i class="ri-stack-line font-size-24"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div class="flex-1 overflow-hidden">
                                        <p class="text-truncate font-size-14 mb-2">Pratiche non approvato</p>
                                        <h4 class="mb-0">{{$not_approved}}</h4>
                                    </div>
                                    <div class="text-primary ms-auto">
                                        <i class="ri-stack-line font-size-24"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                      <div class="card">
                          <div class="card-body">
                              <div class="d-flex justify-content-between">
                                  <div class="flex-1 overflow-hidden">
                                      <p class="text-truncate font-size-14 mb-2">Pratiche chiusa</p>
                                      <h4 class="mb-0">{{$finished}}</h4>
                                  </div>
                                  <div class="text-primary ms-auto">
                                      <i class="ri-stack-line font-size-24"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
                <!-- end row -->
                  

              
            </div>

           
        </div>
         
          <!-- end row -->
          <!-- end row -->
        </div>
        <!-- container-fluid -->
</x-app-layout>