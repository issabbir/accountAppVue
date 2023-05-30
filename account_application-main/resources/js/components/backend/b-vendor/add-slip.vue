<template>
    <div>
        <b-container>
            <b-collapse id="my-collapse">
            <b-row id="display">
<!--                {{ slips }}-->
                <b-col md="12">
                    <b-card title="Add Slip">
                        <hr style="margin-top: 2rem; border-top: 1px dashed #0000002e;">
                        <b-card-text>
                            <b-form @submit.prevent="addSlips">
                                <b-row>
                                    <input type="hidden" name="vendor_id" id="vendor_id">
                                    <b-col md="4" hidden>
                                        <b-form-group
                                            id="slip_code"
                                            label="Slip Code"
                                            label-for="slip_code">
                                            <b-form-input
                                                id="slip_code"
                                                readonly
                                                v-model="form.slip_code"
                                                :class="{'is-invalid': form.errors.has('slip_code')}"
                                                type="text"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="4">
                                        <b-form-group id="company_name" label="Company Name"
                                                      label-for="company_name">
                                            <b-form-input
                                                id="company_name"
                                                type="text"
                                                v-model="form.company_name"
                                                :class="{'is-invalid': form.errors.has('company_name')}"
                                                placeholder="Enter company name..."
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="4">
                                        <b-form-group
                                            id="head_id"
                                            label="Head Name"
                                            label-for="head_id">
                                            <b-form-select class="form-control"
                                                           name="head_id" id="head_id"
                                                           v-model="form.head_id"
                                                           @change='childHeadInfo()'>
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

                                    <b-col md="4">
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
                                                        {{ option.head_name }} - {{ option.parent_heads.head_name }}
                                                    </option>
                                                </template>
                                                <!--                                                <b-form-select-option :disabled="nullOption" :value="null">Please select an option-->
                                                <!--                                                </b-form-select-option>-->
                                                <!--                                                <option-->
                                                <!--                                                    v-for="(childHead, idx) in childHeads"-->
                                                <!--                                                    :key="idx"-->
                                                <!--                                                    v-bind:value="childHead.id">-->
                                                <!--                                                    {{ childHead.head_name }} - {{ childHead.parent_heads.head_name }}-->
                                                <!--                                                </option>-->
                                            </v-select>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="4">
                                        <b-form-group id="slip_amount" label="Slip Amount"
                                                      label-for="slip_amount">
                                            <b-form-input
                                                id="slip_amount"
                                                type="number"
                                                v-model="form.slip_amount"
                                                :class="{'is-invalid': form.errors.has('slip_amount')}"
                                                placeholder="Enter your Slip Amount..."
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="8" class="d-flex justify-content-end buttons">
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
                                 :items="slips"
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
                                <b-link ml="4" class="text-primary" v-b-tooltip.hover.top="'Edit Slip'"
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
    export default {
        name: "slip",
        data() {
            return {
                form: new Form({
                    vendor_id: null,
                    head_id: null,
                    childhead_id: null,
                    slip_code: null,
                    company_name: null,
                    slip_amount: null,
                }),
                show: false,
                dataID: [],
                slips: [],
                vendors: [],
                vendor: [],
                parentHeads: [],
                childHeads: [],
                hidenseek: true,
                addCoupon: false,
                addCouponField: false,
                rawInput: null,
                items: [],
                projects: [],
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
                    { key: 'project_name', label: 'Project Name',   name: 'project_name', sortable: true },
                    { key: 'company_name', label: 'Company Name',   name: 'company_name', sortable: true },
                    { key: 'vendor.v_name', label: 'Vendor Name',   name: 'v_name', sortable: true },
                    { key: 'head.head_name', label: 'Head Name',   name: 'head_name', sortable: true },
                    { key: 'subhead.head_name', label: 'Subhead Name',   name: 'child_head_name', sortable: true },
                    { key: 'slip_code', label: 'Slip Code',   name: 'slip_code', sortable: true },
                    { key: 'slip_amount', label: 'Slip Amount',  name: 'slip_amount', sortable: true }, 'action'],
                selected: '',
                selectedOpt: null,
                // selected: [],
                // multiDelete: false,
                // isSelected: false,
            }
        },
        props: ["tbodyTrClass", "pageColSize", "searchColSize", "filterIgnoredFields", 'filterIncludedFields'],
        computed: {
            // slips() {
            //     return this.$store.getters.slips
            // },
            rows(){
                return this.slips.length
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
            this.$store.dispatch("getSlips");
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
            this.parentHeadInfo();
            this.projectDropdown();
            this.form.slip_code = this.generateUUID();
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
            addSlips: function() {
                // console.log('test');
                let slip = this;
                this.form.post('/store-slips')
                    .then((response) => {
                        // console.log(response)
                        Toast.fire({
                            icon: 'success',
                            title: 'Vendor'
                        })
                        toastr.success("Slip Created successfully")
                        // document.querySelector('#display').style.display = 'none';
                        location.reload();
                        this.$store.dispatch("getSlips")
                        slip.form.company_name = null;
                        slip.form.slip_amount = null;
                    })
            },
            projectInfo: function() {
                const this_ = this;
                axios.get("/get-slips/" + this.$route.params.id).then((response) => {
                    this_.form.vendor_id = response.data[5];
                    this_.dataID = response.data[1];
                    this_.slips = response.data[1];
                    console.log(response.data)
                }).catch(() => {

                })
            },
            projectDropdown: function () {
                const this_ = this;
                axios.get("/get-dvoucher/").then((response) => {
                    // this_.form.fill(response.data[1])
                    this_.projects = response.data.projects;
                    // console.log(response.data.c_voucher)
                }).catch(() => {

                })
            },
            parentHeadInfo: function () {
                const this_ = this;
                axios.get("/get-dvoucher/").then((response) => {
                    // this_.form.fill(response.data[1])
                    this_.parentHeads = response.data.parentHeads;
                    this_.form.user_id = this.$userID;
                    // console.log(response.data)
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
            add_coupon() {
                this.code = this.generateUUID()
            }
        }
    }
</script>

<style scoped>
    .buttons{
        height: 2rem;
        margin-top: 2.2rem;
    }
    span#devide, span#devid {
        margin-left: 5px;
        margin-right: 2px;
        font-size: 1.3rem;
        font-weight: 700;
        color: bisque;
    }
</style>
