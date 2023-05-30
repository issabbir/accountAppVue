<template>
    <div>
        <b-container>
            <b-row id="display">
                <b-col md="12">
                    <b-card>
<!--                        {{ clients }}-->
                        <b-form @submit.prevent="updateProject">
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        id="client_id"
                                        label="Project Owner"
                                        label-for="client_id">
<!--                                        <b-form-select class="form-control"-->
<!--                                                       name="client_id" id="client_id"-->
<!--                                                       v-model="form.client_id">-->
<!--                                            <b-form-select-option :value="null">Please select an option</b-form-select-option>-->
<!--                                            <b-form-select-option v-for="(client, idx) in clients"-->
<!--                                                                  :key="idx"-->
<!--                                                                  v-bind:value="client.id">-->
<!--                                                {{ client.c_name }} - {{ client.c_address }}-->
<!--                                            </b-form-select-option>-->
<!--                                        </b-form-select>-->
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
        </b-container>
    </div>
</template>

<script>
    export default {
        name: "edit-project",
        data: function() {
            return {
                form: new Form({
                    id: null,
                    client_id: null,
                    project_name: null,
                    owner_phone: null,
                    owner_image: null,
                    project_location: null,
                }),
                categoryIds: [],
                clients: []
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
            this.$store.dispatch("getProjects");
            this.editProject();
            this.clientInfo();
        },
        methods: {
            updateProject: function() {
                // console.log('test');
                let this_ = this;
                this.form.post('/update-project')
                    .then((response) => {
                        toastr.success("Project Updated successfully")
                        this_.$router.push("/projects")
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
            editProject: function() {
                const this_ = this;
                axios.get("/edit-project/" + this.$route.params.id).then((response) => {
                    this_.form.fill(response.data[1])
                    console.log(response.data[1])
                }).catch(() => {

                })
            },
            clientInfo: function () {
                const this_ = this;
                axios.get("/get-projects/").then((response) => {
                    this_.clients = response.data.client
                    // console.log(response.data.client)
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
            }
        }
    }
</script>

<style scoped>

</style>
