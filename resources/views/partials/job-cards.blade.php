@foreach($jobs as $job)
    <div class="col-md-6 col-lg-4 mb-4 job-card-item">
        <div class="card h-100 shadow-sm border-left-primary">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title font-weight-bold mb-0 text-primary">{{ $job->title }}</h5>
                    <span class="badge badge-info">{{ ucfirst($job->type) }}</span>
                </div>
                
                <p class="text-muted small mb-2">
                    <i class="fas fa-building mr-1"></i> {{ $job->company->name ?? 'Company' }} &bull; 
                    <i class="fas fa-map-marker-alt mr-1"></i> {{ $job->location }}
                </p>

                <p class="card-text text-secondary flex-grow-1">
                    {{ Str::limit($job->description, 120) }}
                </p>

                <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center">
                    <div class="small text-muted">
                        <div><i class="far fa-clock mr-1"></i> Posted {{ $job->created_at->diffForHumans() }}</div>
                        @if($job->deadline)
                            <div class="text-danger font-weight-bold mt-1">
                                <i class="far fa-calendar-alt mr-1"></i> Deadline: {{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}
                            </div>
                        @endif
                    </div>

                    @guest
                        <button type="button" class="btn btn-sm btn-outline-primary px-3 rounded-pill" data-toggle="modal" data-target="#guestLoginModal">
                            <i class="fas fa-paper-plane mr-1"></i> Apply Now
                        </button>
                    @endguest

                    @auth
                        @if(in_array($job->id, $appliedJobIds ?? []))
                            <button class="btn btn-sm btn-success px-3 rounded-pill" disabled>
                                <i class="fas fa-check-circle mr-1"></i> Applied
                            </button>
                        @else
                            <button type="button" class="btn btn-sm btn-outline-primary px-3 rounded-pill btn-open-apply" 
                                    data-job-id="{{ $job->id }}" 
                                    data-job-title="{{ $job->title }}">
                                <i class="fas fa-paper-plane mr-1"></i> Apply Now
                            </button>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endforeach