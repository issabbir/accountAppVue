<template>
    <div>
        <b-container>
<!--            <b-collapse id="my-collapse">-->
                <b-row id="display">
                    <b-col md="12">
                        <b-card title="Add Head">
                            <hr style="margin-top: 2rem; border-top: 1px dashed #0000002e;">
                            <b-card-text>
                                <b-form @submit.prevent="updateHead">
                                    <b-row>

                                        <b-col md="6">
                                            <b-form-group
                                                id="head_name"
                                                label="Head Name"
                                                label-for="head_name">
                                                <b-form-input
                                                    id="head_name"
                                                    v-model="form.head_name"
                                                    :class="{'is-invalid': form.errors.has('head_name')}"
                                                    type="text"
                                                    placeholder="Enter your head name"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>

                                        <b-col md="6">
                                            <b-form-group
                                                id="parent_id"
                                                label="Parent Head Name"
                                                label-for="parent_id">
                                                <b-form-select class="form-control"
                                                               name="parent_id" id="parent_id"
                                                               v-model="form.parent_id">
                                                    <b-form-select-option :value="null">Please select an option</b-form-select-option>
                                                    <b-form-select-option v-for="(head, idx) in headItems.parentHeads"
                                                                          :key="idx"
                                                                          v-bind:value="head.id">
                                                        {{ head.head_name }}
                                                    </b-form-select-option>
                                                </b-form-select>
                                            </b-form-group>
                                        </b-col>

                                        <b-col md="12" class="d-flex justify-content-end">
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
<!--            </b-collapse>-->
        </b-container>
    </div>
</template>
<script>
import { uuid } from 'vue-uuid' // Import uuid
import Multiselect from 'vue-multiselect'
export default {
    components: {
        Multiselect
    },
    name: "edit-head",
    data() {
        return {
            form: new Form({
                    id: null,
                    head_name: null,
                    parent_id: null,
                }),
                hidenseek: true,
                addCoupon: false,
                addCouponField: false,
                rawInput: null,
                items: [],
                projects: [],
                headItems: [],
                selected: '',
                selectedOpt: null,
        }
    },
    computed: {
        heads() {
            return this.$store.getters.heads
        },
        currentValue() {
            return this.projects.find(option => option.value === this.form.option)
        }
    },
    mounted() {
        // By Mounted Hit A Method of actions option of js file
        // Whenever Load The Component Data will get from database
        // By The actions option of js file
        // this.projectInfo();
        this.editHead();
        this.headData();
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
        updateHead: function() {
            // console.log('test');
            let this_ = this;
            this.form.post('/update-head')
                .then((response) => {
                    // console.log(data)
                    Toast.fire({
                        icon: 'success',
                        title: 'Vendor'
                    })
                    toastr.success("Head Updated successfully")
                    this_.$router.push("/head")
                })
        },
        addTag (newTag) {
            const tag = {
                project_name: newTag,
                id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.projects.push(tag)
            this.selectedOpt.push(tag)
        },
        editHead: function() {
            const this_ = this;
            axios.get("/edit-head/" + this.$route.params.id).then((response) => {
                this_.form.fill(response.data[1])
                // this_.projects = response.data[1].project;
                // console.log(response.data[1])
            }).catch(() => {

            })
        },
        headData: function() {
            const this_ = this;
            axios.get("/get-heads/").then((response) => {
                // this_.form.fill(response.data[1])
                // this_.headItemData = response.data;
                this_.headItems = response.data;
                // console.log(response.data.parentHeads)
            }).catch(() => {

            })
        },
        selectedInfo: function() {
            return self.$emit('input', $(this).val());
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
    .butt.btn-group {
        height: 2.3rem;
        margin-top: 2rem;
    }
</style>
