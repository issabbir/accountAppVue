<template>
    <div>
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
                        <b-form-select v-model="perPage" id="perPageSelect" size="sm"
                                       :options="pageOptions"></b-form-select>
                    </b-form-group>
                </b-col>
                <b-col>
<!--                    <b-button v-b-toggle.my-collapse class="btn btn-info font-weight-bolder float-right btn-sm"-->
<!--                              :variant="btnVariant" id="add" style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3);">{{-->
<!--                        btnTxt }}-->
<!--                    </b-button>-->
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
                            <b-button class="data-table-filter" :disabled="!filter" @click="clear()">Clear
                            </b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                    <b-table striped hover
                             :filter="filter"
                             :fields="fields"
                             :items="debitVouchersHistory"
                             :per-page="perPage"
                             responsive
                             class="text-nowrap text-uppercase"
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
                        <!--                            :to="`/edit-category/${row.item.slug}`" @click="editRow"-->
                        <template #cell(action)="row" v-slot:actions="{ rows }">
                            <b-link ml="4" class="text-primary" :to="`/view-debit-voucher/${row.item.id}`"
                                    v-b-tooltip.hover.top="'Check Debit Voucher & Print'">
                                <b-icon icon="file-earmark-arrow-down-fill" scale="1.25" shift-v="1.25" aria-hidden="true"></b-icon>
                            </b-link>
                        </template>
                        <b-pagination v-model="currentPage" :total-rows="rows" :per-page="perPage"></b-pagination>
                    </b-table>
                </b-col>
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
    </div>
</template>

