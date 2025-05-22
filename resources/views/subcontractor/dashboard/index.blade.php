@extends('layouts.subcontractor')
@section('title')
    Sub Contractor
@endsection

@section('content')
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="title">
                <h4>{{ $subContractor->contact_name }}</h4>
                <p>We are glad to see you again!</p>
            </div>
        </div>

        {{-- <div class="col-md-6">
            <div class="breadcrumb">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Dashboard</a></li>
                </ul>
            </div>
        </div> --}}
    </div>

    <section class="block-item-sec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="block-item">
                        <div class="text">
                            <p>Project Unlock</p>
                            <h3>{{ $unlockedProjects }}</h3>
                        </div>

                        <div class="icon">
                            <img src="{{ asset('assets/images/d-1.png') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="block-item">
                        <div class="text">
                            <p>Project Complete</p>
                            <h3>{{ $completedProjects }}</h3>
                        </div>

                        <div class="icon">
                            <img src="{{ asset('assets/images/d-2.png') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="block-item">
                        <div class="text">
                            <p>Reviews</p>
                            <h3>{{ $reviewedProjects }}</h3>
                        </div>

                        <div class="icon">
                            <img src="{{ asset('assets/images/d-3.png') }}" alt="" class="img-fluid">

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="chart-sec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="top-bar">
                        <h6><img src="{{ asset('assets/images/develop.png') }}" alt=""> Your Profile Views</h6>
                        <div class="dropdown">
                            <a class="btn dropdown-toggle" href="javascript:void()" role="button" id="dropdownMenuLink"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                @if ($period === '1_month')
                                    Last 1 Month
                                @elseif($period === '3_months')
                                    Last 3 Months
                                @elseif($period === '1_year')
                                    Last 1 Year
                                @else
                                    Last 6 Months
                                @endif
                            </a>

                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item period-link" data-period="1_month" href="javascript:void(0)">Last 1
                                        Month</a></li>
                                <li><a class="dropdown-item period-link" data-period="3_months" href="javascript:void(0)">Last 3
                                        Months</a></li>
                                <li><a class="dropdown-item period-link" data-period="1_year" href="javascript:void(0)">Last 1 Year</a>
                                </li>
                                <li><a class="dropdown-item period-link" data-period="6_months" href="javascript:void(0)">Last 6
                                        Months</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="chart-image">
                            <canvas id="profileViewsChart" height="100"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="note">
                        {{-- <h5>Notes</h5>


                        <div class="inner-box">
                            <p>Meeting with candidate at 3pm
                                who applied for Bilingual Event
                                Support Specialist</p>

                            <div class="wrapper">
                                <button>High Priority</button>

                                <ul>
                                    <li><i class="fa-regular fa-pen-to-square"></i></li>
                                    <li><i class="fa-solid fa-trash"></i></li>
                                </ul>
                            </div>
                        </div> --}}


                        <div class="inner-box">
                            <p>Add Your Sticky Notes</p>
                            <div class="link">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Note </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Note</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" id="edit_form"
                            action="{{ route('subcontractor.note.store') }}">
                            @csrf
                            <input type="hidden" name="id" id="edit_id">
                            <div class="form-group mb-3 @error('project_name') is-invalid @enderror">
                                <label for="name">Note</label>
                                <textarea class="form-control" id="editname" name="note" rows="10" cols="12"></textarea>
                                @error('project_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save changes">
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="notifications-order-sec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="notification">
                        <div class="title">
                            <h6>Notes</h6>

                            <div class="icon"> <img src="{{ asset('assets/images/notification.png') }}"
                                    alt="">
                            </div>
                        </div>

                        <ul>
                            @foreach ($notes as $note)
                                <li>
                                    <p>{{ $note->note }}</p>
                                </li>
                            @endforeach
                            {{-- <li>
                                <p>Gilber Allanis placed a bid on your <a href="#">iOS App
                                        Development</a></p>
                            </li>

                            <li>
                                <p>Your job listing <a href="#">Full Stack Software
                                        Engineer</a> is expiring</p>
                            </li>
                            <li>
                                <p>Sindy Forrest applied for a job <a href="#">Full Stack
                                        Software Engineer</a></p>
                            </li>
                            <li>
                                <p>David Peterson left you a <small>5.0</small> rating
                                    after finishing <a href="#">Logo Design</a> task</p>
                            </li> --}}
                        </ul>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="order">
                        <div class="title">
                            <h6><img src="{{ asset('assets/images/order.png') }}" alt="" class="img-fluid mx-2">
                                Transaction</h6>
                        </div>


                        @foreach ($userSubcriptions as $userSubcription)
                            <div class="box-item">
                                <h5>{{ $userSubcription->plan->name }}</h5>
                                <span class="success">paid</span>

                                <ul>
                                    <li>Order: #{!! Str::limit($userSubcription->stripe_session_id, 10, ' ...') !!}</li>
                                    <li>Date: {{ \Carbon\Carbon::parse($userSubcription->created_at)->format('d/m/Y') }}
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                        @foreach ($userAdditionalPays as $userAdditionalPay)
                            <div class="box-item">
                                <h5 class="text-capitalize">{{ str_replace('_', ' ', $userAdditionalPay->payable_type) }}
                                </h5>
                                <span class="success">paid</span>

                                <ul>
                                    <li>Order: #{!! Str::limit($userAdditionalPay->stripe_session_id, 10, ' ...') !!}</li>
                                    <li>Date: {{ \Carbon\Carbon::parse($userAdditionalPay->created_at)->format('d/m/Y') }}
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                        {{-- <div class="box-item">
                  <h5>Professional Plan</h5>
                  <span class="success">paid</span>

                  <ul>
                     <li>Order: #326</li>
                     <li>Date: 12/08/2019</li>
                  </ul>
               </div>
               <div class="box-item">
                  <h5>Professional Plan</h5>
                  <span class="success">paid</span>

                  <ul>
                     <li>Order: #326</li>
                     <li>Date: 12/08/2019</li>
                  </ul>
               </div>
               <div class="box-item">
                  <h5>Professional Plan</h5>
                  <span class="success">paid</span>

                  <ul>
                     <li>Order: #326</li>
                     <li>Date: 12/08/2019</li>
                  </ul>
               </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            console.log('DOM fully loaded and parsed');


            // 1. Build the initial chart with the data already injected by Blade
            const ctx = document.getElementById('profileViewsChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels), // initial data
                    datasets: [{
                        label: 'Profile Views',
                        data: @json($chartData),
                        fill: true,
                        backgroundColor: 'rgba(54,162,235,.2)',
                        borderColor: 'rgba(54,162,235,1)',
                        tension: .4,
                        pointBackgroundColor: 'rgba(54,162,235,1)'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // 2. Intercept clicks on the dropdown items
            document.querySelectorAll('.period-link').forEach(link => {
                link.addEventListener('click', e => {
                    e.preventDefault();
                    const period = e.target.dataset.period;

                    // Update dropdown button text
                    document.getElementById('dropdownMenuLink').textContent =
                        e.target.textContent;

                    // Fetch new data
                    fetch(`{{ route('subcontractor.dashboard.profileViewsDatas') }}?period=${period}`)
                        .then(res => res.json())
                        .then(({
                            labels,
                            data
                        }) => {
                            chart.data.labels = labels;
                            chart.data.datasets[0].data = data;
                            chart.update();
                        })
                        .catch(console.error);
                });
            });

        });
    </script>
@endsection
