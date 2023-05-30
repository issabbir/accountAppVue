<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-12">
                <div class="info-box" v-b-modal.client-modal>
                    <span class="info-box-icon bg-info">
                        <i class="font-weight-bolder" style="font-size: 1.5rem;">Total</i>
                    </span>

                    <div class="row ml-1">
                        <div class="info-box-content">
                            <span class="info-box-text">Clients</span>
                            <span class="info-box-text">Credit Amount</span>
                        </div>
                        <div class="info-box-content">
                            <span class="info-box-number mt-0">{{ clients }}</span>
                            <span class="info-box-number mt-0">{{ creditAmount }}</span>
                        </div>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <b-modal id="client-modal" size="lg" title="Projectwise Clients Credited Amount">
                    <table class="table table-bordered">
                        <tr>
                            <th>Project Name</th>
                            <th>Client Name</th>
                            <th>Credit Amount</th>
                        </tr>
                        <tr v-for="(creditVoucher, i) in creditVouchers">
                            <td>{{ creditVoucher.project.project_name }}</td>
                            <td>{{ creditVoucher.client.c_name }}</td>
                            <td class="text-center">{{ creditVoucher.c_amount }}</td>
                        </tr>
                    </table>
                </b-modal>
            </div>
            <div class="col-md-6 col-sm-6 col-12">
                <div class="info-box" v-b-modal.vendor-modal>
                    <span class="info-box-icon bg-info"><i class="font-weight-bolder" style="font-size: 1.5rem;">Total</i></span>

                    <div class="row ml-1">
                        <div class="info-box-content">
                            <span class="info-box-text">Vendors</span>
                            <span class="info-box-text">Debit Amount</span>
                        </div>
                        <div class="info-box-content">
                            <span class="info-box-number mt-0">{{ vendors }}</span>
                            <span class="info-box-number mt-0">{{ dVAmount }}</span>
                        </div>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <b-modal id="vendor-modal" size="lg" title="Projectwise Vendors Debited Amount">
                    <table class="table table-bordered">
                        <tr>
                            <th>Project Name</th>
                            <th>Vendor Name</th>
                            <th>Slip Amount</th>
                            <th>Due Amount</th>
                        </tr>
                        <tr v-for="(debitVoucher, i) in debitVouchers">
                            <td>{{ debitVoucher.project.project_name }}</td>
                            <td>{{ debitVoucher.vendor.v_name }}</td>
                            <td>{{ debitVoucher.slip.slip_amount }}</td>
                            <td class="text-center" v-if="debitVoucher.due_amount == 0">{{ 'Paid' }}</td>
                            <td class="text-center" v-else>{{ debitVoucher.due_amount }}</td>
                        </tr>
                    </table>
                </b-modal>
            </div>
<!--            <div class="col-md-4 col-sm-6 col-12">-->
<!--                <div class="info-box">-->
<!--                    <span class="info-box-icon bg-info"><i class="font-weight-bolder" style="font-size: 1.5rem;">Total</i></span>-->

<!--                    <div class="info-box-content">-->
<!--                        <span class="info-box-text">Due Amount</span>-->
<!--                        <span class="info-box-number">{{ dueAmount }}</span>-->
<!--                    </div>-->
<!--                    &lt;!&ndash; /.info-box-content &ndash;&gt;-->
<!--                </div>-->
<!--                &lt;!&ndash; /.info-box &ndash;&gt;-->
<!--            </div>-->
            <!-- /.col -->
<!--            <div class="col-12 col-sm-6 col-md-3">-->
<!--                <div class="info-box mb-3">-->
<!--                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>-->

<!--                    <div class="info-box-content">-->
<!--                        <span class="info-box-text">Likes</span>-->
<!--                        <span class="info-box-number">41,410</span>-->
<!--                    </div>-->
<!--                    &lt;!&ndash; /.info-box-content &ndash;&gt;-->
<!--                </div>-->
<!--                &lt;!&ndash; /.info-box &ndash;&gt;-->
<!--            </div>-->
            <!-- /.col -->

            <!-- fix for small devices only -->
<!--            <div class="clearfix hidden-md-up"></div>-->

<!--            <div class="col-12 col-sm-6 col-md-3">-->
<!--                <div class="info-box mb-3">-->
<!--                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>-->

<!--                    <div class="info-box-content">-->
<!--                        <span class="info-box-text">Sales</span>-->
<!--                        <span class="info-box-number">760</span>-->
<!--                    </div>-->
<!--                    &lt;!&ndash; /.info-box-content &ndash;&gt;-->
<!--                </div>-->
<!--                &lt;!&ndash; /.info-box &ndash;&gt;-->
<!--            </div>-->
            <!-- /.col -->
<!--            <div class="col-12 col-sm-6 col-md-3">-->
<!--                <div class="info-box mb-3">-->
<!--                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>-->

