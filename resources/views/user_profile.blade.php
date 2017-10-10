@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <section>
                <div class="wizard">
                    <div class="wizard-inner">
                        <div class="connecting-line"></div>
                        <ul class="nav nav-tabs" role="tablist">

                            <li role="presentation" class="active">
                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-folder-open"></i>
                            </span>
                                </a>
                            </li>

                            <li role="presentation" class="disabled">
                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </span>
                                </a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-picture"></i>
                            </span>
                                </a>
                            </li>

                            <li role="presentation" class="disabled">
                                <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-ok"></i>
                            </span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <form action="{{ url('/jobs_page') }}" class="horizontal-form" method="post">
                        <div class="form-body">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">


                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputFirstName">First Name</label>
                                    <input type="text" class="form-control" id="firstname" placeholder="First Name">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputLastName">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" placeholder="Last Name">
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputPhone">Phone</label>
                                    <input type="text" class="form-control" id="phone" placeholder="Phone">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputCity">City</label>
                                    <input type="text" class="form-control" id="city" placeholder="City">
                                </div>
                            </div>
                            <!--/row-->

                            <div class="form-actions right">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green"><i class="fa fa-angle-double-right"></i> Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
@endsection
