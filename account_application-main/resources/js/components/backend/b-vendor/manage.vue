<template>
    <div>
        <b-container>
            <b-collapse id="my-collapse">
                    <b-row id="display">
                        <b-col md="12">
                            <b-card title="Add Vendor">
                                <hr style="margin-top: 2rem; border-top: 1px dashed #0000002e;">
                                <b-card-text>
                                    <b-form @submit.prevent="addVendors">
                                        <b-row>
                                            <b-col md="4" id="project">
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
                                                    </v-select>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="4">
                                                <b-form-group
                                                    id="v_name"
                                                    label="Name"
                                                    label-for="v_name">
                                                    <b-form-input
                                                        id="v_name"
                                                        v-model="form.v_name"
                                                        :class="{'is-invalid': form.errors.has('v_name')}"
                                                        type="text"
                                                        placeholder="Enter your vendor name"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>

                                            <b-col md="4">
                                                <b-form-group id="v_phone" label="Phone" label-for="v_phone">
                                                    <b-form-input
                                                        id="v_phone"
                                                        type="tel"
                                                        v-model="form.v_phone"
                                                        maxlength="11" pattern="[0-9]{11}"
                                                        :class="{'is-invalid': form.errors.has('v_phone')}"
                                                        placeholder="Enter your phone..."
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>

                                            <b-col md="4">
                                                <b-form-group id="v_email" label="E-Mail" label-for="v_email">
                                                    <b-form-input
                                                        id="v_email"
                                                        type="email"
                                                        v-model="form.v_email"
                                                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                                        :class="{'is-invalid': form.errors.has('v_email')}"
                                                        placeholder="Enter your E-Mail..."
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>

                                            <b-col md="4">
                                                <b-form-group id="v_address" label=" Address" label-for="v_address">
                                                    <b-form-textarea
                                                        id="v_address"
                                                        v-model="form.v_address"
                                                        :class="{'is-invalid': form.errors.has('v_address')}"
                                                        placeholder="Wright Your Address"
                                                        style="height: 2.3rem"
                                                    ></b-form-textarea>
                                                </b-form-group>
                                            </b-col>

                                            <b-col md="4">
                                                <b-form-group id="v_type" label="Vendor Type" label-for="v_type" v-slot="{ ariaDescribedby }">
                                                    <b-form-radio-group
                                                        id="radio-group-1"
                                                        v-model="selected"
                                                        :aria-describedby="ariaDescribedby"
                                                        name="radio-options"
                                                        style="border: 1px solid #322e2e40; padding: .5rem; border-radius: 4px;">
                                                        <b-form-radio v-model="form.v_type" name="v_type" value="supplier">Supplier</b-form-radio>
                                                        <b-form-radio v-model="form.v_type" name="v_type" value="contractor">Contractor</b-form-radio>
                                                    </b-form-radio-group>
                                                </b-form-group>
                                            </b-col>

                                            <b-col md="12" class="d-flex justify-content-end">
                                                <b-button-group class="butt">
                                                    <b-button v-b-tooltip.hover.top="'Save'"
                                                              type="submit" size="sm"
                                                              variant="outline-primary">
                                                        <b-icon icon="file-earmark-post-fill"
                                                                scale="1" shift-v="1.25"
                                                                aria-hidden="true">
                                                        </b-icon> Save </b-button>
                                                    <b-button v-b-tooltip.hover.bottom="'Reset'"
                                                              type="reset" size="sm">
                                                        <b-icon icon="arrow-clockwise"
                                                                animation="spin" font-scale="1">
                                                        </b-icon> Reset </b-button>
                                                    <b-button v-b-tooltip.hover.bottom="'Cancel'"
                                                              type="button" size="sm"
                                                              variant="danger" v-b-toggle.my-collapse>
                                                        <b-icon icon="x-diamond" scale="1"
                                                                shift-v="1.25" aria-hidden="true">
                                                        </b-icon> Close </b-button>
                                                </b-button-group>
                                            </b-col>
                                        </b-row>
                                    </b-form>
                                </b-card-text>
                            </b-card>
                        </b-col>
                    </b-row>
            </b-collapse>


            <b-card>
                <b-row>
                    <b-col striped :sm="pageSize" :md="pageSize" class="my-1">
                        <b-form-group
                            label="Per page"
                            label-cols-sm="6"
                            label-cols-md="6"
                            label-cols-lg="6"
                            label-align-sm="left"
                            label-size="sm"
                            label-for="perPageSelect"
                            class="mb-0">
                            <b-form-select v-model="perPage" id="perPageSelect" size="sm" :options="pageOptions"></b-form-select>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-button v-b-toggle.my-collapse class="btn btn-info font-weight-bolder float-right btn-sm"
                                  :variant="btnVariant" id="add"
                                  style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3);">{{ btnTxt }}</b-button>
                    </b-col>
                    <b-col :sm="searchSize" :md="searchSize" class="my-1 ml-auto">
                        <b-input-group size="sm">
                            <b-form-input
                                v-model="rawInput"
                                type="search"
                                label-align-sm="right"
                                id="filterInput"
                                placeholder="Type to Search"
                                :debounce="200"></b-form-input>
                            <b-input-group-append>
                                <b-button class="data-table-filter" :disabled="!filter" @click="clear()">Clear</b-button>
                            </b-input-group-append>
                        </b-input-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col>
                        <b-table striped hover
                                 :filter="filter"
                                 :fields="fields"
                                 :items="vendors"
                                 :per-page="perPage"
                                 responsive
                                 class="text-nowrap"
                                 :current-page="currentPage"
                                 :filter-ignored-fields="filterIgnoredFields"
                                 :filter-included-fields="filterIncludedFields"
                                 @filtered="onFiltered">
                            <template v-slot:cell(index)="row" v-if="currentPage <= 1">
                                {{ (row.index + 1) }}
                            </template>
                            <template v-slot:cell(index)="row" v-else>
                                {{ (perPage * (currentPage-1)) + (row.index + 1) }}
                            </template>
