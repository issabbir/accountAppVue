<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card" v-if="hideForm">
                    <!--                    @submit.prevent="addCategory"-->
                    <form @submit.prevent="addCustomers">
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="c_name">Name</label>
                                            <input class="form-control" id="c_name"
                                                   :class="{'is-invalid': form.errors.has('c_name')}"
                                                   name="c_name" placeholder="Enter Customers Name" type="text"
                                                   v-model="form.c_name">
                                            <has-error :form="form" field="c_name"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="c_phone">Phone</label>
                                            <input type="tel" name="c_phone" id="c_phone"
                                                   maxlength="11" pattern="[0-9]{11}" placeholder="Enter Contact Number" class="form-control"
                                                   :class="{'is-invalid': form.errors.has('c_phone')}"
                                                   v-model="form.c_phone">
                                            <has-error :form="form" field="c_phone"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="c_email">E-Mail</label>
                                            <input type="email" name="c_email" id="c_email"
                                                   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                                   placeholder="Enter Your E-Mail" class="form-control"
                                                   :class="{'is-invalid': form.errors.has('c_email')}"
                                                   v-model="form.c_email">
                                            <has-error :form="form" field="c_email"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="c_address">Address</label>
                                            <textarea class="form-control" v-model="form.c_address"
                                                      name="c_address" id="c_address" cols="30"
                                                      :class="{'is-invalid': form.errors.has('c_address')}"
                                                      placeholder="Wright Your Address" style="height: 37px"></textarea>
                                            <has-error :form="form" field="c_address"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="c_type">Customer Type</label>
                                            <input type="text" name="c_type" id="c_type" placeholder="Enter Customer Type" class="form-control"
                                                   :class="{'is-invalid': form.errors.has('c_type')}"
                                                   v-model="form.c_type">
                                            <has-error :form="form" field="c_type"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6" v-if="addCoupon">
                                        <div class="form-group">
                                            <label for="c_coupon_code">Coupon Code</label>
                                            <input type="tel" name="c_coupon_code" id="c_coupon_code"
                                                   placeholder="Enter Coupon Code" class="form-control"
                                                   :class="{'is-invalid': form.errors.has('c_coupon_code')}"
                                                   v-model="form.c_coupon_code">
<!--                                            v-model="$data[addCoupon ? form.c_coupon_code : !form.c_coupon_code]"-->
                                            <has-error :form="form" field="c_coupon_code"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="c_remarks">Remarks</label>
                                            <textarea class="form-control" v-model="form.c_remarks"
                                                      name="c_remarks" id="c_remarks" cols="30"
                                                      :class="{'is-invalid': form.errors.has('c_remarks')}"
                                                      placeholder="Wright Your Remarks" style="height: 37px"></textarea>
                                            <has-error :form="form" field="c_remarks"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="btn-group" role="group" style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3);margin-top: 36px;">
                                            <button data-toggle="tooltip" v-if="!addCouponField" data-placement="bottom" title="Add Coupon"
                                                    id="add_coupon" @click="coupon_code_erase" v-on:click="addCoupon = !addCoupon,addCouponField = true" class="btn btn-success" type="button">
                                                <i class="fas fa-plus"></i> Add Field
                                            </button>
                                            <button data-toggle="tooltip" v-if="addCouponField"
                                                    data-placement="bottom" title="Close Add Coupon"
                                                    id="not_add_coupon" @click="coupon_code_erase"
                                                    v-on:click="addCoupon = !addCoupon,addCouponField = false"
                                                    class="btn btn-danger" type="button">
                                                <i class="fas fa-minus"></i> Close Add Field
                                            </button>
                                            <button data-toggle="tooltip" v-if="addCoupon" data-placement="bottom" title="Add Coupon"
                                                    id="add_coupon_text" v-on:click="add_coupon" class="btn btn-success" type="button">
                                                <i class="fas fa-plus"></i> Add Coupon Code
                                            </button>
                                        </div>
                                        <div class="btn-group float-right w-25" role="group" style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3);margin-top: 36px;">
                                            <button class="btn btn-primary" title="Save Your Content" type="submit">
                                                <i class="fas fa-save fa-1x"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="tooltip" @click="hide" data-placement="top" title="Close The Modal Window">
                                                <i class="fas fa-window-close"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card" style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3);">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <span class="card-title text-uppercase">suppliers</span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
