<template>
    <div>
        <b-container>
            <b-collapse id="my-collapse">
                    <b-row id="display">
                        <b-col md="12">
                            <b-card title="Add Client">
                                <hr style="margin-top: 2rem; border-top: 1px dashed #0000002e;">
                                <b-card-text>
                                    <b-form @submit.prevent="addClients">
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
                                                        placeholder="Enter your client name"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="6">
                                                <b-form-group id="c_phone" label="Phone" label-for="c_phone">
                                                    <b-form-input
                                                        id="c_phone"
                                                        type="tel"
                                                        v-model="form.c_phone"
                                                        maxlength="11" pattern="[0-9]*{11}"
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
                                                <b-form-group id="c_remarks" label="Remarks" label-for="c_remarks">
                                                    <b-form-input
                                                        id="c_remarks"
                                                        v-model="form.c_remarks"
                                                        :class="{'is-invalid': form.errors.has('c_remarks')}"
                                                        type="text"
                                                        placeholder="Write your remarks"
                                                    ></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="6">
                                                <b-form-group id="c_address" label=" Address" label-for="c_address">
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
                                            <b-col md="6" class="d-flex justify-content-end">
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
                        <b-button v-b-toggle.my-collapse class="btn btn-info font-weight-bolder float-right btn-sm" :variant="btnVariant" id="add" style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3);">{{ btnTxt }}</b-button>
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
                                 :items="clients"
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
                            <template #cell(action)="row" v-slot:actions="{ rows }">
                                <b-link ml="4" class="text-primary" :to="`/edit-client/${row.item.id}`"><b-icon icon="pencil-square" scale="1.25" shift-v="1.25" aria-hidden="true"></b-icon>
                                </b-link><span id="devide">|</span>
                                <b-link class="text-danger" @click="remove(row.item.id)">
                                    <b-icon icon="trash2-fill" scale="1.25"
                                            shift-v="1.25" aria-hidden="true">
                                    </b-icon>
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
import { uuid } from 'vue-uuid' // Import uuid
export default {
    name: "manage",
    data() {
        return {
            form: new Form({
                    c_name: null,
                    c_phone: null,
                    c_email: null,
                    c_address: null,
                    c_remarks: null,
                }),
                show: false,
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
                    { key: 'c_name', label: 'Clients Name',   name: 'name', sortable: true },
                    { key: 'c_phone', label: 'Clients Phone',   name: 'phone', sortable: true },
                    { key: 'c_email', label: 'Clients E-Mail',   name: 'email', sortable: true },
                    { key: 'c_address', label: 'Clients Address',   name: 'address', sortable: true },
                    { key: 'c_remarks', label: 'Remarks',  name: 'c_remarks', sortable: true }, 'action']
            // selected: [],
            // multiDelete: false,
            // isSelected: false,
        }
    },
    props: ["tbodyTrClass", "pageColSize", "searchColSize", "filterIgnoredFields", 'filterIncludedFields'],
    computed: {
        clients() {
            return this.$store.getters.clients
        },
        rows(){
            return this.clients.length
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
        this.$store.dispatch("getClients");
        // $('#pdf').tooltip();
        // this.$root.$on(
        //     'bv::collapse::state',
        //     // id of the collapse component
        //     // collapse is the state
        //     // true => open, false => close
        //     (id, collapsed) => {
        //         if (id === "my-collapse") {
        //             this.collapsed = collapsed;
        //         }
        //     });// $on
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
        addClients: function() {
            // console.log('test');
            let customer = this;
            this.form.post('/add-clients')
                .then((response) => {
                    // console.log(data)
                    Toast.fire({
                        icon: 'success',
                        title: 'Client Created successfully'
                    })
                    toastr.success("Client Created successfully")
                    document.querySelector('#display').style.display = 'none';
                    location.reload();
                    this.$store.dispatch("getClients")
                    customer.form.c_name = null;
                    customer.form.c_phone = null;
                    customer.form.c_email = null;
                    customer.form.c_remarks = null;
                    customer.form.c_address = null;
                })
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalList = filteredItems.length;
            this.currentPage = 1
        },
        remove: function(id) {
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
                    axios.get("remove-client/" + id).then((response) => {
                        this.$store.dispatch("getClients"),
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

    .slide-fade-enter-active {
  		transition: all .3s ease-out;
	}

	.slide-fade-leave-active {
	  	transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
	}

	.slide-fade-enter-from,
	.slide-fade-leave-to {
	  	transform: translateX(-20px);
	  	opacity: 0;
	}

    .butt.btn-group {
        height: 2.3rem;
        margin-top: 2rem;
    }
    span#devide, span#devid {
        margin-left: 5px;
        margin-right: 2px;
        font-size: 1.3rem;
        font-weight: 700;
        color: bisque;
    }
</style>
