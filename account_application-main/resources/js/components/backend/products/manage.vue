<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card" v-if="hideForm">
                    <form @submit.prevent="addSupplier">
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_name">Product Name</label>
                                            <input class="form-control"
                                                   id="p_name"
                                                   :class="{'is-invalid': form.errors.has('p_name')}"
                                                   name="p_name"
                                                   placeholder="Enter Product Name"
                                                   type="text"
                                                   v-model="form.s_name">
                                            <has-error :form="form" field="p_name"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_sku">Product SKU</label>
                                            <input type="text"
                                                   name="p_sku"
                                                   id="p_sku"
                                                   placeholder="Enter Product Stock-Keeping Unit"
                                                   class="form-control"
                                                   :class="{'is-invalid': form.errors.has('p_sku')}"
                                                   v-model="form.p_sku">
                                            <has-error :form="form" field="p_sku"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_quantity">Product Quantity</label>
                                            <input class="form-control"
                                                   id="p_quantity"
                                                   :class="{'is-invalid': form.errors.has('p_quantity')}"
                                                   name="p_quantity"
                                                   placeholder="Enter Product Quantity"
                                                   type="text"
                                                   v-model="form.p_quantity">
                                            <has-error :form="form" field="p_quantity"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_price">Product Price</label>
                                            <input class="form-control"
                                                   id="p_price"
                                                   :class="{'is-invalid': form.errors.has('p_price')}"
                                                   name="p_price"
                                                   placeholder="Enter Product Actual Price"
                                                   type="number"
                                                   v-model="form.p_price">
                                            <has-error :form="form" field="p_price"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_size">Product Size</label>
                                            <input type="text"
                                                   name="p_size"
                                                   id="p_size"
                                                   placeholder="Enter Product Size"
                                                   class="form-control"
                                                   :class="{'is-invalid': form.errors.has('p_size')}"
                                                   v-model="form.p_size">
                                            <has-error :form="form" field="p_size"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_brand">Product Brand</label>
                                            <input class="form-control"
                                                   id="p_brand"
                                                   :class="{'is-invalid': form.errors.has('p_brand')}"
                                                   name="p_brand"
                                                   placeholder="Enter Product Brand"
                                                   type="text"
                                                   v-model="form.p_brand">
                                            <has-error :form="form" field="p_brand"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_barcode">Product Barcode</label>
                                            <input class="form-control"
                                                   id="p_barcode"
                                                   :class="{'is-invalid': form.errors.has('p_barcode')}"
                                                   name="p_barcode"
                                                   placeholder="Enter Product Barcode"
                                                   type="number"
                                                   v-model="form.p_barcode">
                                            <has-error :form="form" field="p_barcode"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_status">Product Status</label>
                                            <select name="p_status"
                                                    id="p_status"
                                                    class="form-control"
                                                    :class="{'is-invalid': form.errors.has('p_status')}"
                                                    v-model="form.p_status">
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                            <has-error :form="form" field="p_status"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_keyword">Product Keyword</label>
                                            <input class="form-control"
                                                   id="p_keyword"
                                                   :class="{'is-invalid': form.errors.has('p_keyword')}"
                                                   name="p_keyword"
                                                   placeholder="Enter Product Brand"
                                                   type="text"
                                                   v-model="form.p_keyword">
                                            <has-error :form="form" field="p_keyword"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="p_remarks">Product Remarks</label>
                                            <input class="form-control"
                                                   id="p_remarks"
                                                   :class="{'is-invalid': form.errors.has('p_remarks')}"
                                                   name="p_remarks"
                                                   placeholder="Remarks Here"
                                                   type="text"
                                                   v-model="form.p_remarks">
                                            <has-error :form="form" field="p_remarks"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="p_color">Product Color</label>
                                            <input type="text"
                                                   name="p_color"
                                                   id="p_color"
                                                   placeholder="Current Status"
                                                   class="form-control"
                                                   :class="{'is-invalid': form.errors.has('p_color')}"
                                                   v-model="form.p_color">
                                            <has-error :form="form" field="p_color"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="p_image">Product Image</label>
                                            <input type="file"
                                                   id="p_image"
                                                   name="p_image">
                                            <!-- <input class="form-control"
                                                   id="p_image"
                                                   :class="{'is-invalid': form.errors.has('p_image')}"
                                                   name="p_image"
                                                   placeholder="Enter Product Brand"
                                                   type="file"
                                                   v-model="form.p_image"> -->
                                            <has-error :form="form" field="p_image"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="btn-group float-right w-25" role="group" style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3);margin-top: 36px;">
                                            <button class="btn btn-primary mr-2"
                                                    title="Save Product"
                                                    type="submit">
                                                <i class="fas fa-save fa-1x"></i>
                                            </button>
                                            <button type="button"
                                                    class="btn btn-danger"
                                                    data-dismiss="modal"
                                                    data-toggle="tooltip"
                                                    @click="hide"
                                                    data-placement="top"
                                                    title="Hide Window">
                                                <i class="fas fa-window-close"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
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
                                        <span class="card-title text-uppercase">Products</span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <button data-toggle="tooltip"
                                                    data-placement="bottom"
                                                    title="Delete"
                                                    :disabled="!isSelected"
                                                    id="display"
                                                    class="btn btn-sm btn-outline-danger"
                                                    type="button">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button style="cursor: pointer;background-image: linear-gradient(#7a9cac, #6fb6d4)"
                                                    class="btn btn-sm border-0"
                                                    @click="generatePDF"
                                                    id="pdf"
                                                    data-toggle="tooltip"
                                                    data-placement="bottom"
                                                    title="Generate PDF">
                                                <i class="fas fa-file-pdf"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <span href="javascript:void(0)"
                                    class="btn btn-info float-right btn-sm"
                                    id="add"
                                    v-on:click="hideForm = !hideForm" style="box-shadow: 3px 2px 10px rgba(0,0,0,0.3);">
                                    <i class="fas fa-plus-circle"></i> Add
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-nowrap">
                                    <th>
                                        <input :disabled="emptyData()" @click="selectAll" style="cursor: pointer"
                                               type="checkbox" v-model="multiDelete">
                                    </th>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>SKU</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Size</th>
                                    <th>Brand</th>
                                    <th>Barcode</th>
                                    <th>Status</th>
                                    <th>Keyword</th>
                                    <th>Remarks</th>
                                    <th>Color</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <!-- <tbody>
                                <tr v-for="(supplier, i) in suppliers">
                                    <td>
                                        <input :value="supplier.id" style="cursor: pointer"
                                           type="checkbox" v-model="selected">
                                    </td>
                                    <td>{{ ++i }}</td>
                                    <td>{{ supplier.s_name }}</td>
                                    <td>{{ supplier.s_phone }}</td>
                                    <td>{{ supplier.slug }}</td>
                                    <td>{{ supplier.s_email }}</td>
                                    <td>{{ supplier.s_address }}</td>
                                    <td>{{ supplier.s_remarks }}</td>
                                    <td>
                                        <router-link class="text-cyan" :to="`/edit-supplier/${supplier.slug}`"><i class="fas fa-edit"></i></router-link>
                                        <span class="text-danger" @click="remove(supplier.slug)" style="cursor: pointer">
                                            <i class="fas fa-trash-alt"></i>
                                        </span>
                                    </td>
                                </tr>
                                <tr v-if="emptyData()">
                                    <td colspan="8">
                                        <h6 class="text-center text-danger">Data Not Found !!</h6>
                                    </td>
                                </tr>
                            </tbody> -->
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "manage",
    data() {
        return {
            form: new Form({
                s_name: null,
                s_phone: null,
                slug: null,
                s_email: null,
                s_address: null,
                s_remarks: null,
            }),
            hideForm: false,
            selected: [],
            multiDelete: false,
            isSelected: false,
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
        document.querySelector('#display').style.display = 'none';
        this.$store.dispatch("getSuppliers");
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
            this.multiDelete = (selected.length === this.suppliers.length);
        }
    },
    methods: {
        addSupplier: function() {
            // console.log('test');
            let supplier = this;
            this.form.post('/add-suppliers')
                .then((response) => {
                    // console.log(data)
                    // Toast.fire({
                    //     icon: 'success',
                    //     title: 'Category Created successfully'
                    // })
                    toastr.success("Supplier Created successfully")
                    // $('#category-add').modal('hide');
                    this.hideForm = false
                    this.$store.dispatch("getSuppliers")
                    // category.$router.push("/categories");
                    supplier.form.s_name = null;
                    supplier.form.s_phone = null;
                    supplier.form.s_email = null;
                    supplier.form.s_address = null;
                    supplier.form.s_remarks = null;
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
            return (this.suppliers.length < 1)
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
        }
    }
}

</script>
<style scoped>
    #pdf:hover{
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
</style>
