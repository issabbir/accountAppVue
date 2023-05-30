<template>
    <div>
        <b-container>
            <b-collapse id="my-collapse">
                <b-row id="display">
                    <b-col md="12">
                        <b-card title="Add Credit Voucher">
                            <hr style="margin-top: 2rem; border-top: 1px dashed #0000002e;">
                            <b-form @submit.prevent="addCreditVouchers">
                                <b-row>
                                    <input type="hidden" name="user_id" id="user_id">
                                    <b-col md="3">
                                        <b-form-group
                                            id="project_id"
                                            label="Project Name"
                                            label-for="project_id">
                                            <b-form-select class="form-control"
                                                           name="project_id" id="project_id"
                                                           v-model="form.project_id">
                                                <b-form-select-option :value="null">Please select an option
                                                </b-form-select-option>
                                                <option
                                                    v-for="(project, idx) in projects"
                                                    :key="idx"
                                                    v-bind:value="project.id">
                                                    {{ project.project_name }}
                                                </option>
                                            </b-form-select>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="3">
                                        <b-form-group
                                            id="client_id"
                                            label="Client Name"
                                            label-for="client_id">
                                            <b-form-select class="form-control"
                                                           name="client_id" id="client_id"
                                                           v-model="form.client_id">
                                                <b-form-select-option :value="null">Please select an option
                                                </b-form-select-option>
                                                <option
                                                    v-for="(client, idx) in clients"
                                                    :key="idx"
                                                    v-bind:value="client.id">
                                                    {{ client.c_name }} - {{ client.c_address }}
                                                </option>
                                            </b-form-select>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="3">
                                        <b-form-group id="c_amount" label="Credit Amount" label-for="c_amount">
                                            <b-form-input
                                                id="c_amount"
                                                type="number"
                                                v-model="form.c_amount"
                                                :class="{'is-invalid': form.errors.has('c_amount')}"
                                                placeholder="Enter your credit amount"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="3">
                                        <b-form-group
                                            id="deposit_medium"
                                            label="Money Deposit Medium"
                                            label-for="deposit_medium">
                                            <b-form-select class="form-control" @change.native="depositMedium"
                                                           name="deposit_medium" id="deposit_medium"
                                                           v-model="form.deposit_medium">
                                                <option
                                                    v-for="(option, idx) in options"
                                                    :key="idx"
                                                    v-bind:value="option.value">
                                                    {{ option.text }}
                                                </option>
                                            </b-form-select>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="3" style="display: none" class="person">
                                        <b-form-group id="p_name" label="Person Name" label-for="p_name">
                                            <b-form-input
                                                id="p_name"
                                                type="text"
                                                v-model="form.p_name"
                                                :class="{'is-invalid': form.errors.has('p_name')}"
                                                placeholder="Enter your person name"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="3" style="display: none" class="person">
                                        <b-form-group id="p_phone" label="Person Phone" label-for="p_phone">
                                            <b-form-input
                                                id="p_phone"
                                                type="text"
                                                v-model="form.p_phone"
                                                :class="{'is-invalid': form.errors.has('p_phone')}"
                                                placeholder="Enter your person phone"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="3" style="display: none" class="rest">
                                        <b-form-group id="b_name" label="Bank Name" label-for="b_name">
                                            <b-form-input
                                                id="b_name"
                                                type="text"
                                                v-model="form.b_name"
                                                :class="{'is-invalid': form.errors.has('b_name')}"
                                                placeholder="Enter your bank name"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="3" style="display: none" class="rest">
                                        <b-form-group id="b_branch_name" label="Bank Branch Name"
                                                      label-for="b_branch_name">
                                            <b-form-input
                                                id="b_branch_name"
                                                type="text"
                                                v-model="form.b_branch_name"
                                                :class="{'is-invalid': form.errors.has('b_branch_name')}"
                                                placeholder="Enter your bank branch name"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="3" style="display: none" class="rest">
                                        <b-form-group id="b_acc_no" label="Bank Check Number" label-for="b_acc_no">
                                            <b-form-input
                                                id="b_acc_no"
                                                type="text"
                                                v-model="form.b_acc_no"
                                                :class="{'is-invalid': form.errors.has('b_acc_no')}"
                                                placeholder="Enter your bank account no"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>

                                    <!--                                    <b-col md="3" style="display: none" class="rest">-->
                                    <!--                                        <b-form-group id="b_acc_no" label="Bank Check Pic" label-for="b_acc_no">-->
                                    <!--                                            <b-form-file-->
                                    <!--                                                v-model="form.b_chk_pic"-->
                                    <!--                                                :state="Boolean(b_chk_pic)"-->
                                    <!--                                                placeholder="Choose a file or drop it here..."-->
                                    <!--                                                drop-placeholder="Drop file here..."-->
                                    <!--                                            ></b-form-file>-->
                                    <!--                                        </b-form-group>-->
                                    <!--                                    </b-col>-->
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
                            <b-form-select v-model="perPage" id="perPageSelect" size="sm"
                                           :options="pageOptions"></b-form-select>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-button v-b-toggle.my-collapse class="btn btn-info font-weight-bolder float-right btn-sm"
                                  :variant="btnVariant" id="add" style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3);">{{
                            btnTxt }}
                        </b-button>
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
                                 :items="vouchers"
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
                                <b-link ml="4" class="text-primary" :to="`/view-credit-voucher/${row.item.id}`">
                                    <b-icon icon="eye" scale="1.25" shift-v="1.25" aria-hidden="true"></b-icon>
                                </b-link>
                                <span id="devide">|</span>
                                <b-link ml="4" class="text-primary" :to="`#`">
                                    <b-icon icon="pencil-square" scale="1.25" shift-v="1.25"
                                            aria-hidden="true"></b-icon>
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
        </b-container>
    </div>
