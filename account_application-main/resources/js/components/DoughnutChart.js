import { Doughnut } from 'vue-chartjs'

export default {
    extends: Doughnut,
    data () {
        return {
            chartData: {
                labels: [],
                datasets: [{
                    borderWidth: 1,
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                    ],
                    data: []
                }]
            },
            options: {
                legend: {
                    display: true
                },
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },
    mounted () {
        this.renderChart(this.chartData, this.options);
        this.pieChart();
    },
    methods: {
        pieChart: function () {
            const this_ = this;
            const pChart = [];
            axios.get("/pie-chart/").then((response) => {
                this_.pChart = response.data[1];
                $.each(this_.pChart, function(key, value) {
                    this_.chartData.labels.push([value.project_name]);
                    this_.chartData.datasets[0].data.push([value.debit_amount]);
                })
            }).catch(() => {

            })
        }
    }
}
