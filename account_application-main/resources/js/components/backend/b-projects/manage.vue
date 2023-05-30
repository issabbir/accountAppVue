<template>
    <div>
        <b-container>
            <b-collapse id="my-collapse">
                    <b-row id="display">
                        <b-col md="12">
                            <b-card>
                                <b-form @submit.prevent="addProject">
                                    <b-row>
                                        <b-col md="6">
                                            <b-form-group
                                                id="client_id"
                                                label="Project Owner"
                                                label-for="client_id">
                                                <!--                                                <b-form-select class="form-control"-->
                                                <!--                                                               name="client_id" id="client_id"-->
                                                <!--                                                               v-model="form.client_id">-->
                                                <!--                                                    <b-form-select-option :value="null">Please select an option-->
                                                <!--                                                    </b-form-select-option>-->
                                                <!--                                                    <option-->
                                                <!--                                                        v-for="(client, idx) in clients"-->
                                                <!--                                                        :key="idx"-->
                                                <!--                                                        v-bind:value="client.id">-->
                                                <!--                                                        {{ client.c_name }}-->
                                                <!--                                                    </option>-->
                                                <!--                                                </b-form-select>-->
                                                <v-select :options="clients"
                                                          label="c_name"
                                                          :reduce="(option) => option.id"
                                                          placeholder="--Please Select An Option--"
                                                          v-model="form.client_id">
                                                    <template class="single-option" slot="option" slot-scope="option">
                                                        <option v-bind:value="option.id">
                                                            {{ option.c_name }} - {{ option.c_address }}
                                                        </option>
                                                    </template>
                                                </v-select>
                                            </b-form-group>
                                            <!--                                            <b-form-group id="project_owner" label="Project Owner" label-for="project_owner">-->
                                            <!--                                                <b-form-input-->
                                            <!--                                                    id="project_owner"-->
                                            <!--                                                    v-model="form.project_owner"-->
                                            <!--                                                    :class="{'is-invalid': form.errors.has('project_owner')}"-->
                                            <!--                                                    type="text"-->
                                            <!--                                                    placeholder="Enter your project owner"-->
                                            <!--                                                ></b-form-input>-->
                                            <!--                                            </b-form-group>-->
                                        </b-col>
                                        <b-col md="6">
                                            <b-form-group
                                                id="project_name"
                                                label="Project Name"
                                                label-for="project_name">
                                                <b-form-input
                                                    id="name"
                                                    v-model="form.project_name"
                                                    :class="{'is-invalid': form.errors.has('project_name')}"
                                                    type="text"
                                                    placeholder="Enter your project name"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="6">
                                            <b-form-group id="owner_phone" label="Owner Phone" label-for="owner_phone">
                                                <b-form-input
                                                    id="owner_phone"
                                                    v-model="form.owner_phone"
                                                    :class="{'is-invalid': form.errors.has('owner_phone')}"
                                                    type="text"
                                                    placeholder="Enter project owner's phone number"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="6">
                                            <b-form-group id="project_location" label="Project Location" label-for="project_location">
                                                <b-form-input
                                                    id="project_location"
                                                    v-model="form.project_location"
                                                    :class="{'is-invalid': form.errors.has('project_location')}"
                                                    type="text"
                                                    placeholder="Enter project's location"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-row>
                                        <b-col md="12" class="d-flex justify-content-end">
                                            <b-button-group>
                                                <b-button v-b-tooltip.hover.top="'Save'" type="submit" size="sm" variant="outline-primary"> Save <b-icon icon="file-earmark-post-fill" scale="1" shift-v="1.25" aria-hidden="true"></b-icon>
                                                </b-button>
                                                <b-button v-b-tooltip.hover.bottom="'Reset'" type="reset" size="sm"> Reset <b-icon icon="arrow-clockwise" animation="spin" font-scale="1"></b-icon>
                                                </b-button>
                                                <b-button v-b-tooltip.hover.bottom="'Close'" type="button" size="sm" variant="danger" v-b-toggle.my-collapse> Close <b-icon icon="x-diamond" scale="1" shift-v="1.25" aria-hidden="true"></b-icon>
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
                                 :items="projects"
                                 :per-page="perPage"
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
                                <b-link ml="4" class="text-primary" :to="`/view-project/${row.item.id}`"><b-icon icon="eye" scale="1.25" shift-v="1.25" aria-hidden="true"></b-icon>
                                </b-link><span id="devide">|</span>
                                <b-link ml="4" class="text-primary" :to="`/edit-project/${row.item.id}`"><b-icon icon="pencil-square" scale="1.25" shift-v="1.25" aria-hidden="true"></b-icon>
                                </b-link><span id="devid">|</span>
                                <b-link class="text-danger" @click="remove(row.item.id)">
                                    <b-icon icon="trash2-fill" scale="1.25" shift-v="1.25" aria-hidden="true"></b-icon>
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
    import Datatable from '../../common/datatable';
    export default {
        components: { Datatable },
        name: "manage",
        data() {
            return {
                form: new Form({
                    id: null,
                    client_id: null,
                    project_name: null,
                    owner_phone: null,
                    owner_image: null,
                    project_location: null,
                }),
                show: false,
                hidenseek: true,
                rawInput: null,
                items: [],
                clients: [],
                totalList: 1,
                totalRows: 1,
                perPage: 5,
                currentPage:1,
                pageOptions: [5, 10, 15],
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
                    { key: 'client.c_name', label: 'Project Owner',  name: 'project_owner', sortable: true },
                    { key: 'owner_phone', label: 'Owner Phone',  name: 'owner_phone', sortable: true },
                    // { key: 'owner_image', label: 'Owner Image',  name: 'owner_image', sortable: true },
                    { key: 'project_location', label: 'Project Location',  name: 'project_location', sortable: true }, 'action']
            }
        },
        props: ["tbodyTrClass", "pageColSize", "searchColSize", "filterIgnoredFields", 'filterIncludedFields'],
        computed: {
            projects() {
                return this.$store.getters.projects
            },
            rows(){
                return this.projects.length
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
            this.$store.dispatch("getProjects");
            $('#pdf').tooltip();
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
            this.clientInfo();
        },
        watch: {
            selected: function (selected) {
                // this.visible = true;
                if (selected.length > 0)
                {
                    $(function () {
                        $('[data-toggle="tooltip"]').tooltip()
                    })
                    // document.querySelector('#display').style.display = 'block';
                }else
                {
                    $(function () {
                        $('[data-toggle="tooltip"]').tooltip('hide')
                    })
                    // document.querySelector('#display').style.display = 'none';
                }
                this.isSelected = (selected.length > 0);
                this.multiDelete = (selected.length === this.projects.length);
            },
            rawInput(newVal, oldVal) {
                clearTimeout(this.$_timeout)
                this.$_timeout = setTimeout(() => {
                    this.filter = newVal;
                }, 150) // set this value to your preferred debounce timeout
            }
        },
        methods: {
            clear() {
                this.filter = ''
                this.rawInput = '';
            },
            addProject: function() {
                // console.log('test');
                let project = this;
                this.form.post('/add-project')
                    .then((response) => {
                        // console.log(data)
                        // Toast.fire({
                        //     icon: 'success',
                        //     title: 'Category Created successfully'
                        // })
                        toastr.success("Project Created successfully")
                        // $('#category-add').modal('hide');
                        document.querySelector('#display').style.display = 'none';
                        location.reload();
                        this.$store.dispatch("getProjects")
                        // category.$router.push("/projects");
                        project.form.project_name = null;
                        project.form.project_owner = null;
                        project.form.owner_phone = null;
                        project.form.project_location = null;
                    })
            },
            clientInfo: function () {
                const this_ = this;
                axios.get("/get-projects/").then((response) => {
                    this_.clients = response.data.client
                    console.log(response.data)
                }).catch(() => {

                })
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalList = filteredItems.length;
                this.currentPage = 1
            },
            // editCategory: function() {
            //     const this_ = this;
            //     axios.get("/show-category/" + this.$route.params.slug).then((response) => {
            //         this_.form.fill(response.data[1])
            //         // console.log(response.data[1])
            //     }).catch(() => {

            //     })
            // },
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
                        axios.get("remove-project/" + id).then((response) => {
                            this.$store.dispatch("getProjects"),
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
                return (this.projects.length < 1)
            },
            selectAll: function (event) {
                if (event.target.checked === false) {
                    this.selected = []
                    // document.querySelector('#display').style.display = 'none';
                } else {
                    // document.querySelector('#display').style.display = 'block';
                    this.projects.forEach((category) => {
                        if (this.selected.indexOf(category.id) === -1)
                        {
                            this.selected.push(category.id)
                        }
                    })
                }
            },
            removeItems: function (selected) {
                // console.log(selected)
                axios.post("/projects/remove-items",{data: selected}).then((response) => {
                    // console.log(response.data)
                    this.selected = [],
                        this.multiDelete = false,
                        this.isSelected = false,
                        this.$store.dispatch("getProjects")
                    toastr.success(response.data.total + ' Category has been deleted successfully !!')
                }).catch((error) => {

                })
            },
            generatePDF: function()
            {
                //initialize a new instance of jsPDF
                pdfDoc.autoTable({ html: '#example1' })
                // pdfDoc.html("get-projects",15,15)
                pdfDoc.save("pdf.pdf")
                $('#pdf').tooltip('hide')
            },
            deleteRow() {
                if (this.deletedItem !== undefined && this.deletedItem) {
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND, `/pmis/employee/families/${this.deletedItem.emp_family_id}`).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }

                        this.deletedItem = null;
                        this.loadData();
                        this.onReset();
                    }).catch(err => {
                        this.deletedItem = null;
                        console.log(err);
                    });
                }
            },
            removeRow(index) {
                this.projects.splice(index,1)
            }
        }
    }

</script>
<style scoped>
    .btn-group {
        height: 2rem;
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