<!--                            :to="`/edit-category/${row.item.slug}`" @click="editRow" :to="`/edit-customer/${row.item.id}`"-->
                            <template #cell(action)="row" v-slot:actions="{ rows }">
                                <b-link class="text-primary" :to="`/get-slips/${row.item.id}`"
                                        v-b-tooltip.hover.left="`Add Slip for ${row.item.v_name}`">
                                    <b-icon icon="clipboard-plus" scale="1.25"
                                            shift-v="1.25" aria-hidden="true">
                                    </b-icon>
                                </b-link><span id="devid">|</span>
                                <b-link ml="4" class="text-primary" v-b-tooltip.hover.top="'Edit Vendor Info'"
                                        :to="`/edit-vendor/${row.item.id}`">
                                    <b-icon icon="pencil-square" scale="1.25" shift-v="1.25" aria-hidden="true">
                                    </b-icon>
                                </b-link><span id="devide">|</span>
                                <b-link class="text-danger" @click="remove(row.item.idea)">
                                    <b-icon icon="trash2-fill" scale="1.25"
                                            shift-v="1.25" aria-hidden="true">
                                    </b-icon>
                                </b-link>
                            </template>
                            <b-pagination v-model="currentPage" :total-rows="rows" :per-page="perPage"></b-pagination>
                        </b-table>
                    </b-col>
                    <!-- The modal -->
<!--                    <b-modal id="my-modal" hide-footer>-->
<!--                        <template #modal-title>-->
<!--                            Assign Project-->
<!--                        </template>-->
<!--                        <form ref="form" @submit.prevent="assignProject">-->
<!--                            <b-row>-->
<!--                                <b-col md="12">-->
<!--                                    <b-form-group-->
<!--                                        id="project_id"-->
<!--                                        label="Project Name"-->
<!--                                        label-for="project_id">-->
<!--                                        <b-form-select class="form-control"-->
<!--                                                       name="project_id" id="project_id"-->
<!--                                                       v-model="selectedOpt">-->
<!--                                            <b-form-select-option :value="null">Please select an option</b-form-select-option>-->
<!--                                            <b-form-select-option v-for="(project, idx) in projects"-->
<!--                                                                  :key="idx"-->
<!--                                                                  v-bind:value="project.id">-->
<!--                                                {{ project.project_name }}-->
<!--                                            </b-form-select-option>-->
<!--                                        </b-form-select>-->
<!--                                    </b-form-group>-->
<!--                                </b-col>-->

