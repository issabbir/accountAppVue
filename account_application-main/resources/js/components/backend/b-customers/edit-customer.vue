<template>
    <div>
        <b-container>
            <b-row>
                <b-col md="12">
                    <b-card>
                        <b-form @submit.prevent="updateCustomers">
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        id="c_name"
                                        label="Name"
                                        label-for="c_name">
                                        <b-form-input
                                            id="c_name"
                                            v-model="form.c_name"
                                            :class="{'is-invalid': form.errors.has('c_name')}"
                                            type="text"
                                            placeholder="Enter your name"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group id="c_phone" label="Phone" label-for="c_phone">
                                        <b-form-input
                                            id="c_phone"
                                            type="tel"
                                            v-model="form.c_phone"
                                            maxlength="11" pattern="[0-9]{11}"
                                            :class="{'is-invalid': form.errors.has('c_phone')}"
                                            placeholder="Enter your phone..."
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group id="c_email" label="E-Mail" label-for="c_email">
                                        <b-form-input
                                            id="c_email"
                                            type="email"
                                            v-model="form.c_email"
                                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                            :class="{'is-invalid': form.errors.has('c_email')}"
                                            placeholder="Enter your E-Mail..."
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group id="c_address" label="Address" label-for="c_address">
                                        <b-form-textarea
                                            id="c_address"
                                            v-model="form.c_address"
                                            :class="{'is-invalid': form.errors.has('c_address')}"
                                            placeholder="Wright Your Address"
                                            rows="1"
                                            style="height: 2.3rem"
                                            max-rows="6"
                                        ></b-form-textarea>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        id="c_type"
                                        label="Customer Type"
                                        label-for="c_type">
                                        <b-form-input
                                            id="c_type"
                                            v-model="form.c_type"
                                            :class="{'is-invalid': form.errors.has('c_type')}"
                                            type="text"
                                            placeholder="Enter Customer Type"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" v-if="addCoupon">
                                    <b-form-group
                                        id="c_coupon_code"
                                        label="Coupon Code"
                                        label-for="c_coupon_code">
                                        <b-form-input
                                            id="c_coupon_code"
                                            v-model="form.c_coupon_code"
                                            :class="{'is-invalid': form.errors.has('c_coupon_code')}"
                                            type="text"
                                            placeholder="Enter Coupon Code"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group id="c_remarks" label="Address" label-for="c_remarks">
                                        <b-form-textarea
                                            id="c_remarks"
                                            v-model="form.c_remarks"
                                            :class="{'is-invalid': form.errors.has('c_remarks')}"
                                            placeholder="Wright Your Remarks"
                                            rows="1"
                                            style="height: 2.3rem"
                                            max-rows="6"
                                        ></b-form-textarea>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col md="12" class="d-flex justify-content-between">
                                    <b-button-group>
                                        <b-button
                                            data-toggle="tooltip" v-if="!addCouponField"
                                            data-placement="bottom"
                                            v-b-tooltip.hover.top="'Add Field'" 
                                            type="button" size="sm" 
                                            variant="outline-primary" id="add_coupon" 
                                            @click="coupon_code_erase" 
                                            v-on:click="addCoupon = !addCoupon,addCouponField = true">
                                            <b-icon icon="plus-square-fill" scale="1" shift-v="1.25" aria-hidden="true"></b-icon>
                                        </b-button>
                                        <b-button
                                            data-toggle="tooltip" v-if="addCouponField"
                                            data-placement="bottom"
                                            v-b-tooltip.hover.top="'Close Coupon Field'" 
                                            type="button" size="sm" 
                                            variant="danger" id="not_add_coupon" 
                                            @click="coupon_code_erase" 
                                            v-on:click="addCoupon = !addCoupon,addCouponField = false">
                                            <i class="fas fa-minus"></i>
                                        </b-button>
                                        <b-button
                                            data-toggle="tooltip" v-if="addCoupon"
                                            data-placement="bottom"
                                            v-b-tooltip.hover.top="'Add Coupon'"
                                            id="add_coupon_text"
                                            v-on:click="add_coupon"
                                            type="button" size="sm" 
                                            variant="outline-primary">
                                            <b-icon icon="plus-square" scale="1" shift-v="1.25" aria-hidden="true"></b-icon>
                                        </b-button>
                                    </b-button-group>
                                    <b-button-group>
                                        <b-button v-b-tooltip.hover.top="'Save'" type="submit" size="sm" variant="outline-primary"><b-icon icon="file-earmark-post-fill" scale="1" shift-v="1.25" aria-hidden="true"></b-icon>
                                        </b-button>
                                        <b-button v-b-tooltip.hover.bottom="'Reset'" type="reset" size="sm"><b-icon icon="arrow-clockwise" animation="spin" font-scale="1"></b-icon>
                                        </b-button>
                                        <b-button v-b-tooltip.hover.bottom="'Cancel'" type="button" size="sm" variant="danger" v-b-toggle.my-collapse><b-icon icon="x-diamond" scale="1" shift-v="1.25" aria-hidden="true"></b-icon>
                                        </b-button>
                                    </b-button-group>
                                </b-col>
                            </b-row>
                        </b-form>
                    </b-card>
                </b-col>
            </b-row>
        </b-container>
    </div>
</template>
<script>
import { uuid } from 'vue-uuid' // Import uuid
export default {
    name: "manage",
    data() {
        return {            
            form: new Form({
                    id: null,
                    c_name: null,
                    c_phone: null,
                    c_slug: null,
                    c_type: null,
                    c_email: null,
                    c_address: null,
                    c_coupon_code: null,
                    c_remarks: null,
                }),
                hidenseek: true,
                addCoupon: false,
                addCouponField: false,
                rawInput: null,
                items: [],
        }
    },
    computed: {
        customers() {
            return this.$store.getters.customers
        },
    },
    mounted() {
        // By Mounted Hit A Method of actions option of js file
        // Whenever Load The Component Data will get from database
        // By The actions option of js file
        // document.querySelector('#display').style.display = 'none';
        // document.querySelector('#c_coupon_code').style.display = 'none';
        this.$store.dispatch("getCustomers");
        this.editCustomer();
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
        updateCustomers: function() {
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
                    // this.hideForm = false
                    document.querySelector('#display').style.display = 'none';
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
        editCustomer: function() {
            const this_ = this;
            axios.get("/show-customer/" + this.$route.params.slug).then((response) => {
                // this_.form.fill(response.data[1])
                console.log(response.data[1])
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