</template>
<script>
    import Datatable from '../../../common/datatable';

    export default {
        name: "manage",
        components: {Datatable},
        data() {
            return {
                form: new Form({
                    project_id: null,
                    client_id: null,
                    c_amount: null,
                    deposit_medium: null,
                    p_name: null,
                    p_phone: null,
                    b_name: null,
                    b_branch_name: null,
                    b_acc_no: null,
                    user_id: null,
                }),
                projects: [],
                clients: [],
                show: false,
                hidenseek: true,
                rawInput: null,
                items: [],
                totalList: 1,
                totalRows: 1,
                perPage: 5,
                currentPage: 1,
                pageOptions: [5, 10, 15],
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
                    {key: 'index', label: 'SL.'},
                    {key: 'project.project_name', label: 'Project Name', name: 'project.project_name', sortable: true},
                    {key: 'client.c_name', label: 'Client Name', name: 'client.c_name', sortable: true},
                    {key: 'user.name', label: 'Received By', name: 'user.name', sortable: true},
                    // { key: 'd_medium', label: 'Category',   name: 'category', sortable: true },
                    {key: 'c_amount', label: 'Credit Amount', name: 'c_amount', sortable: true},
                    // { key: 'p_name', label: 'Person Name',   name: 'p_name', sortable: true },
                    // { key: 'p_phone', label: 'persones phone',   name: 'p_phone', sortable: true },
                    {key: 'b_name', label: 'Bank Name', name: 'b_name', sortable: true},
                    // { key: 'b_branch_name', label: 'bank branch name',  name: 'b_branch_name', sortable: true },
                    {key: 'b_acc_no', label: 'Check No', name: 'b_acc_no', sortable: true}, 'action'],
                selected: null,
                selectedOpt: null,
                selectedClient: null,
                options: [
                    {value: null, text: 'Please select an option'},
                    {value: 1, text: 'Bank'},
                    {value: 2, text: 'Cash'},
                ]
            }
        },
        props: ["tbodyTrClass", "pageColSize", "searchColSize", "filterIgnoredFields", 'filterIncludedFields'],
        computed: {
            // categories() {
            //     return this.$store.getters.categories
            // },
            vouchers() {
                return this.$store.getters.vouchers
            },
            rows() {
                return this.vouchers.length
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
            this.$store.dispatch("getcVouchers");
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
            this.clientInfo();
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
            addCreditVouchers: function () {
                // console.log('test');
                let supplier = this;
                this.form.post('/add-cvoucher')
                    .then((response) => {
                        // console.log(response)
                        // Toast.fire({
                        //     icon: 'success',
                        //     title: 'Category Created successfully'
                        // })
                        toastr.success("Supplier Created successfully")
                        // $('#category-add').modal('hide');
                        document.querySelector('#display').style.display = 'none';
                        this.hideForm = false;
                        location.reload();
                        this.$store.dispatch("getcVouchers")
                        // category.$router.push("/categories");
                        supplier.form.project_id = null;
                        supplier.form.client_id = null;
                        supplier.form.c_amount = null;
                        supplier.form.p_name = null;
                        supplier.form.p_phone = null;
                        supplier.form.b_name = null;
                        supplier.form.b_branch_name = null;
                        supplier.form.b_acc_no = null;
                    })
            },
            projectInfo: function () {
                const this_ = this;
                axios.get("/get-cvoucher/").then((response) => {
                    // this_.form.fill(response.data[1])
                    this_.projects = response.data.projects;
                    // console.log(response.data.c_voucher)
                }).catch(() => {

                })
            },
            clientInfo: function () {
                const this_ = this;
                axios.get("/get-cvoucher/").then((response) => {
                    // this_.form.fill(response.data[1])
                    this_.clients = response.data.clients;
                    this_.form.user_id = this.$userID;
                    console.log(response.data.clients)
                }).catch(() => {

                })
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
    #pdf:hover {
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

    span#devide, span#devid {
        margin-left: 5px;
        margin-right: 2px;
        font-size: 1.3rem;
        font-weight: 700;
        color: bisque;
    }
</style>