<!--                                &lt;!&ndash; Emulate built in modal footer ok and cancel button actions &ndash;&gt;-->
<!--                                <hr style="margin-top: 2rem; border-top: 1px dashed #0000002e;">-->
<!--                                <b-col md="12" class="d-flex justify-content-end">-->
<!--                                    <b-button-group size="sm">-->
<!--                                        <b-button type="submit" size="sm" variant="outline-primary">-->
<!--                                            <b-icon icon="file-earmark-post-fill"-->
<!--                                                    scale="1" shift-v="1.25"-->
<!--                                                    aria-hidden="true">-->
<!--                                            </b-icon> Save-->
<!--                                        </b-button>-->
<!--                                    </b-button-group>-->
<!--                                </b-col>-->
<!--                            </b-row>-->
<!--                        </form>-->
<!--                    </b-modal>-->
                </b-row>
                <b-row>
                    <b-col sm="12" md="12" class="mt-0">
                        <b-pagination
                            v-model="currentPage"
                            :total-rows="rows"
                            :per-page="perPage"
                            align="right"
                            size="sm"
                            class="my-0"
                        ></b-pagination>
                    </b-col>
                </b-row>
            </b-card>
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
                project_id: null,
                    v_name: null,
                    v_phone: null,
                    v_email: null,
                    v_address: null,
                    v_type: null,
                }),
                show: false,
                projects: [],
                hidenseek: true,
                addCoupon: false,
                addCouponField: false,
                rawInput: null,
                items: [],
                totalList: 1,
                totalRows: 1,
                perPage: 5,
                currentPage:1,
                pageOptions: [5, 10, 15],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                deletedItem: null,
                filterOn: [],
                collapsed: false,
                pageSize: (this.pageColSize != undefined) ? this.pageColSize : '2',
                searchSize: (this.searchColSize != undefined) ? this.searchColSize : '3',
                fields: [
                    { key: 'index', label: 'index'},
                    { key: 'project.project_name', label: 'Project Name',   name: 'project.project_name', sortable: true },
                    { key: 'v_name', label: 'Name',   name: 'v_name', sortable: true },
                    { key: 'v_phone', label: 'Phone',   name: 'vphone', sortable: true },
                    { key: 'v_email', label: 'E-Mail',   name: 'vemail', sortable: true },
                    { key: 'v_address', label: 'Address',   name: 'v_address', sortable: true },
                    { key: 'v_type', label: 'Vendor Type',  name: 'v_type', sortable: true }, 'action'],
                selected: '',
                selectedOpt: null,
            // selected: [],
            // multiDelete: false,
            // isSelected: false,
        }
    },
    props: ["tbodyTrClass", "pageColSize", "searchColSize", "filterIgnoredFields", 'filterIncludedFields'],
    computed: {
        vendors() {
            return this.$store.getters.vendors
        },
        rows(){
            return this.vendors.length
            // return (this.vendors.length > 0) ? this.vendors.length : 'no data'
        },
        btnVariant: function () {
            return this.collapsed?
                'danger' : 'info'
        },
        btnTxt:  function () {
            return this.collapsed?
                '➖ Close' : '➕ Add';
        }
    },
    mounted() {
        // By Mounted Hit A Method of actions option of js file
        // Whenever Load The Component Data will get from database
        // By The actions option of js file
        // document.querySelector('#display').style.display = 'none';
        // document.querySelector('#c_coupon_code').style.display = 'none';
        this.$store.dispatch("getVendors");
        // $('#pdf').tooltip();
        this.$root.$on(
            'bv::collapse::state',
            // id of the collapse component
            // collapse is the state
            // true => open, false => close
            (id, collapsed) => {
                if (id === "my-collapse") {
                    this.collapsed = collapsed;
                }
            });// $on
        this.projectInfo();
    },
    watch: {
        selected: function (selected) {
            // this.visible = true;
            if (selected.length > 0)
            {
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                })
                document.querySelector('#display').style.display = 'block';
            }else
            {
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip('hide')
                })
                document.querySelector('#display').style.display = 'none';
            }
            this.isSelected = (selected.length > 0);
            this.multiDelete = (selected.length === this.vendors.length);
        },
        rawInput(newVal, oldVal) {
            clearTimeout(this.$_timeout)
            this.$_timeout = setTimeout(() => {
                this.filter = newVal;
            }, 150) // set this value to your preferred debounce timeout
        }
    },
    methods: {
        addVendors: function() {
            // console.log('test');
            let customer = this;
            this.form.post('/add-vendors')
                .then((response) => {
                    // console.log(data)
                    Toast.fire({
                        icon: 'success',
                        title: 'Vendor'
                    })
                    toastr.success("Vendor Created successfully")
                    document.querySelector('#display').style.display = 'none';
                    location.reload();
                    this.$store.dispatch("getVendors")
                    customer.form.v_name = null;
                    customer.form.v_phone = null;
                    customer.form.v_email = null;
                    customer.form.v_type = null;
                    customer.form.v_address = null;
                })
        },
        // editCategory: function() {
        //     const this_ = this;
        //     axios.get("/show-customer/" + this.$route.params.slug).then((response) => {
        //         this_.form.fill(response.data[1])
        //         // console.log(response.data[1])
        //     }).catch(() => {
        //
        //     })
        // }
        projectInfo: function() {
            const this_ = this;
            axios.get("/get-vendors/").then((response) => {
                // this_.form.fill(response.data[1])
                this_.projects = response.data.projects;
                // console.log(response.data)
            }).catch(() => {

            })
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalList = filteredItems.length;
            this.currentPage = 1
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
    .butt.btn-group {
        height: 2.3rem;
        margin-top: 2rem;
    }
    .card-title {
        font-size: x-large;
        font-weight: 700;
    }
    span#devide, span#devid {
        margin-left: 5px;
        margin-right: 2px;
        font-size: 1.3rem;
        font-weight: 700;
        color: bisque;
    }
</style>