<!--                    <div class="info-box-content">-->
<!--                        <span class="info-box-text">New Members</span>-->
<!--                        <span class="info-box-number">2,000</span>-->
<!--                    </div>-->
<!--                    &lt;!&ndash; /.info-box-content &ndash;&gt;-->
<!--                </div>-->
<!--                &lt;!&ndash; /.info-box &ndash;&gt;-->
<!--            </div>-->
            <!-- /.col -->
        </div>
        <div class="row">
            <div class="col-md-12" v-show="!fullscreen">
                    <div class="card" style="box-shadow: 5px 5px 5px rgba(0,0,0,0.3);">
                        <div class="card-header">
                            <span>Project's Credit Chart Report</span>
<!--                            <span style="cursor: pointer" class="nav-link float-right" @click="toggle" role="button">-->
<!--                            <i class="fas fa-expand-arrows-alt"></i>-->
<!--                        </span>-->
                        </div>
                            <div class="card-body home">
                                <div class="small row">
                                    <!--                    {{ option.series[0].data }}-->
                                    <v-chart class="chart" :option="credit_option" />
                                </div>
                            </div>
                    </div>
            </div>
            <div class="col-md-12">
                <div class="card" style="box-shadow: 5px 5px 5px rgba(0,0,0,0.3);">
                    <div class="card-header">Project's Debited Chart Report
                    </div>
                    <div class="card-body home">
                        <div class="small row">
                            <!--                    {{ option.series[0].data }}-->
                            <v-chart class="chart" :option="option" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // import LineChart from '../LineChart'
    // import ClientModal from './modal/client'
    // import DoughnutChart from '../DoughnutChart'
    // import { D3PieChart } from 'vue-d3-charts';
    // import { GChart } from "vue-google-charts";
    // import fullscreen from 'vue-fullscreen';
    // Vue.use(fullscreen);
    import fullscreen from 'vue-fullscreen'
    import Vue from 'vue'
    Vue.use(fullscreen)
    import { use } from "echarts/core";
    import { CanvasRenderer } from "echarts/renderers";
    import { PieChart } from "echarts/charts";
    import {
        TitleComponent,
        TooltipComponent,
        LegendComponent
    } from "echarts/components";
    import VChart, { THEME_KEY } from "vue-echarts";

    use([
        CanvasRenderer,
        PieChart,
        TitleComponent,
        TooltipComponent,
        LegendComponent
    ]);
    export default {
        name: "home",
        components: {
            VChart
        },
        provide: {
            [THEME_KEY]: "dark"
        },
        data(){
            return{
                fullscreen: false,
                clients: null,
                vendors: null,
                creditAmount: null,
                dVAmount: null,
                dueAmount: null,
                myModal: false,
                creditVouchers: null,
                debitVouchers: null,
                option: {
                    title: {
                        text: "Project's Debited Chart Report",
                        right: "center",
                        left: '50%',
                        top: '80%',
                        textAlign: 'center'
                    },
                    tooltip: {
                        trigger: "item",
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    legend: {
                        orient: "horizontal",
                        left: "left",
                        data: []
                    },
                    series: [
                        {
                            name: "Project's Debited Chart Report",
                            type: "pie",
                            radius: "55%",
                            label: {
                                formatter: '{b}: {@2012} ({d}%)',
                                color: 'rgb(255,255,255)',
                                position: 'outer',
                                alignTo: 'none',
                                bleedMargin: 5
                            },
                            left: 0,
                            right: 0,
                            top: 0,
                            bottom: '20%',
                            center: ["50%", "60%"],
                            data: [],
                            // emphasis: {
                            //     itemStyle: {
                            //         shadowBlur: 10,
                            //         shadowOffsetX: 0,
                            //         shadowColor: "rgba(0, 0, 0, 0.5)"
                            //     }
                            // }
                            itemStyle: {
                                // color: '#c23531',
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                                // shadowBlur: 10,
                                // shadowOffsetX: 0,
                                // shadowColor: "rgba(0, 0, 0, 0.5)"
                            },
                            animationType: 'scale',
                            animationEasing: 'elasticOut',
                            animationDelay: function (idx) {
                                return Math.random() * 200;
                            }
                        }
                    ]
                },
                credit_option: {
                    title: {
                        text: "Project's Credited Chart Report",
                        right: "center",
                        left: '50%',
                        top: '80%',
                        textAlign: 'center'
                    },
                    tooltip: {
                        trigger: "item",
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    legend: {
                        orient: "horizontal",
                        left: "left",
                        data: []
                    },
                    series: [
                        {
                            name: "Project's Credited Chart Report",
                            type: "pie",
                            radius: "55%",
                            label: {
                                formatter: '{b}: {@2012} ({d}%)',
                                color: 'rgb(255,255,255)',
                                position: 'outer',
                                alignTo: 'none',
                                bleedMargin: 5
                            },
                            left: 0,
                            right: 0,
                            top: 0,
                            bottom: '20%',
                            center: ["50%", "60%"],
                            data: [],
                            itemStyle: {
                                // color: '#c23531',
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                                // shadowBlur: 10,
                                // shadowOffsetX: 0,
                                // shadowColor: "rgba(0, 0, 0, 0.5)"
                            },
                            animationType: 'scale',
                            animationEasing: 'elasticOut',
                            animationDelay: function (idx) {
                                return Math.random() * 200;
                            }
                            // emphasis: {
                            //     itemStyle: {
                            //         color: '#c23531',
                            //         shadowBlur: 200,
                            //         shadowColor: 'rgba(0, 0, 0, 0.5)'
                            //         // shadowBlur: 10,
                            //         // shadowOffsetX: 0,
                            //         // shadowColor: "rgba(0, 0, 0, 0.5)"
                            //     }
                            // }
                        }
                    ]
                },
            // { value: 335, name: "Directsdfs" },
            // { value: 310, name: "Email" },
            // { value: 234, name: "Ad Networks" },
            // { value: 135, name: "Video Ads" },
            // { value: 1548, name: "Search Engines" }
            //     "Directsdfs",
            //     "Email",
            //     "Ad Networks",
            //     "Video Ads",
            //     "Search Engines"
                piData: [],
                data: [
                    ['Daily Routine', 'Hours per Day'],
                    this.piData
                ],
                options: {
                    width: 1100,
                    height: 400
                }
            }
        },
        mounted () {
            // this.fillData()
            // this.renderChart(this.chartData, this.option);
            // axios.get("/pie-chart/").then((response) => {
            //     $.each(response.data[1], function(key, value) {
            //         console.log(value);
            //         this.series.push(value.debit_amount);
            //         this.chartOptions.labels.push(value.project_name);
            //     })
            //     // for (let i = 0; i < response.data.length; i++) {
            //     //     console.log(response);
            //     //     this.data.series.push(response.data[i].value);
            //     //     this.data.chartOptions.labels.push(response.data[i].key);
            //     // }
            // });
            this.projectInfo();
            this.debitPieChart();
            this.creditPieChart();
        },
        computed: {
        },
        methods: {
            projectInfo: function () {
                const this_ = this;
                axios.get("/get-cvoucher/").then((response) => {
                    // this_.form.fill(response.data[1])
                    // this_.projects = response.data.projects;
                    // const creditAmount = [];
                    // const projectName = [];
                    // this_.labels = projectName;
                    this_.clients = response.data.clients.length;
                    this_.vendors = response.data.vendors.length;
                    // this_.datasets[0].data = creditAmount;
                    this_.creditAmount = response.data.creditAmount;
                    this_.dVAmount = response.data.dVAmount;
                    this_.dueAmount = response.data.dueAmount;
                    this_.creditVouchers = response.data.c_voucher;
                    this_.debitVouchers = response.data.d_voucher;
                    this_.creditAmountTotal = creditAmount.reduce(function(creditAmount, num){ return creditAmount + num }, 0);
                    $.each(response.data.creditDetails, function(key, value) {
                        creditAmount.push(value.c_amount);
                        projectName.push(value.project_name);
                    });

                    // console.log(creditDetails);
                    // console.log(creditAmount);
                    // console.log(response.data);
                }).catch(() => {

                })
            },
            debitPieChart: function () {
                const this_ = this;
                const pChart = [];
                axios.get("/debit-pie-chart/").then((response) => {
                    this_.pChart = response.data[1];
                    // this_.piData = google.visualization.arrayToDataTable([
                    //     ['Project Name', 'Debited Amount'],
                    //     this.pChart.forEach((value, index) => {
                    //         // this_.piData.push([value.project_name, value.debit_amount]);
                    //         // return [value.project_name, value.debit_amount];
                    //     })
                    // ])
                    // $.each(this_.pChart, function(key, value) {
                    //     this_.labels.push([value.project_name]);
                    //     this_.datasets[0].data.push([value.debit_amount]);
                    // })
                    console.log(this.option.legend.data);
                    $.each(this_.pChart, function(key, value) {
                        this_.option.series[0].data.push(value);
                        this_.option.legend.data.push(value.name);
                    })
                }).catch(() => {

                })
            },
            creditPieChart: function () {
                const this_ = this;
                const pChart = [];
                axios.get("/credit-pie-chart/").then((response) => {
                    this_.pChart = response.data[1];
                    // this_.piData = google.visualization.arrayToDataTable([
                    //     ['Project Name', 'Debited Amount'],
                    //     this.pChart.forEach((value, index) => {
                    //         // this_.piData.push([value.project_name, value.debit_amount]);
                    //         // return [value.project_name, value.debit_amount];
                    //     })
                    // ])
                    // $.each(this_.pChart, function(key, value) {
                    //     this_.labels.push([value.project_name]);
                    //     this_.datasets[0].data.push([value.debit_amount]);
                    // })
                    console.log(this.option.legend.data);
                    $.each(this_.pChart, function(key, value) {
                        this_.credit_option.series[0].data.push(value);
                        this_.credit_option.legend.data.push(value.name);
                    })
                }).catch(() => {

                })
            },
            toggle () {
                this.fullscreen = !this.fullscreen
            }
        }
    }
</script>

<style scoped>
    .small {
        max-width: 800px;
        /* max-height: 500px; */
        margin:  50px auto;
    }
    span.devider {
        height: 4rem;
        width: 0.2rem;
        border-right: double;
    }
    .chart {
        height: 400px;
    }
    .small[data-v-cfa9c376] {
        margin: auto auto 50px auto;
    }
</style>
