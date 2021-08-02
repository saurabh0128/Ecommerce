@extends('backend.layout.app')

@section('title')
    Admin Dashboard
@endsection


@section('css')
    <!-- Slick -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/libs/slick/slick.css')}}" type="text/css">  

    <!-- Rating -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/libs/rating/rating.min.css')}}" type="text/css">
@endsection


@section('content')
    <!-- content -->
    
    <div class="content ">
        <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col-lg-7 col-md-12">
            <div class="card widget h-100">
                <div class="card-header d-flex">
                    <h6 class="card-title">
                        Sales Chart 
                        <a href="#" class="bi bi-question-circle ms-1 small" data-bs-toggle="tooltip"
                           title="Daily orders and sales"></a>
                    </h6>
                    
                </div>
                <div class="card-body">
                    <div class="d-md-flex align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="display-7 me-3">
                                <i class="bi bi-bag-check me-2 text-success t_order" > </i> 
                            </div>
                            
                        </div>
                        <div class="d-flex gap-4 align-items-center ms-auto mt-3 mt-lg-0">
                            <select class="form-select" id="month_select" >
                                  
                                   <optgroup label="{{ date('Y',strtotime("-1 year")) }}">
                                   @foreach($monthArray as $month)
                                      @if( date('Y',strtotime("-1 year")) == date('Y',strtotime($month)))  
                                       <option value="{{date('m-Y',strtotime($month))}}">{{ date('F',strtotime($month)) }}</option> 
                                      @endif 
                                   @endforeach 
                                   </optgroup>

                                   <optgroup label="{{ date('Y') }}">
                                   @foreach($monthArray as $month)
                                      @if( date('Y') == date('Y',strtotime($month)))  
                                       <option value="{{date('m-Y',strtotime($month))}}">{{ date('F',strtotime($month)) }}</option> 
                                      @endif 
                                   @endforeach 
                                   </optgroup>

                            </select>
                        </div>
                    </div>
                    <div id="sales-chart"></div>
                    <div class="d-flex justify-content-center gap-4 align-items-center ms-auto mt-3 mt-lg-0">
                        <div>
                            <i class="bi bi-circle-fill mr-2 text-primary me-1 small"></i>
                            <span>Order</span>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-12">
            <div class="card widget h-100">
                <div class="card-header d-flex">
                    <h6 class="card-title">
                        User Chart
                        <a href="#" class="bi bi-question-circle ms-1 small" data-bs-toggle="tooltip"
                           title="Channels where your products are sold"></a>
                    </h6>
                    
                </div>
                <div class="card-body">
                    <div id="user-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <div class="display-7">
                            <i class="bi bi-basket"></i>
                        </div>
                    </div>
                    <h4 class="mb-3">Orders</h4>
                    <div class="d-flex mb-3">
                        <div class="display-7">{{ $TotalOrders }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <div class="display-7">
                            <i class="bi bi-credit-card-2-front"></i>
                        </div>
                    </div>
                    <h4 class="mb-3">Sales</h4>
                    <div class="d-flex mb-3">
                        <div class="display-7">₹{{ $TotalSales }}</div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-4 col-md-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <h6 class="card-title">Recent Reviews    </h6>
                    </div>
                    <div class="summary-cards">
                        @foreach($RecentRating as $rating)    
                        <div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar me-3">
                                    <img src="{{URL::asset('backend_asset/user_img/'.$rating->user->profile_img)}}" class="rounded-circle"
                                         alt="image">
                                </div>
                                <div>
                                    <h5 class="mb-1">{{ $rating->user->name }}</h5>
                                    <ul class="list-inline ms-auto mb-0">
                                        <li class="list-inline-item" > 
                                            <div class=" product_rating" data-rating="{{ $rating->rating }}"  > </div>
                                        </li>
                                        <li class="list-inline-item mb-0">({{  $rating->rating }})</li>
                                    </ul>
                                </div>
                            </div>
                            <div>{{ $rating->review }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
       
        <div class="col-lg-5 col-md-12">
            <div class="card widget">
                <div class="card-header">
                    <h5 class="card-title">Activity Overview</h5>
                </div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0">
                            <div class="card-body text-center">
                                <div class="display-5">
                                    <i class="bi bi-truck text-secondary"></i>
                                </div>
                                <h5 class="my-3">Delivered</h5>
                                <div class="text-muted"> {{ $TotalDeliverdOrders }} New Packages</div>    
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0">
                            <div class="card-body text-center">
                                <div class="display-5">
                                    <i class="bi bi-receipt text-warning"></i>
                                </div>
                                <h5 class="my-3">Ordered</h5>
                                <div class="text-muted">{{ $TotalNewOrders }} New Items</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-md-12">
            <div class="card widget">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title">Recent Products</h5>
                </div>
                <div class="card-body">
                    <a href="{{route('admin.product.index')}}" align="right"  class="d-block  text-danger">View all</a>
                    <div class="table-responsive">
                        <table class="table table-custom mb-0" id="recent-products">
                            <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Stock</th>
                                <th>Price</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($RecentProducts as $products)
                                <tr>
                                    <td>
                                        <a href="#">
                                            <img src="{{asset_img($products->product_img,'product_images')}}" class="rounded" width="40"
                                                 alt="...">
                                        </a>
                                    </td>
                                    <td>{{ $products->product_name }}</td>
                                    <td>
                                        <span class="text-info">{{ $products->stock ==0 || $products->is_avilable ==1 ?'Out Of Stock': $products->stock }}</span>
                                    </td>
                                    <td>₹{{ $products->current_price }}</td>
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
    <!-- ./ content -->
@endsection





@section('js')
<!-- Apex chart -->
<script src="{{asset('backend_asset/libs/charts/apex/apexcharts.min.js')}}"></script>




<!-- Slick -->
<script src="{{asset('backend_asset/libs/slick/slick.min.js')}}"></script>

<!--Rating  Javascript -->
<script src="{{asset('backend_asset/libs/rating/jquery.rating.min.js')}}"></script>

<!-- Examples -->
<script src="{{asset('backend_asset/js/examples/dashboard.js')}}"></script>


<script  type="text/javascript">


        $(".product_rating").starRating({
        
           
            activeColor: '#faae42',
            useGradient: false,
            readOnly:true,
            starSize:20,
            emptyColor:'#6c757d'
            
        });   

        $('.summary-cards').slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            autoplay: true,
            autoplaySpeed: 1500,
            rtl: $('body').hasClass('rtl') ? true : false
        });


    // Dashboard chart colors
    const body_styles = window.getComputedStyle(document.body);
    const colors = {
        primary: $.trim(body_styles.getPropertyValue('--bs-primary')),
        secondary: $.trim(body_styles.getPropertyValue('--bs-secondary')),
        info: $.trim(body_styles.getPropertyValue('--bs-info')),
        success: $.trim(body_styles.getPropertyValue('--bs-success')),
        danger: $.trim(body_styles.getPropertyValue('--bs-danger')),
        warning: $.trim(body_styles.getPropertyValue('--bs-warning')),
        light: $.trim(body_styles.getPropertyValue('--bs-light')),
        dark: $.trim(body_styles.getPropertyValue('--bs-dark')),
        blue: $.trim(body_styles.getPropertyValue('--bs-blue')),
        indigo: $.trim(body_styles.getPropertyValue('--bs-indigo')),
        purple: $.trim(body_styles.getPropertyValue('--bs-purple')),
        pink: $.trim(body_styles.getPropertyValue('--bs-pink')),
        red: $.trim(body_styles.getPropertyValue('--bs-red')),
        orange: $.trim(body_styles.getPropertyValue('--bs-orange')),
        yellow: $.trim(body_styles.getPropertyValue('--bs-yellow')),
        green: $.trim(body_styles.getPropertyValue('--bs-green')),
        teal: $.trim(body_styles.getPropertyValue('--bs-teal')),
        cyan: $.trim(body_styles.getPropertyValue('--bs-cyan')),
        chartTextColor: $('body').hasClass('dark') ? '#6c6c6c' : '#b8b8b8',
        chartBorderColor: $('body').hasClass('dark') ? '#444444' : '#ededed',
    };


        //To Create a Apex Order chart
        const OrderChaerOptions = {
                   series: [
                        
                        {
                            name: 'Orders',
                            data:  []
                        }
                    ],
                    theme: {
                        mode: $('body').hasClass('dark') ? 'dark' : 'light',
                    },
                    chart: {
                        height: 350,
                        type: 'line',
                        foreColor: colors.chartTextColor,
                        zoom: {
                            enabled: false
                        },
                        toolbar: {
                            show: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    colors: [colors.primary, colors.success],
                    stroke: {
                        width: 4,
                        curve: 'smooth',
                    },
                    legend: {
                        show: false
                    },
                    markers: {
                        size: 0,
                        hover: {
                            sizeOffset: 6
                        }
                    },
                    xaxis: {
                        categories: [],
                    },
                    tooltip: {
                        y: [
                            {
                                title: {
                                    formatter: function (val) {
                                        return val
                                    }
                                }
                            },
                            {
                                title: {
                                    formatter: function (val) {
                                        return val
                                    }
                                }
                            },
                            {
                                title: {
                                    formatter: function (val) {
                                        return val;
                                    }
                                }
                            }
                        ]
                    },
                    grid: {
                        borderColor: colors.chartBorderColor,
                    }
                };

             var orderchart = new ApexCharts(document.querySelector("#sales-chart"), OrderChaerOptions);
             orderchart.render();
             window.dispatchEvent(new Event('resize'));





            const UserChartoptions = {
                series: [],
                chart: {
                    id: 'mychart',
                    height: 250,
                    type: 'donut',
                    offsetY: 0
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '40%',
                        }
                    }
                },
                stroke: {
                    show: false,
                    width: 0
                },
                colors: [colors.orange, colors.cyan, colors.indigo],
                labels: ['admin','Customers','seller'],
                legend: {
                    show: false
                }
            }

            var UserChart = new ApexCharts(document.querySelector('#user-chart'), UserChartoptions)
            UserChart.render();



        //Select the first Option When Page Load
          $(document).ready(function(){

            $('#month_select').trigger('change');
            //for load time set all notification 
            $.ajax({
                type:'post',
                url:'{{route('admin.dashboard.ajax')}}',
                data:{'_token':'{{csrf_token()}}','notification_all':'notification_all'},
                datatype:'json',
                success:function(response){
                    $('#all-noti').html(response.all_notification);
                     console.log(response.notification_data);
                }

            });
             $('#month_select').trigger('change');
             UserChartAjax();
          });      

          //Run the function when select option changed
        $('#month_select').on('change',function(){            
            var month_year = $(this).val();  
            OrderChart(month_year);  
        });   

        // call ajax for take data from database to display chart
        function OrderChart(month_year){
            $.ajax({
                type:'post',
                url:'{{route('admin.dashboard.ajax')}}',
                data:{'_token':'{{ csrf_token() }}','month_year':month_year,'chart_type':'order chart'},
                datatype:'json',
                success:function(response){
                    orderchart.updateSeries([{
                        data: response.order
                    }]);
                    
                    let sum = 0;
                    $.each(response.order,function(key,value){
                        sum += value.y;
                    }); 
                    $('.t_order').html(sum);
                }
            });
        }

        //for remove one(click) notification and reload all unread notification         
       $(document).on('click','#read-noti',function(){
            var notification_id = $(this).attr('notification-id');
            $.ajax({
                type:'post',
                url:'{{route('admin.dashboard.ajax')}}',
                data:{'_token':'{{csrf_token()}}','notification_id':notification_id,'notification_read':'read'},
                datatype:'json',
                success:function(response){
                   console.log(response.notification_count);
                    $('#User-noti').attr('data-count',response.notification_count);
                  console.log(response.all_notification);
                   $('#all-noti').html(response.all_notification);
                      
                }
            });     
        });

        $(document).on('click','#read-all',function(){
            $.ajax({
                type:'post',
                url:'{{route('admin.dashboard.ajax')}}',
                data:{'_token':'{{csrf_token()}}','read_all':'read_all'},
                datatype:'json',
                success:function(response){

                   $('#User-noti').attr('data-count',response.notification_counter);
                   $('#all-noti').html(response.notification_all);
                }

            });

        });
        function UserChartAjax(){
            $.ajax({
                type:'post',
                url:'{{route('admin.dashboard.ajax')}}',
                data:{'_token':'{{ csrf_token() }}','chart_type':'user chart'},
                datatype:'json',
                success:function(response){
                    // console.log(response.user);
                    // console.log(response.user);
                    let arr = [];
                    $.each(response.user,function(key,value){
                        arr.push(value.user_count);
                    });

                    UserChart.updateSeries(arr);
                }
            });
        }

</script>                       

@endsection