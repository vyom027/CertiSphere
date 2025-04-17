<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  @include('admin.components.links')
  <title>
    Department List | LJKU
  </title>
  @include('admin.components.links')  
</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-dark position-absolute w-100"></div>
  {{--  --}}
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
  @include('admin.components.sidebar')
    </aside>
    <main class="main-content position-relative border-radius-lg ">

    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
        <div class="container-fluid py-1 px-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
              <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
              <li class="breadcrumb-item text-sm text-white active" aria-current="page">Department</li>
            </ol>
            <h6 class="font-weight-bolder text-white mb-0">Department List</h6>
          </nav>
          <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
              <div class="input-group">
                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                <input type="text" class="form-control" placeholder="Type here...">
              </div>
            </div>
            <ul class="navbar-nav  justify-content-end">
              <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                  <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line bg-white"></i>
                    <i class="sidenav-toggler-line bg-white"></i>
                    <i class="sidenav-toggler-line bg-white"></i>
                  </div>
                </a>
              </li>
              <li class="nav-item px-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-white p-0">
                  <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                </a>
              </li>
                </ul>
          </div>
        </div>
      </nav>
      <div class="container-fluid py-4 "  >
        <div class="row">
          <div class="col-12 ">
            <div class="card mb-4">
              <div class="card-header d-flex justify-content-between align-items-center pb-0">
                <h6>Department List</h6>

                <a href="{{ route('department.create') }}" class="btn btn-primary btn-sm">Add Department</a>
              </div>
              <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Index</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Department Name</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                        <th class="text-secondary opacity-7"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @php $i = 1; @endphp
                      @foreach($departments as $department)
                      <tr>
                        
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div>
                                <p class="text-s font-weight-bold mb-0"> &nbsp;&nbsp;&nbsp;{{$i}}</p>
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                              {{-- <h4 class="mb-0 text-sm">{{ $batch->deprtment->name }}</h4> --}}
                            </div>
                          </div>
                        </td>
                        
                        <td class="align-middle text-sm">
                            <p class="text-s font-weight-bold mb-0">{{ $department->name }}</p> 
                        </td>
                        <td class="align-middle text-center">
                          <a href="{{ route('department.edit', ['id' => $department->dept_id]) }}" class="btn btn-primary btn-sm">Edit</a>
                          <form action="{{ route('department.destroy', ['id' => $department->dept_id]) }}" method="POST" style="display:inline;">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this batch?')">Delete</button>
                          </form>
                      </td>
                       
                        @php $i++; @endphp
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
</body>
</html>