<template>
    <div>
<!--        {{ debit_voucher }}-->
        <div class="card">
            <div class="card-header font-weight-bolder text-lg text-uppercase">
                Debit Voucher
                <button class="btn btn-sm border-0 print-btn"
                        @click="generatePDF" id="pdf" data-toggle="tooltip"
                        data-placement="bottom" title="Generate PDF">Print
                    <i class="fas fa-file-pdf"></i>
                </button>
            </div>
            <div class="card-body" id="example1">
                <table class="table table-bordered">
                    <tr>
                        <td colspan="5" class="text-center">
                            <span style="font-size: 1.5rem"><b>Company Name</b></span><br>
                            <span ><b>Address: </b> 37 Eastern Housing, Pallabi, Dhaka 1216</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <span><b>Voucher No:</b> </span> #vn{{ debit_voucher.id }}
                            <span class="float-right"><b>Date: </b>{{ debit_voucher.created_at | formatDate }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Details</th>
                        <th class="text-right" style="width: 15rem">Amount</th>
                    </tr>
                    <tr style="height: 20rem">
                        <td>
                            Being The Amount Paid To <b>{{ vendor.v_name }} - {{ vendor.v_type }}</b> For
                            <b class="text-uppercase"> {{ project.project_name }}'s </b> and it'll spend for
                            <b>{{ head.head_name }}'s</b> subhead <b>{{ subhead.head_name }}</b>
                            <span class="stamp is-approved" v-if="debit_voucher.due_amount == 'Paid'">Paid</span>
                        </td>
                        <td class="text-right">{{ debit_voucher.d_amount }}  /=</td>
                    </tr>
                    <tr>
                        <th><span class="float-right">Payable: </span></th>
                        <td><span class="float-right">{{ slip.slip_amount }}  /=</span></td>
                    </tr>
                    <tr>
                        <th><span class="float-right">Total: </span></th>
                        <td><span class="float-right">{{ debit_voucher.d_amount }}  /=</span></td>
                    </tr>
                    <tr id="due" v-if="debit_voucher.due_amount != 'Paid'">
                        <th><span class="float-right">Due Amount: </span></th>
                        <td><span class="float-right">{{ debit_voucher.due_amount }}  /=</span></td>
                    </tr>
<!--                    <tr id="dueb" v-else>-->
<!--                        <th><span class="float-right">Due Amount: </span></th>-->
<!--                        <td><span class="float-right">{{ debit_voucher.due_amount }}  /=</span></td>-->
<!--                    </tr>-->
                </table>
                <div class="row" style="margin-top: 5rem">
                    <div class="col-md-4 text-center">
                        <b> {{ vendor.v_name }} </b>
                        <hr><span>Paid To</span>
                    </div>
                    <div class="col-md-4 text-center"><b>{{ user.name }}</b>
                        <hr><span>Received By</span></div>
                    <div class="col-md-4 text-center"><b>Rashedul Islam</b>
                        <hr><span>Accountant / Manager</span></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import html2canvas from "html2canvas";
    import html2PDF from 'jspdf-html2canvas';
    import jsPDF from 'jspdf'
    export default {
        name: "view-debit-voucher",
        data: function() {
            return {
                debit_voucher: {},
                project: {},
                vendor: {},
                user: {},
                slip: {},
                head: {},
                subhead: {},
                categoryIds: [],
                text: `
          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
          richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor
          brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon
          tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
          assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore
          wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher
          vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic
          synth nesciunt you probably haven't heard of them accusamus labore VHS.
        `
            }
        },
        computed: {
            // categories() {
            //     return this.$store.getters.categories
            // },
            projects() {
                return this.$store.getters.projects
            }
        },
        mounted() {
            // By Mounted Hit A Method of actions option of js file
            // Whenever Load The Component Data will get from database
            // By The actions option of js file
            this.$store.dispatch("getdVouchers");
            this.viewDebitVoucher();
            // this.dueAmountPaid();
        },
        watch: {
            // dueAmountPaid: function ()
            // {
            //     if (this.debit_voucher.due_amount != 'Paid')
            //     {
            //         document.querySelector('#due').style.display = 'block';
            //     }
            //     else
            //     {
            //         document.querySelector('#due').style.display = 'none';
            //     }
            // }
        },
        methods: {
            updateProject: function() {
                // console.log('test');
                let this_ = this;
                this.form.post('/update-category')
                    .then((response) => {
                        toastr.success("Category Updated successfully")
                        this_.$router.push("/categories")
                        // console.log(data)
                        // Toast.fire({
                        //     icon: 'success',
                        //     title: 'Category Created successfully'
                        // })
                        // this.$store.dispatch("getCategories")
                        // $('#category-add').modal('hide');
                        // category.$router.push("/categories");
                    })
            },
            viewDebitVoucher() {
                const this_ = this;
                axios.get("/view-debit-voucher/" + this.$route.params.id).then((response) => {
                    this_.debit_voucher = response.data[5];
                    this_.project = response.data[1].project;
                    this_.vendor = response.data[1].vendor;
                    this_.head = response.data[3].head;
                    this_.slip = response.data[5];
                    this_.subhead = response.data[3].subhead;
                    this_.user = response.data[1].user;
                    // return response.data[1];
                    console.log(response.data)
                }).catch(() => {

                })
            },
            statusName: function(status) {
                let data = { 0: "Inactive", 1: "Active" }

                return data[status];
            },
            statusColor: function(status) {
                let data = { 0: "badge-danger", 1: "badge-success" }

                return data[status];
            },
            remove: function(slug) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.get("remove-category/" + slug).then((response) => {
                            this.$store.dispatch("getCategories"),
                                // toastr.success('Category Deleted Successfully !!')
                                swalWithBootstrapButtons.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                        }).catch((error) => {

                        })
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'Your imaginary file is safe :)',
                            'error'
                        )
                    }
                })
            },
            emptyData() {
                return (this.categories.length < 1);
            },
            generatePDF: function()
            {
                let page = document.getElementById('example1');
                html2PDF(page, {
                    jsPDF: {
                        format: 'a4',
                    },
                    imageType: 'image/jpeg',
                    output: 'v_no_'+ this.debit_voucher.id +'_'+ this.debit_voucher.created_at + '.pdf'
                });
            }
        }
    }
</script>

<style scoped>
    .card-header {
        text-align: center;
    }
    hr{
        border-top: 1px dashed rgb(0 0 0 / 97%);
    }
    .print-btn {
        cursor: pointer;
        background-image: linear-gradient(rgb(34 50 58), rgb(111 212 170));
        float: right;
        color: whitesmoke;
        font-weight: 800;
        letter-spacing: 3px;
    }

    .stamp {
        transform: rotate(12deg);
        color: #555;
        font-size: 3rem;
        font-weight: 700;
        border: 0.25rem solid #555;
        display: inline-block;
        padding: 0.25rem 1rem;
        text-transform: uppercase;
        border-radius: 1rem;
        font-family: 'Courier';
        -webkit-mask-image: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/8399/grunge.png');
        -webkit-mask-size: 944px 604px;
        mix-blend-mode: multiply;
        position: absolute;
        margin-top: 6rem;
        margin-left: 10rem;
    }

    .is-approved {
        color: #0A9928;
        border: 0.5rem solid #0A9928;
        -webkit-mask-position: 13rem 6rem;
        transform: rotate(-14deg);
        border-radius: 0;
    }
</style>
