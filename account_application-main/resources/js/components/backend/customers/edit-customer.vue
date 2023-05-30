<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card" style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3);">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="card-title">Edit Supplier</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <form @submit.prevent="updateSupplier">
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="s_name">Name</label>
                                            <input class="form-control" id="s_name"
                                                   :class="{'is-invalid': form.errors.has('s_name')}"
                                                   name="s_name" placeholder="Enter Supliers Name" type="text"
                                                   v-model="form.s_name">
                                            <has-error :form="form" field="s_name"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="s_contact">Contact</label>
                                            <input type="tel" name="s_contact" id="s_contact"
                                                   maxlength="11" pattern="[0-9]{11}" placeholder="Enter Contact Number" class="form-control"
                                                   :class="{'is-invalid': form.errors.has('s_contact')}"
                                                   v-model="form.s_contact">
                                            <has-error :form="form" field="s_contact"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="s_email">E-Mail</label>
                                            <input type="tel" name="s_email" id="s_email"
                                                   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Enter Your E-Mail" class="form-control"
                                                   :class="{'is-invalid': form.errors.has('s_email')}"
                                                   v-model="form.s_email">
                                            <has-error :form="form" field="s_contact"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="s_address">Address</label>
                                            <textarea class="form-control" v-model="form.s_address" name="s_address" id="s_address" cols="30" :class="{'is-invalid': form.errors.has('s_address')}" placeholder="Wright Your Remarks" style="height: 37px"></textarea>
                                            <has-error :form="form" field="s_address"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="s_remarks">Remarks</label>
                                            <textarea class="form-control" v-model="form.s_remarks" name="s_remarks" id="s_remarks" cols="30" :class="{'is-invalid': form.errors.has('s_remarks')}" placeholder="Wright Your Remarks" style="height: 37px"></textarea>
                                            <has-error :form="form" field="s_remarks"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="btn-group float-right w-25" role="group" style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3);margin-top: 36px;">
                                            <button class="btn btn-primary" title="Save Your Content" type="submit">
                                                <i class="fas fa-sync-alt fa-1x"></i>
                                            </button>
                                            <router-link to="/suppliers" class="btn btn-secondary float-right">
                                                <i class="fas fa-window-close"></i>
                                            </router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</template>

<!--                        <div class="modal-footer">-->

<!--                        </div>-->
<script>
export default {
    name: "manage",
    data: function() {
        return {
            form: new Form({
                id: null,
                s_name: null,
                s_contact: null,
                slug: null,
                s_email: null,
                s_address: null,
                s_remarks: null,
            }),
            categoryIds: []
        }
    },
    computed: {
        suppliers() {
            return this.$store.getters.suppliers
        }
    },
    mounted() {
        // By Mounted Hit A Method of actions option of js file
        // Whenever Load The Component Data will get from database
        // By The actions option of js file
        this.$store.dispatch("getCategories");
        this.editSupplier();
    },
    methods: {
        updateSupplier: function() {
            // console.log('test');
            let this_ = this;
            this.form.post('/update-supplier')
                .then((response) => {
                    toastr.success("Supplier Updated successfully")
                    this_.$router.push("/suppliers")
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
        editSupplier: function() {
            const this_ = this;
            axios.get("/show-suppliers/" + this.$route.params.slug).then((response) => {
                this_.form.fill(response.data[1])
                // console.log(response.data[1])
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