<!--                                            @click="removeItems(selected)" :disabled="!isSelected"-->
                                            <button data-toggle="tooltip" data-placement="bottom" title="Delete"
                                                    id="display" class="btn btn-sm btn-outline-danger" type="button">
                                                <i class="fas fa-trash"></i>
                                            </button>&nbsp;&nbsp;
                                            <button style="cursor: pointer;background-image: linear-gradient(#7a9cac, #6fb6d4)" class="btn btn-sm border-0"
                                                    @click="generatePDF" id="pdf" data-toggle="tooltip" data-placement="bottom" title="Generate PDF">
                                                <i class="fas fa-file-pdf"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!--                                data-toggle="modal" data-target="#category-add" -->
                                <span href="javascript:void(0)" class="btn btn-info float-right btn-sm" id="add"
                                      v-if="!hideForm" v-on:click="hideForm = true" style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3);">
                                    <i class="fas fa-plus-circle"></i> Add
                                </span>
                                <span href="javascript:void(0)" class="btn btn-danger float-right btn-sm" id="close"
                                      v-if="hideForm" v-on:click="hideForm = false" style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3);">
                                    <i class="fas fa-minus-circle"></i> Close
                                </span>
                                <!--                                <router-link to="/categories" class="btn btn-secondary float-right btn-sm mr-1"-->
                                <!--                                             style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3); width: 60px">-->
                                <!--                                    <i class="fas fa-arrow-alt-circle-left"></i>-->
                                <!--                                </router-link>-->
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-nowrap">
<!--                                    <th>-->
<!--                                        <input :disabled="emptyData()" @click="selectAll" style="cursor: pointer"-->
<!--                                               type="checkbox" v-model="multiDelete">-->
<!--                                    </th>-->
                                    <th>Sl. No.</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Slug</th>
                                    <th>E-Mail</th>
                                    <th>Address</th>
                                    <th>Type</th>
                                    <th>Coupon Code</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(customer, i) in customers">
<!--                                    <td>-->
<!--                                        <input :value="customer.id" style="cursor: pointer"-->
<!--                                           type="checkbox" v-model="selected">-->
<!--                                    </td>-->
                                    <td>{{ ++i }}</td>
                                    <td>{{ customer.c_name }}</td>
                                    <td>{{ customer.c_phone }}</td>
                                    <td>{{ customer.c_slug }}</td>
                                    <td>{{ customer.c_email }}</td>
                                    <td>{{ customer.c_address }}</td>
                                    <td>{{ customer.c_type }}</td>
                                    <td>{{ customer.c_coupon_code }}</td>
                                    <td>{{ customer.c_remarks }}</td>
                                    <td>
                                        <router-link class="text-cyan" :to="`/edit-supplier/${customer.slug}`"><i class="fas fa-edit"></i></router-link>
                                        <span class="text-danger" @click="remove(customer.slug)" style="cursor: pointer">
                                            <i class="fas fa-trash-alt"></i>
                                        </span>
                                    </td>
                                </tr>
                                <tr v-if="emptyData()">
                                    <td colspan="10">
                                        <h6 class="text-center text-danger">Data Not Found !!</h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { uuid } from 'vue-uuid' // Import uuid
