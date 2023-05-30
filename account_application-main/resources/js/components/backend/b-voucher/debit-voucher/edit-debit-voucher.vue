<template>
    <div>
        <b-container>
            <b-row id="display">
                <b-col md="12">
                    <b-card title="Edit Debit Voucher">
                        <hr style="margin-top: 2rem; border-top: 1px dashed #0000002e;">
                        <b-form @submit.prevent="updateDebitVouchers">
                            <b-row>
                                <input type="hidden" name="user_id" id="user_id">
                                <b-col md="3">
                                    <b-form-group
                                        id="project_id"
                                        label="Project Name"
                                        label-for="project_id">
                                        <v-select :options="projects"
                                                  label="project_name"
                                                  menu-props="auto"
                                                  :reduce="(option) => option.id"
                                                  placeholder="--Please Select An Option--"
                                                  v-model="form.project_id">
                                            <template class="single-option" slot="option" slot-scope="option">
                                                <option v-bind:value="option.id">
                                                    {{ option.project_name }}
                                                </option>
                                            </template>
                                            <!--                                            <b-form-select class="form-control"-->
                                            <!--                                                           name="project_id" id="project_id"-->
                                            <!--                                                           v-model="form.project_id">-->
                                            <!--                                                <b-form-select-option :value="null">Please select an option-->
                                            <!--                                                </b-form-select-option>-->
                                            <!--                                                <option-->
                                            <!--                                                    v-for="(project, idx) in projects"-->
                                            <!--                                                    :key="idx"-->
                                            <!--                                                    v-bind:value="project.id">-->
                                            <!--                                                    {{ project.project_name }}-->
                                            <!--                                                </option>-->
                                            <!--                                            </b-form-select>-->
                                        </v-select>
                                    </b-form-group>
                                </b-col>

                                <b-col md="3">
                                    <b-form-group
                                        id="vendor_id"
                                        label="Vendor Name"
                                        label-for="vendor_id">
                                        <v-select :options="vendors"
                                                  label="v_name"
                                                  :reduce="(option) => option.id"
                                                  placeholder="--Please Select An Option--"
                                                  v-model="form.vendor_id">
                                            <option value="" disabled>--Please select an option--</option>
                                            <template class="single-option" slot="option" slot-scope="option">
                                                <option v-bind:value="option.id">
                                                    {{ option.v_name }}
                                                </option>
                                            </template>
                                            <!--                                                <b-form-select-option :value="null">Please select an option-->
                                            <!--                                                </b-form-select-option>-->
                                            <!--                                                <option-->
                                            <!--                                                    v-for="(vendor, idx) in vendors"-->
                                            <!--                                                    :key="idx"-->
                                            <!--                                                    v-bind:value="vendor.id">-->
                                            <!--                                                    {{ vendor.v_name }} - {{ vendor.v_type }}-->
                                            <!--                                                </option>-->
                                        </v-select>
                                    </b-form-group>
                                </b-col>

                                <b-col md="3">
                                    <b-form-group
                                        id="head_id"
                                        label="Head Name"
                                        label-for="head_id">
                                        <b-form-select class="form-control"
                                                       name="head_id" id="head_id"
                                                       v-model="form.head_id"
                                                       @input='childHeadInfo()'>
                                            <b-form-select-option :value="null">Please select an option
                                            </b-form-select-option>
                                            <option
                                                v-for="(head, idx) in parentHeads"
                                                :key="idx"
                                                v-bind:value="head.id">
                                                {{ head.head_name }}
                                            </option>
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>

                                <b-col md="3">
                                    <b-form-group
                                        id="childhead_id"
                                        label="Sub Head Name"
                                        label-for="childhead_id">
                                        <v-select :options="childHeads"
                                                  label="head_name"
                                                  :reduce="(option) => option.id"
                                                  placeholder="--Please Select An Option--"
                                                  v-model="form.childhead_id">
                                            <template class="single-option" slot="option" slot-scope="option">
                                                <option>
                                                    {{ option.head_name }}
                                                </option>
                                            </template>
