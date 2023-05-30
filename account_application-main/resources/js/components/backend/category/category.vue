<template>
    <div class="container">
        <div class="card" style="box-shadow: 5px 5px 5px rgba(0,0,0,0.3);">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="card-title">Categoriessd</h3>
                            </div>
                            <div class="col-md-6">
                                <span href="javascript:void(0)" class="btn btn-info float-right btn-sm" id="add" data-toggle="modal" data-target="#category-add" style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3);">
                                    <i class="fas fa-plus-circle"></i> Add
                                </span>
                                <!--                                <router-link to="/categories" class="btn btn-secondary float-right btn-sm mr-1"-->
                                <!--                                             style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3); width: 60px">-->
                                <!--                                    <i class="fas fa-arrow-alt-circle-left"></i>-->
                                <!--                                </router-link>-->
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox">
                                    </th>
                                    <th>Sl. No.</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- v-for="(category, i) in categories" -->
                                <tr>
                                    <!-- <td>
                                            <input type="checkbox" :value="category.id" v-model="categoryIds">
                                        </td>
                                        <td>{{ ++i }}</td>
                                        <td>{{ category.name }}</td>
                                        <td>{{ category.slug }}</td>
                                        <td><span class="badge" :class="statusColor(category.status)">{{ statusName(category.status) }}</span></td>
                                        <td>{{ category.created_at | time}}</td>
                                        <td>
                                            <!-                                    ${category.slug}
                                            <router-link class="text-cyan" :to="`/edit-category/${category.slug}`"><i class="fas fa-edit"></i></router-link>
                                            <span class="text-danger" style="cursor: pointer" @click="remove(category.slug)"><i class="fas fa-trash-alt"></i></span>
                                        </td> -->
                                </tr>
                                <!-- v-if="emptyData()" -->
                                <tr>
                                    <td colspan="7">
                                        <h6 class="text-center text-danger">Data Not Found !!</h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!--        <data-table-->
            <!--            url="http://vue-datatable.test/ajax"-->
            <!--            :per-page="perPage"-->
            <!--            :columns="columns">-->
            <!--        </data-table>-->
            <div class="modal fade" id="category-add">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Category</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- <form @submit.prevent="addCategory">
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input :class="{'is-invalid': form.errors.has('name')}" class="form-control" id="name" name="name" placeholder="Enter Category Name" type="text" v-model="form.name">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <div :class="{'is-invalid': form.errors.has('status')}" class="form-control">
                                        <div class="row">
                                            <div class="custom-control custom-radio" style="padding-left: 36px;">
                                                <input class="custom-control-input" id="active" type="radio" v-model="form.status" value="1">
                                                <label for="active" class="custom-control-label pr-4" style="cursor: pointer">Active</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" id="inactive" type="radio" v-model="form.status" value="0">
                                                <label for="inactive" class="custom-control-label" style="cursor: pointer">Inactive</label>
                                            </div>
                                        </div>
                                    </div>
                                    <has-error :form="form" field="status"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-group w-25" role="group" style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3);">
                                <button class="btn btn-sm btn-primary" data-placement="top" data-toggle="tooltip" title="Save Your Content" type="submit">
                                    <i class="fas fa-save fa-1x"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" data-toggle="tooltip" data-placement="top" title="Close The Modal Window">
                                    <i class="fas fa-window-close"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
    </div>
</template>
<script>
export default {
    name: "home",
    name: "manage",
    // data: function() {
    // return {
    //     form: new Form({
    //         name: null,
    //         status: null
    //     }),
    //     categoryIds: []
    // }
    // },
    computed: {
        // categories() {
        //     return this.$store.getters.categories
        // }
    },
    mounted() {
        // By Mounted Hit A Method of actions option of js file
        // Whenever Load The Component Data will get from database
        // By The actions option of js file
        // this.$store.dispatch("getCategories");
        // this.editCategory();
    },
    methods: {
        // addCategory: function() {
        //     // console.log('test');
        //     let category = this;
        //     this.form.post('/add-category')
        //         .then((response) => {
        //             // console.log(data)
        //             // Toast.fire({
        //             //     icon: 'success',
        //             //     title: 'Category Created successfully'
        //             // })
        //             toastr.success("Category Created successfully", {
        //                 "closeButton": true,
        //                 "timeOut": "5000",
        //                 "progressBar": true
        //             })
        //             $('#category-add').modal('hide');
        //             this.$store.dispatch("getCategories")
        //             // category.$router.push("/categories");
        //             category.form.name = null;
        //             category.form.status = null;
        //         })
        // },
        // editCategory: function() {
        //     const this_ = this;
        //     axios.get("/show-category/" + this.$route.params.slug).then((response) => {
        //         this_.form.fill(response.data[1])
        //         // console.log(response.data[1])
        //     }).catch(() => {

        //     })
        // },
        // statusName: function(status) {
        //     let data = { 0: "Inactive", 1: "Active" }

        //     return data[status];
        // },
        // statusColor: function(status) {
        //     let data = { 0: "badge-danger", 1: "badge-success" }

        //     return data[status];
        // },
        // remove: function(slug) {
        //     const swalWithBootstrapButtons = Swal.mixin({
        //         customClass: {
        //             confirmButton: 'btn btn-success',
        //             cancelButton: 'btn btn-danger'
        //         },
        //         buttonsStyling: false
        //     })

        //     swalWithBootstrapButtons.fire({
        //         title: 'Are you sure?',
        //         text: "You won't be able to revert this!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonText: 'Yes, delete it!',
        //         cancelButtonText: 'No, cancel!',
        //         reverseButtons: true
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             axios.get("remove-category/" + slug).then((response) => {
        //                 this.$store.dispatch("getCategories"),
        //                     // toastr.success('Category Deleted Successfully !!')
        //                     swalWithBootstrapButtons.fire(
        //                         'Deleted!',
        //                         'Your file has been deleted.',
        //                         'success'
        //                     )
        //             }).catch((error) => {

        //             })
        //         } else if (
        //             /* Read more about handling dismissals below */
        //             result.dismiss === Swal.DismissReason.cancel
        //         ) {
        //             swalWithBootstrapButtons.fire(
        //                 'Cancelled',
        //                 'Your imaginary file is safe :)',
        //                 'error'
        //             )
        //         }
        //     })
        // },
        // emptyData() {
        //     return (this.categories.length < 1)
        // }
    }
}

</script>
<style scoped>
</style>
