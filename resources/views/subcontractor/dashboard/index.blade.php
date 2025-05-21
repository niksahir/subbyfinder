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

        <div class="col-md-6">
            <div class="breadcrumb">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Dashboard</a></li>
                </ul>
            </div>
        </div>
    </div>

    <section class="block-item-sec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="block-item">
                        <div class="text">
                            <p>Task Bids Won</p>
                            <h3>22</h3>
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
                            <h3>4</h3>
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
                            <h3>28</h3>
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
                        <h6><i> </i> Your Profile Views</h6>
                        <div class="dropdown">
                            <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Last 6 Months
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href="#">Last 1 Months</a></li>
                                <li><a class="dropdown-item" href="#">Last 3 Months</a></li>
                                <li><a class="dropdown-item" href="#">last 1 year</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="chart-image">
                            <img src="{{ asset('assets/images/chart.png') }}" alt="" class="img-fluid">
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
                        <form method="POST" enctype="multipart/form-data" id="edit_form">
                            @csrf
                            {{-- @method('PUT') --}}
                            <input type="hidden" name="id" id="edit_id">
                            <div class="form-group mb-3 @error('project_name') is-invalid @enderror">
                                <label for="name">Note</label>
                                <textarea class="form-control" id="editname" name="project_name" rows="10" cols="12"></textarea>
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
                            <h6>Notifications</h6>

                            <div class="icon"> <img src="{{ asset('assets/images/notification.png') }}" alt="">
                            </div>
                        </div>

                        <ul>
                            <li><img src="" alt="">
                                <p>Michael Shannah applied for a job <a href="#">Full
                                        Stack Software</a></p>
                            </li>
                            <li>
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
                            </li>
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
                                    <li>Order: #{{ $userSubcription->id }}</li>
                                    <li>Date: {{ \Carbon\Carbon::parse($userSubcription->created_at)->format('d/m/Y') }}
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
