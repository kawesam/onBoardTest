@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div id="container" style="width:100%; height:400px;">


            </div>

        </div>
    </div>

    <script>
        $(function () {
            var $data = $.parseJSON('{!! $reports !!}');
            //.log($data);

            var weekData = [];

            $.each($data.weeks, function (key, item) {
                weekData.push({
                    name: 'Week '+ item,
                    data: [$data.accounts[key], $data.activations[key],$data.approvals[key],$data.experiences[key],$data.freelancers[key],$data.jobs[key],
                        $data.waitingApps[key] ]
                });
            });

            console.log(weekData);

            var myChart = Highcharts.chart('container', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'User Onboarding'
                },
                xAxis: {
                    categories: ['create account', 'activate', 'profile','jobs','experience','freelancer','waitingApp','Approval']
                },
                yAxis: {
                    title: {
                        text: 'Users'
                    }
                },
                series: weekData
            });
        });
    </script>
@endsection


