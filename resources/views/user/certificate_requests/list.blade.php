<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>My Certificates | LJKU</title>

        <!-- CSS FILES -->        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
        <link href="{{ asset('student/css/bootstrap.min.css')}}" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="{{ asset('student/css/bootstrap-icons.css')}}" rel="stylesheet">
        <link href="{{ asset('student/css/templatemo-topic-listing.css')}}" rel="stylesheet">

        <style>
            .card {
                border-radius: 8px;
                border: none;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            }
            .certificate-table th {
                font-weight: 600;
                color: #495057;
            }
            .certificate-table td {
                vertical-align: middle;
            }
            .page-header {
                border-bottom: 1px solid #dee2e6;
                padding-bottom: 1rem;
                margin-bottom: 2rem;
            }
            .status-badge {
                padding: 0.35rem 0.65rem;
                border-radius: 6px;
                font-size: 0.75rem;
                font-weight: 600;
            }
            .status-approved {
                background-color: #d4edda;
                color: #155724;
            }
            .status-pending {
                background-color: #fff3cd;
                color: #856404;
            }
            .status-rejected {
                background-color: #f8d7da;
                color: #721c24;
            }
        </style>
    </head>
    
    <body id="top">
        @include('user.components.navbar')

        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        <div class="container py-5" style="margin-top: 100px;">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h2 class="page-header">My Certificates</h2>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('certificate-requests.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Requests
                    </a>
                </div>
            </div>

            @if($submissions->isEmpty())
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="bi bi-file-earmark-x text-muted" style="font-size: 3rem;"></i>
                                <h4 class="mt-3 mb-2">No Certificates Found</h4>
                                <p class="text-muted">You haven't uploaded any certificates yet.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table certificate-table mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="ps-4">Course Name</th>
                                                <th>Status</th>
                                                <th>Uploaded On</th>
                                                <th class="text-end pe-4">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($submissions as $submission)
                                                <tr>
                                                    <td class="ps-4 fw-medium">{{ $submission->request->course_name ?? 'N/A' }}</td>
                                                    <td>
                                                        @if($submission->status === 'Not Approved')
                                                            <span class="status-badge status-pending">Pending</span>
                                                        @elseif($submission->status === 'Approved')
                                                            <span class="status-badge status-approved">Approved</span>
                                                        @else
                                                            <span class="status-badge status-rejected">Rejected</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $submission->created_at->format('d M, Y') }}</td>
                                                    <td class="text-end pe-4">
                                                        @if ($submission->status === 'Rejected')
                                                        <button 
                                                            type="button"
                                                            class="btn btn-sm btn-outline-warning"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#uploadModal"
                                                            data-request-id="{{ $submission->request->id }}"
                                                            data-course-name="{{ $submission->request->course_name }}">
                                                            <i class="bi bi-upload me-1"></i> Update
                                                        </button>
                                                    @elseif($submission->certificate_file)
                                                        <a href="{{ asset($submission->certificate_file) }}" target="_blank" class="btn btn-sm btn-success">
                                                            <i class="bi bi-eye me-1"></i> View
                                                        </a>
                                                    @endif
                                                    
                                                    </td>
                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <form action="{{ route('student.certificate.upload') }}" method="POST" enctype="multipart/form-data" class="modal-content">
                                @csrf
                                <div class="modal-header">
                                  <h5 class="modal-title" id="uploadModalLabel">Upload Certificate</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                
                                <div class="modal-body">
                                  <input type="hidden" name="certificate_request_id" id="modalRequestId" value="{{ old('certificate_request_id')   }}">
                                  <div class="mb-3">
                                    <label for="courseName" class="form-label">Course Name</label>
                                    <input type="text" class="form-control" id="courseName" name="course_name" value="{{ old('course_name')  }}" readonly>
                                  </div>
                          
                                  <div class="mb-3">
                                    <label for="certificateFile" class="form-label">Certificate (PDF Only)</label>
                                    <input type="file" class="form-control" name="certificate_file" id="certificateFile" accept="application/pdf" required>
                                    @error('certificate_file')
                                      <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Maximum file size: 100KB. <a href="https://bigpdf.11zon.com/en/compress-pdf/compress-pdf-to-100kb.php" target="_blank" class="text-primary">Use this website to compress your PDF</a>.</small>
                                  </div>
                                  @if(session('error'))
                                  <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                      {{ session('error') }}
                                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>
                                  @endif
                      
                                  @if($errors->any())
                                  <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                      <ul class="mb-0">
                                          @foreach($errors->all() as $error)
                                          <li>{{ $error }}</li>
                                          @endforeach
                                      </ul>
                                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                  <script>
                                      // Automatically open modal if there are errors
                                      document.addEventListener('DOMContentLoaded', function() {
                                          new bootstrap.Modal(document.getElementById('uploadModal')).show();
                                      });
                                  </script>
                                  @endif
                                </div>

                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary">Upload</button>
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                              </form>
                            </div>
                          </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $submissions->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @include('user.components.footer')

        <script src="{{ asset('student/js/jquery.min.js')}}"></script>
        <script src="{{ asset('student/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{ asset('student/js/jquery.sticky.js')}}"></script>
        <script src="{{ asset('student/js/click-scroll.js')}}"></script>
        <script src="{{ asset('student/js/custom.js')}}"></script>
        <script>
            // Add CSRF token to all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const uploadModal = document.getElementById('uploadModal');
            uploadModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                const courseName = button.getAttribute('data-course-name');
                const requestId = button.getAttribute('data-request-id');

                document.getElementById('courseName').value = courseName;
                document.getElementById('modalRequestId').value = requestId;
            });

            // Handle form submission
            $('form').on('submit', function() {
                if (!$('input[name="_token"]').val()) {
                    location.reload();
                    return false;
                }
            });
        </script>

    </body>

</html>