<script>
    import Datatable from '../../../common/datatable';
    // import the component
    import Treeselect from '@riophae/vue-treeselect'
    // import the styles
    import '@riophae/vue-treeselect/dist/vue-treeselect.css'

    import 'vue-select/dist/vue-select.css';

    export default {
        name: "debit-voucher-history",
        components: {Datatable, Treeselect},
        data() {
            return {
                projects: [],
                vendors: [],
                slips: [],
                debitVouchers: [],
                debitVouchersHistory: [],
                slipAmounts: [],
                dueAmountData: [],
                value: null,
                show: false,
                nullOption: false,
                nullOption1: false,
                hidenseek: true,
                rawInput: null,
                items: [],
                totalList: 1,
                totalRows: 1,
                perPage: 10,
                currentPage: 1,
                pageOptions: [10, 15],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                deletedItem: null,
                startDate: null,
                endDate: null,
                filterOn: [],
                collapsed: false,
                pageSize: (this.pageColSize != undefined) ? this.pageColSize : '2',
                searchSize: (this.searchColSize != undefined) ? this.searchColSize : '3',
                fields: [
                    {key: 'action', "className": "text-center"},
                    {key: 'index', label: 'SL.'},
                    {key: 'project.project_name', label: 'Project Name', name: 'project.project_name', sortable: true},
                    {key: 'vendor.v_name', label: 'Vendor Name', name: 'vendor.v_name', sortable: true},
                    {key: 'slip.company_name', label: 'Company Name', name: 'slip.company_name', sortable: true},
                    {key: 'slip.slip_code', label: 'Slip Code', name: 'slip.slip_code', sortable: true},
                    {key: 'slip_amount', label: 'Slip Amount', name: 'slip_amount', sortable: true},
                    {key: 'd_amount', label: 'Debit Amount', name: 'd_amount', sortable: true},
                    {key: 'due_amount', label: 'Due Amount', name: 'due_amount', sortable: true},
                    {key: 'user.name', label: 'Received By', name: 'user.name', sortable: true}],
                selected: null,
                selectedOpt: null,
                selectedClient: null
            }
        },
        props: ["tbodyTrClass", "pageColSize", "searchColSize", "filterIgnoredFields", 'filterIncludedFields'],
        computed: {
            // categories() {
            //     return this.$store.getters.categories
            // },
            dvouchers() {
                return this.$store.getters.dvouchers
            },
            getProjectWiseDebitVouchers() {
                return this.$store.getters.getProjectWiseDebitVouchers
            },
            rows() {
                return this.dvouchers.length
            },
            btnVariant: function () {
                return this.collapsed ?
                    'danger' : 'info'
            },
            btnTxt: function () {
                return this.collapsed ?
                    '➖ Close' : '➕ Add';
            },
            filteredData() {
                var vm = this
                var startDate = vm.startDate;
                var endDate = vm.endDate;
                return _.filter(vm.data.all, (function (data) {
                    if ((_.isNull(startDate) && _.isNull(endDate))) {
                        return true
                    } else {
                        var date = data.date;
                        return (date >= startDate && date <= endDate);
                    }
                }))
            }
        },
        mounted() {
            // By Mounted Hit A Method of actions option of js file
            // Whenever Load The Component Data will get from database
            // By The actions option of js file
            // document.querySelector('#display').style.display = 'none';
            this.$store.dispatch("getdVouchers");
            // $('#pdf').tooltip()
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
            this.vendorInfo();
            this.slipInfo();
            this.debitVoucherHistory();
            // this.childHeadInfo();
            // console.log(this.$user)
        },
        watch: {
            selected: function (selected) {
                // this.visible = true;
                if (selected.length > 0) {
                    $(function () {
                        $('[data-toggle="tooltip"]').tooltip()
                    })
                    document.querySelector('#display').style.display = 'block';
                } else {
                    $(function () {
                        $('[data-toggle="tooltip"]').tooltip('hide')
                    })
                    document.querySelector('#display').style.display = 'none';
                }
                this.isSelected = (selected.length > 0);
                this.multiDelete = (selected.length === this.suppliers.length);
            },
            rawInput(newVal, oldVal) {
                clearTimeout(this.$_timeout)
                this.$_timeout = setTimeout(() => {
                    this.filter = newVal;
                }, 150) // set this value to your preferred debounce timeout
            }
        },
        methods: {
            addDebitVouchers: function () {
                // console.log('test');
                let supplier = this;
                this.form.post('/add-dvoucher')
                    .then((response) => {
                        // console.log(response)
                        // Toast.fire({
                        //     icon: 'success',
                        //     title: 'Category Created successfully'
                        // })
                        toastr.success("Debit Voucher Created successfully");
                        location.reload();
                        supplier.form.project_id = null;
                        supplier.form.vendor_id = null;
                        supplier.form.head_id = null;
                        supplier.form.childhead_id = null;
                        supplier.form.d_amount = null;
                    })
            },
            projectInfo: function () {
                const this_ = this;
                axios.get("/get-dvoucher/").then((response) => {
                    // this_.form.fill(response.data[1])
                    this_.projects = response.data.projects;
                    // console.log(response.data.c_voucher)
                }).catch(() => {

                })
            },
            debitVoucherHistory: function() {
                const this_ = this;
                axios.get("/view-debit-voucher-history/" + this.$route.params.id).then((response) => {
                    this_.debitVouchersHistory = response.data[1];
                    // console.log(response.data)
                }).catch(() => {

                })
            },
            vendorInfo: function () {
                const this_ = this;
                axios.get("/get-dvoucher/").then((response) => {
                    // this_.form.fill(response.data[1])
                    this_.vendors = response.data.vendors;
                    this_.debitVouchers = response.data.d_voucher[0];
                    this_.form.user_id = this.$userID;
                    // console.log(response.data.vendors)
                }).catch(() => {

                })
            },
            slipInfo: function () {
                const this_ = this;
                axios.get("/get-dvoucher/").then((response) => {
                    // this_.form.fill(response.data[1])
                    this_.slips = response.data.slips;
                    this_.form.user_id = this.$userID;
                    // console.log(response.data)
                }).catch(() => {

                })
            },
            slipSingleInformation: function () {
                const this_ = this;
                this_.nullOption = true;
                axios.get("/slip-info/", {
                    params: {
                        slip_id: this.form.slip_id
                    }
                }).then((response) => {
                    // this_.form.fill(response.data[1])
                    this_.form.vendor_id = response.data.slipInformation[0].vendor_id;
                    if (response.data.slipId != null)
                    {
                        document.querySelector('#slipAmount').style.display = 'block';
                        document.querySelector('#slipAmount1').style.display = 'none';
                        document.querySelector('#project1').style.display = 'block';
                        document.querySelector('#project').style.display = 'none';
                        this_.debitVouchers = response.data.slipId;
                        this.form.project_id = response.data.slipId.project_id;
                        this.form.company_name = response.data.slipId.slip.company_name;
                        this.form.slip_amount = (this.debitVouchers.slip_amount - this.debitVouchers.d_amount);
                    }
                    else
                    {
                        document.querySelector('#slipAmount1').style.display = 'block';
                        document.querySelector('#slipAmount').style.display = 'none';
                        document.querySelector('#project').style.display = 'block';
                        document.querySelector('#project1').style.display = 'none';
                        this_.form.project_id = null;
                        this_.form.slip_amount = null;
                        this_.slipAmounts = response.data.slipInformation;
                    }

                    console.log(response.data)
                }).catch(() => {

                })
            },
            dueAmount() {
                this.form.due_amount = (this.form.slip_amount - this.form.d_amount);
                // console.log(dAm);
            },
            debitAmount() {
                this.form.slip_amount = (this.debitVouchers.slip_amount - this.debitVouchers.d_amount);
                // console.log(dAm);
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalList = filteredItems.length;
                this.currentPage = 1
            },
            remove: function (slug) {
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
                            this.$store.dispatch("getcVouchers"),
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
                return (this.suppliers.length < 1)
            },
            selectAll: function (event) {
                if (event.target.checked === false) {
                    this.selected = []
                    // document.querySelector('#display').style.display = 'none';
                } else {
                    // document.querySelector('#display').style.display = 'block';
                    this.suppliers.forEach((supplier) => {
                        if (this.selected.indexOf(supplier.id) === -1) {
                            this.selected.push(supplier.id)
                        }
                    })
                }
            },
            removeItems: function (selected) {
                // console.log(selected)
                axios.post("/categories/remove-items", {data: selected}).then((response) => {
                    // console.log(response.data)
                    this.selected = [],
                        this.multiDelete = false,
                        this.isSelected = false,
                        this.$store.dispatch("getCategories")
                    toastr.success(response.data.total + ' Category has been deleted successfully !!')
                }).catch((error) => {

                })
            },
            generatePDF: function () {
                //initialize a new instance of jsPDF
                pdfDoc.autoTable({html: '#example1'})
                // pdfDoc.html("get-categories",15,15)
                pdfDoc.save("pdf.pdf")
                $('#pdf').tooltip('hide')
            },
            depositMedium(e) {
                console.log(e.target.value);
                if (e.target.value == 1) {
                    $('.rest').css('display', 'block');
                    $('.person').css('display', 'none');
                } else if (e.target.value == 2) {
                    $('.rest').css('display', 'none');
                    $('.person').css('display', 'block');
                }
            }
        }
    }
</script>

<style scoped>
    a.text-primary {
        margin-left: 2rem;
    }
</style>
