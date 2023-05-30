<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card" style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3);">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="card-title">Edit Category</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <form @submit.prevent="updateCategory">
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input class="form-control" id="name" :class="{'is-invalid': form.errors.has('name')}" name="name" placeholder="Enter Category Name" type="text" v-model="form.name">
                                            <has-error :form="form" field="name"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="remarks">Remarks</label>
                                            <textarea class="form-control" v-model="form.remarks" name="remarks" id="remarks" cols="30" :class="{'is-invalid': form.errors.has('remarks')}" placeholder="Wright Your Remarks" style="height: 37px"></textarea>
                                            <has-error :form="form" field="remarks"></has-error>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-group w-25" role="group" style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3);">
                                <button class="btn btn-sm btn-primary" title="Save Your Content" type="submit">
                                    <!--                                    <i class="fas fa-save fa-1x"></i>-->
                                    <i class="fas fa-sync-alt fa-1x"></i>
                                </button>
                                <router-link to="/categories" class="btn btn-secondary float-right btn-sm">
                                    <!--                                    <i class="fas fa-arrow-alt-circle-left"></i>-->
                                    <i class="fas fa-window-close"></i>
                                </router-link>
                                <!--                                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"-->
                                <!--                                        data-toggle="tooltip" data-placement="top" title="Close The Modal Window">-->
                                <!--                                    <i class="fas fa-window-close"></i>-->
                                <!--                                </button>-->
                            </div>
                        </div>
                    </form>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "manage",
    data: function() {
        return {
            form: new Form({
                id: null,
                name: null,
                remarks: null
            }),
            categoryIds: []
        }
    },
    computed: {
        categories() {
            return this.$store.getters.categories
        }
    },
    mounted() {
        // By Mounted Hit A Method of actions option of js file
        // Whenever Load The Component Data will get from database
        // By The actions option of js file
        this.$store.dispatch("getCategories");
        this.editCategory();
    },
    methods: {
        updateCategory: function() {
            // console.log('test');
            let this_ = this;
            this.form.post('/update-category')
                .then((response) => {
                    toastr.success("Category Updated successfully")
                    this_.$router.push("/categories")
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
        editCategory: function() {
            const this_ = this;
            axios.get("/show-category/" + this.$route.params.slug).then((response) => {
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
        emptyData() {
            return (this.categories.length < 1);
        }
    }
}

</script>
<style scoped>
</style>