<!--                                            - {{ option.parent_heads.head_name }}                                            &lt;!&ndash;                                                </b-form-select-option>&ndash;&gt;-->
                                            <!--                                                <option-->
                                            <!--                                                    v-for="(childHead, idx) in childHeads"-->
                                            <!--                                                    :key="idx"-->
                                            <!--                                                    v-bind:value="childHead.id">-->
                                            <!--                                                    {{ childHead.head_name }} - {{ childHead.parent_heads.head_name }}-->
                                            <!--                                                </option>-->
                                        </v-select>
                                    </b-form-group>
                                </b-col>

                                <b-col md="3">
                                    <b-form-group id="d_amount" label="Debit Amount" label-for="d_amount">
                                        <b-form-input
                                            id="d_amount"
                                            type="number"
                                            v-model="form.d_amount"
                                            :class="{'is-invalid': form.errors.has('d_amount')}"
                                            placeholder="Enter your credit amount"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col md="12" class="d-flex justify-content-end">
                                    <b-button-group>
                                        <b-button v-b-tooltip.hover.top="'Save'" type="submit" size="sm"
                                                  variant="outline-primary">
                                            <b-icon icon="file-earmark-post-fill" scale="1" shift-v="1.25"
                                                    aria-hidden="true"></b-icon>
                                        </b-button>
                                        <b-button v-b-tooltip.hover.bottom="'Reset'" type="reset" size="sm">
                                            <b-icon icon="arrow-clockwise" animation="spin" font-scale="1"></b-icon>
                                        </b-button>
                                        <b-button v-b-tooltip.hover.bottom="'Cancel'" type="button" size="sm"
                                                  variant="danger" v-b-toggle.my-collapse>
                                            <b-icon icon="x-diamond" scale="1" shift-v="1.25"
                                                    aria-hidden="true"></b-icon>
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
    export default {
        name: "edit-debit-voucher",
        data: function() {
            return {
                form: new Form({
                    id: null,
                    project_id: null,
                    vendor_id: null,
                    head_id: null,
                    childhead_id: null,
                    d_amount: null,
                    user_id: null,
                }),
                projects: [],
                vendors: [],
                parentHeads: [],
                childHeads: [],
                hidenseek: true,
            }
        },
        computed: {
            dvouchers() {
                return this.$store.getters.dvouchers
            }
        },
        mounted() {
            // By Mounted Hit A Method of actions option of js file
            // Whenever Load The Component Data will get from database
            // By The actions option of js file
            this.$store.dispatch("getdVouchers");
            this.editDebitVoucher();
            this.otherInfo();
            this.childHeadInfo();
        },
        methods: {
            updateDebitVouchers: function() {
                // console.log('test');
                let this_ = this;
                this.form.post('/update-dvoucher')
                    .then((response) => {
                        toastr.success("Debit Voucher Updated successfully")
                        this_.$router.push("/debit-voucher")
                        // console.log(data)
                        // Toast.fire({
                        //     icon: 'success',
                        //     title: 'Category Created successfully'
                        // })
                        // this.$store.dispatch("getSuppliers")
                        // $('#category-add').modal('hide');
                        // category.$router.push("/categories");
                    })
            },
            editDebitVoucher: function() {
                const this_ = this;
                axios.get("/edit-debit-voucher/" + this.$route.params.id).then((response) => {
                    this_.form.fill(response.data[1])
                    console.log(this_.response.data[1])
                }).catch(() => {

                })
            },
            otherInfo: function () {
                const this_ = this;
                axios.get("/get-dvoucher/").then((response) => {
                    // this_.form.fill(response.data[1])
                    this_.projects = response.data.projects;
                    this_.vendors = response.data.vendors;
                    this_.parentHeads = response.data.parentHeads;
                    // console.log(response.data.c_voucher)
                }).catch(() => {

                })
            },
            childHeadInfo: function () {
                const this_ = this;
                this_.nullOption = true;
                axios.get("/show-subhead/", {
                    params: {
                        parent_id: this.form.head_id
                    }
                }).then((response) => {
                    // this_.form.fill(response.data[1])
                    this_.childHeads = response.data.childHeads;
                    // console.log(response.data.childHeads)
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
                            this.$store.dispatch("getSuppliers"),
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
                return (this.suppliers.length < 1);
            }
        }
    }

</script>
<style scoped>
    #pdf:hover{
        color: #f9d6d5;
    }
    #s_phone:valid {
        color: green;
    }

    #s_phone:invalid {
        color: red;
    }

    #s_email:valid {
        color: green;
    }

    #s_email:invalid {
        color: red;
    }
</style>