export default {
    name: "manage",
    data() {
        return {
            form: new Form({
                c_name: null,
                c_phone: null,
                c_slug: null,
                c_type: null,
                c_email: null,
                c_address: null,
                c_coupon_code: null,
                c_remarks: null,
            }),
            hideForm: false,
            addCoupon: false,
            addCouponField: false,
            // selected: [],
            // multiDelete: false,
            // isSelected: false,
        }
    },
    computed: {
        customers() {
            return this.$store.getters.customers
        }
    },
    mounted() {
        // By Mounted Hit A Method of actions option of js file
        // Whenever Load The Component Data will get from database
        // By The actions option of js file
        document.querySelector('#display').style.display = 'none';
        // document.querySelector('#c_coupon_code').style.display = 'none';
        this.$store.dispatch("getCustomers");
        $('#pdf').tooltip();
        // this.editCategory();
    },
    watch: {
        // selected: function (selected) {
        //     // this.visible = true;
        //     if (selected.length > 0)
        //     {
        //         $(function () {
        //             $('[data-toggle="tooltip"]').tooltip()
        //         })
        //         document.querySelector('#display').style.display = 'block';
        //     }else
        //     {
        //         $(function () {
        //             $('[data-toggle="tooltip"]').tooltip('hide')
        //         })
        //         document.querySelector('#display').style.display = 'none';
        //     }
        //     this.isSelected = (selected.length > 0);
        //     this.multiDelete = (selected.length === this.customers.length);
        // }
    },
    methods: {
        addCustomers: function() {
            // console.log('test');
            let customer = this;
            this.form.post('/add-customers')
                .then((response) => {
                    // console.log(data)
                    // Toast.fire({
                    //     icon: 'success',
                    //     title: 'Category Created successfully'
                    // })
                    toastr.success("Category Created successfully")
                    // $('#category-add').modal('hide');
                    this.hideForm = false
                    this.$store.dispatch("getCustomers")
                    // category.$router.push("/categories");
                    customer.form.c_name = null;
                    customer.form.c_phone = null;
                    customer.form.c_email = null;
                    customer.form.c_type = null;
                    customer.form.c_address = null;
                    customer.form.c_remarks = null;
                })
        },
        editCategory: function() {
            const this_ = this;
            axios.get("/show-category/" + this.$route.params.slug).then((response) => {
                this_.form.fill(response.data[1])
                // console.log(response.data[1])
            }).catch(() => {

            })
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
                    axios.get("remove-supplier/" + slug).then((response) => {
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
        hide() {
            this.hideForm = false;
        },
        emptyData() {
            return (this.customers.length < 1)
        },
        selectAll: function (event) {
            if (event.target.checked === false) {
                this.selected = []
                // document.querySelector('#display').style.display = 'none';
            } else {
                // document.querySelector('#display').style.display = 'block';
                this.suppliers.forEach((supplier) => {
                    if (this.selected.indexOf(supplier.id) === -1)
                    {
                        this.selected.push(supplier.id)
                    }
                })
            }
        },
        removeItems: function (selected) {
            // console.log(selected)
            axios.post("/categories/remove-items",{data: selected}).then((response) => {
                // console.log(response.data)
                this.selected = [],
                    this.multiDelete = false,
                    this.isSelected = false,
                    this.$store.dispatch("getCategories")
                toastr.success(response.data.total + ' Category has been deleted successfully !!')
            }).catch((error) => {

            })
        },
        generatePDF: function()
        {
            //initialize a new instance of jsPDF
            pdfDoc.autoTable({ html: '#example1' })
            // pdfDoc.html("get-categories",15,15)
            pdfDoc.save("pdf.pdf")
            $('#pdf').tooltip('hide')
        },
        generateUUID() { // Public Domain/MIT
            var d = new Date().getTime();
            if (typeof performance !== 'undefined' && typeof performance.now === 'function'){
                d += performance.now(); //use high-precision timer if available
            }
            var newGuid = 'xxxxxxxx'.replace(/[xy]/g, function (c) {
                var r = (d + Math.random() * 16) % 16 | 0;
                d = Math.floor(d / 16);
                return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
            });

            return newGuid;
        },
        coupon_code_erase: function(){
            this.form.c_coupon_code = null
        },
        add_coupon: function() {
            this.form.c_coupon_code = this.generateUUID()
        }
    }
}

</script>
<style scoped>
    #pdf:hover{
        color: #f9d6d5;
    }
    #c_phone:valid {
    color: green;
}

    #c_phone:invalid {
        color: red;
    }

    #c_email:valid {
        color: green;
    }

    #c_email:invalid {
        color: red;
    }
</style>
