<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card" v-if="hideForm">
                    <!--                    @submit.prevent="addCategory"-->
                    <form @submit.prevent="addCategory">
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
                                    <i class="fas fa-save fa-1x"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" data-toggle="tooltip" @click="hide" data-placement="top" title="Close The Modal Window">
                                    <i class="fas fa-window-close"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card" style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3);">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <span class="card-title text-uppercase">Categories</span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <button data-toggle="tooltip" data-placement="bottom" title="Delete"
                                                    :disabled="!isSelected" @click="removeItems(selected)"
                                                    id="display" class="btn btn-sm btn-outline-danger" type="button">
                                                <i class="fas fa-trash"></i>
                                            </button>&nbsp;&nbsp;
                                            <button style="cursor: pointer;background-image: linear-gradient(#7a9cac, #6fb6d4)" class="btn btn-sm border-0"
                                                    @click="generatePDF" id="pdf" data-toggle="tooltip" data-placement="bottom" title="Generate PDF">
                                                <i class="fas fa-file-pdf"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!--                                data-toggle="modal" data-target="#category-add" -->
                                <span href="javascript:void(0)" class="btn btn-info float-right btn-sm" id="add" v-on:click="hideForm = !hideForm" style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3);">
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
                                        <input :disabled="emptyData()" @click="selectAll" style="cursor: pointer"
                                               type="checkbox" v-model="multiDelete">
                                    </th>
                                    <th>Sl. No.</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Remarks</th>
                                    <!--                                <th>Created At</th>-->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--                v-for="(category, i) in categories"            @click="visible = !visible"-->
                                <tr :v-for="(category, i) in categories">
                                    <td>
                                        <input :value="category.id" style="cursor: pointer"
                                           type="checkbox" v-model="selected">
                                    </td>
                                    <td>{{ ++i }}</td>
                                    <td>{{ category.name }}</td>
                                    <td>{{ category.slug }}</td>
                                    <td>{{ category.remarks }}</td>
                                    <td>
                                        <router-link :to="`/edit-category/${category.slug}`" class="text-cyan"><i class="fas fa-edit"></i></router-link>
                                        <span class="text-danger" @click="remove(category.slug)" style="cursor: pointer"><i class="fas fa-trash-alt"></i></span>
                                    </td>
                                </tr>
                                <!-- v-bind:style="!isSelected" id="display" v-if="visible && selectAll"-->
                                <!--                            <tr>-->
                                <!--                                <td colspan="7">-->
                                <!--                                    <button :disabled="!isSelected" id="display" @click="removeItems(selected)"-->
                                <!--                                            class="text-danger border-0" type="button">-->
                                <!--                                        <i class="fas fa-trash"></i>-->
                                <!--                                    </button>-->
                                <!--                                </td>-->
                                <!--                            </tr>-->
                                <tr v-if="emptyData()">
                                    <td colspan="6">
                                        <h6 class="text-center text-danger">Data Not Found !!</h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <!--        <data-table-->
        <!--            url="http://vue-datatable.test/ajax"-->
        <!--            :per-page="perPage"-->
        <!--            :columns="columns">-->
        <!--        </data-table>-->
        <!--        <div class="modal fade" id="category-add">-->
        <!--            <div class="modal-dialog">-->
        <!--                <div class="modal-content">-->
        <!--                    <div class="modal-header">-->
        <!--                        <h4 class="modal-title">Add Category</h4>-->
        <!--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
        <!--                            <span aria-hidden="true">&times;</span>-->
        <!--                        </button>-->
        <!--                    </div>-->
        <!--                    <form @submit.prevent="addCategory">-->
        <!--                        <div class="modal-body">-->
        <!--                            <div class="card-body">-->
        <!--                                <div class="form-group">-->
        <!--                                    <label for="name">Name</label>-->
        <!--                                    <input :class="{'is-invalid': form.errors.has('name')}"-->
        <!--                                           class="form-control" id="name"-->
        <!--                                           name="name" placeholder="Enter Category Name"-->
        <!--                                           type="text" v-model="form.name">-->
        <!--                                    <has-error :form="form" field="name"></has-error>-->
        <!--                                </div>-->
        <!--                                <div class="form-group">-->
        <!--                                    <label>Status</label>-->
        <!--                                    <div :class="{'is-invalid': form.errors.has('remarks')}" class="form-control">-->
        <!--                                        <div class="row">-->
        <!--                                            <div class="custom-control custom-radio" style="padding-left: 36px;">-->
        <!--                                                <input class="custom-control-input"-->
        <!--                                                       id="active" type="radio" v-model="form.remarks" value="1">-->
        <!--                                                <label for="active" class="custom-control-label pr-4"-->
        <!--                                                       style="cursor: pointer">Active</label>-->
        <!--                                            </div>-->
        <!--                                            <div class="custom-control custom-radio">-->
        <!--                                                <input class="custom-control-input"-->
        <!--                                                       id="inactive" type="radio" v-model="form.remarks" value="0">-->
        <!--                                                <label for="inactive" class="custom-control-label"-->
        <!--                                                       style="cursor: pointer">Inactive</label>-->
        <!--                                            </div>-->
        <!--                                        </div>-->
        <!--                                    </div>-->
        <!--                                    <has-error :form="form" field="remarks"></has-error>-->
        <!--                                </div>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                        <div class="modal-footer">-->
        <!--                            <div class="btn-group w-25" role="group" style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3);">-->
        <!--                                <button class="btn btn-sm btn-primary" data-placement="top" data-toggle="tooltip"-->
        <!--                                        title="Save Your Content"-->
        <!--                                        type="submit">-->
        <!--                                    <i class="fas fa-save fa-1x"></i>-->
        <!--                                </button>-->
        <!--                                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"-->
        <!--                                        data-toggle="tooltip" data-placement="top" title="Close The Modal Window">-->
        <!--                                    <i class="fas fa-window-close"></i>-->
        <!--                                </button>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </form>-->
        <!--                </div>-->
        <!--                &lt;!&ndash; /.modal-content &ndash;&gt;-->
        <!--            </div>-->
        <!--            &lt;!&ndash; /.modal-dialog &ndash;&gt;-->
        <!--        </div>-->
        <!-- /.modal -->
    </div>
