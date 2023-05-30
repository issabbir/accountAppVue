<template>
    <div>
        <div class="card">
            <div class="card-header font-weight-bolder text-lg text-uppercase">
                Credit Voucher
                <button class="btn btn-sm border-0 print-btn"
                        @click="generatePDF" id="pdf" data-toggle="tooltip" data-placement="bottom" title="Generate PDF">Print
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
                            <span><b>Voucher No:</b> </span> #vn{{ credit_voucher.id }}
                            <span class="float-right"><b>Date: </b>{{ credit_voucher.created_at | formatDate }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Details</th>
                        <th class="text-right" style="width: 15rem">Amount</th>
                    </tr>
                    <tr style="height: 20rem">
                        <td>
                            Being The Amount received From <b>{{ client.c_name }}</b> By
                            <b class="text-uppercase">{{ credit_voucher.b_name }}</b>
                            <span v-if="credit_voucher.deposit_medium == 1">Bank</span>
                            <span v-else>Cashed By</span>
                        </td>
                        <td class="text-right">{{ credit_voucher.c_amount }}  /=</td>
                    </tr>
                    <tr>
                        <th><span class="float-right">Total: </span></th>
                        <td><span class="float-right">{{ credit_voucher.c_amount }}  /=</span></td>
                    </tr>
                </table>
                <div class="row" style="margin-top: 5rem">
                    <div class="col-md-4 text-center">
                        <b>{{ client.c_name }}</b>
                        <hr><span>Creditor</span>
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
        name: "view-project",
        data: function() {
            return {
                credit_voucher: {},
                project: {},
                client: {},
                user: {},
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
            this.$store.dispatch("getcVouchers");
            this.viewCreditVoucher();
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
            viewCreditVoucher() {
                const this_ = this;
                axios.get("/view-credit-voucher/" + this.$route.params.id).then((response) => {
                    this_.credit_voucher = response.data[1];
                    this_.project = response.data[1].project;
                    this_.client = response.data[1].client;
                    this_.user = response.data[1].user;
                    // return response.data[1];
                    console.log(response.data[1])
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
                    output: 'v_no_'+ this.credit_voucher.id +'_'+ this.credit_voucher.created_at + '.pdf'
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
</style>
