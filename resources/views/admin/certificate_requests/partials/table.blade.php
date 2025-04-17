<div class="card-body px-0 pt-0 pb-2">
    @if($students->count())
      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Student Name</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Enrollment No</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Uploaded On</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Certificate</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($students as $submission)
              <tr>
                <td class="ps-4">
                  <span class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
                </td>
                <td class="ps-4">
                  <span class="text-secondary text-xs font-weight-bold">
                  {{ $submission->first_name . ' ' . $submission->last_name }}</span>
                </td>
                <td class="ps-4">
                  <span class="text-secondary text-xs font-weight-bold">{{ $submission->enrollment_no ?? 'N/A' }}</span>
                </td>
                <td class="ps-4">
                  <span class="text-secondary text-xs font-weight-bold">
                    {{ \Carbon\Carbon::parse($submission->submission_created_at)->format('d M Y') }}
                </span>
                
                </td>
                
                <td class="ps-4">
                  @if($submission->certificate_file)
                      <a href="{{ asset($submission->certificate_file) }}" target="_blank" class="btn btn-sm btn-success">
                          <i class="fas fa-eye me-1"></i> View
                      </a>
                  @endif

                </td>
                <td class="ps-4">
                  <span class="status-badge status-{{ strtolower($submission->status) }}">
                    {{ $submission->status }}
                  </span>
                </td>
                <td class="ps-4">
                  <div class="d-flex gap-2">
                    @if ($submission->status)
                    
                    @if($submission->status === 'Not Approved')
                      <form action="{{ route('admin.certificate_requests.approve', $submission->submission_id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">
                          <i class="fas fa-check me-1"></i> 
                        </button>
                      </form>
                      <form action="{{ route('admin.certificate_requests.reject', $submission->submission_id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">
                          <i class="fas fa-times me-1"></i> 
                        </button>
                      </form>
                    @elseif($submission->status === 'Approved')
                      <form action="{{ route('admin.certificate_requests.reject', $submission->submission_id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">
                          <i class="fas fa-times me-1"></i> 
                        </button>
                      </form>
                    @elseif($submission->status === 'Rejected')
                                                  
                    @endif
                    @else
                    <span class="badge bg-warning">Pending</span>
                @endif
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <nav aria-label="Page navigation">
                  {{ $students->withQueryString()->links() }}
                </nav>
            </div>
        </div>
    </div>
    @else
      <div class="text-center py-4">
        <i class="fas fa-file-alt text-muted" style="font-size: 3rem;"></i>
        <h6 class="mt-3 mb-2">No Certificates Found</h6>
        <p class="text-muted">No certificates found for the selected filters.</p>
      </div>
    @endif