</template>
<script>
export default {
    name: "manage",
    data() {
        return {
            form: new Form({
                name: null,
                slug: null,
                remarks: null,
            }),
            hideForm: false,
            selected: [],
            multiDelete: false,
            isSelected: false,
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
        document.querySelector('#display').style.display = 'none';
        this.$store.dispatch("getCategories");
        $('#pdf').tooltip()
        // this.editCategory();
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
            this.multiDelete = (selected.length === this.categories.length);
        }
    },
    methods: {
        addCategory: function() {
            // console.log('test');
            let category = this;
            this.form.post('/add-category')
                .then((response) => {
                    // console.log(data)
                    // Toast.fire({
                    //     icon: 'success',
                    //     title: 'Category Created successfully'
                    // })
                    toastr.success("Category Created successfully")
                    // $('#category-add').modal('hide');
                    this.hideForm = false
                    this.$store.dispatch("getCategories")
                    // category.$router.push("/categories");
                    category.form.name = null;
                    category.form.remarks = null;
                })
        },
        // editCategory: function() {
        //     const this_ = this;
        //     axios.get("/show-category/" + this.$route.params.slug).then((response) => {
        //         this_.form.fill(response.data[1])
        //         // console.log(response.data[1])
        //     }).catch(() => {

        //     })
        // },
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
        hide() {
            this.hideForm = false;
        },
        emptyData() {
            return (this.categories.length < 1)
        },
        selectAll: function (event) {
            if (event.target.checked === false) {
                this.selected = []
                // document.querySelector('#display').style.display = 'none';
            } else {
                // document.querySelector('#display').style.display = 'block';
                this.categories.forEach((category) => {
                    if (this.selected.indexOf(category.id) === -1)
                    {
                        this.selected.push(category.id)
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
        }
    }
}

</script>
<style scoped>
    #pdf:hover{
        color: #f9d6d5;
    }
</style>
