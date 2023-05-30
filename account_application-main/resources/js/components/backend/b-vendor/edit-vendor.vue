<template>
    <div>
        <b-container>
            <b-row >
                <b-col md="12">
                    <b-card title="Edit Vendor">
                        <hr style="margin-top: 2rem; border-top: 1px dashed #0000002e;">
                        <b-card-text>
                            {{ form.project_id }}
                            <b-form @submit.prevent="updateVendor">
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            id="v_name"
                                            label="Name"
                                            label-for="v_name">
                                            <b-form-input
                                                id="v_name"
                                                v-model="form.v_name"
                                                :class="{'is-invalid': form.errors.has('v_name')}"
                                                type="text"
                                                placeholder="Enter your client name"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group id="v_phone" label="Phone" label-for="v_phone">
                                            <b-form-input
                                                id="v_phone"
                                                type="number"
                                                v-model="form.v_phone"
                                                maxlength="11" pattern="[0-9]{11}"
                                                :class="{'is-invalid': form.errors.has('v_phone')}"
                                                placeholder="Enter your phone..."
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group id="v_email" label="E-Mail" label-for="v_email">
                                            <b-form-input
                                                id="v_email"
                                                type="email"
                                                v-model="form.v_email"
                                                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                                :class="{'is-invalid': form.errors.has('v_email')}"
                                                placeholder="Enter your E-Mail..."
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group id="v_address" label=" Address" label-for="v_address">
                                            <b-form-textarea
                                                id="v_address"
                                                v-model="form.v_address"
                                                :class="{'is-invalid': form.errors.has('v_address')}"
                                                placeholder="Wright Your Address"
                                                style="height: 2.3rem"
                                            ></b-form-textarea>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group id="v_type" label="Vendor Type" label-for="v_type" v-slot="{ ariaDescribedby }">
                                            <b-form-radio-group
                                                id="radio-group-1"
                                                v-model="selected"
                                                :aria-describedby="ariaDescribedby"
                                                name="radio-options"
                                                style="border: 1px solid #322e2e40; padding: .5rem; border-radius: 4px;">
                                                <b-form-radio v-model="form.v_type" name="v_type" value="supplier">Supplier</b-form-radio>
                                                <b-form-radio v-model="form.v_type" name="v_type" value="contractor">Contractor</b-form-radio>
                                            </b-form-radio-group>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
<!--                                        <div>-->
<!--                                            <label class="typo__label">Project Name</label>-->
<!--                                            <multiselect v-model="form.project_id"-->
<!--                                                         tag-placeholder="Add this as new tag"-->
<!--                                                         placeholder="Please select a proejct name"-->
<!--                                                         label="project_name" track-by="id"-->
<!--                                                         :options="projects" :multiple="true" @change="selectedInfo"-->
<!--                                                         :taggable="true" @tag="addTag"></multiselect>-->
<!--                                        </div>-->
                                        <b-form-group
                                            id="project_id"
                                            label="Project Name"
                                            label-for="project_id">
                                            <b-form-select class="form-control"
                                                           name="project_id" id="project_id"
                                                           v-model="form.project_id">
                                                <b-form-select-option :value="null">Please select an option</b-form-select-option>
                                                <b-form-select-option v-for="(project, idx) in projects"
                                                                      :key="idx"
                                                                      v-bind:value="project.id">
                                                    {{ project.project_name }}
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
                                            <b-link v-b-tooltip.hover.bottom="'Back'"
                                                      type="button" size="sm"
                                                      variant="danger"
                                                      id="back"
                                                      :to="`/vendor`" class="btn btn-danger">
                                                <b-icon icon="back" scale="1"
                                                        shift-v="1.25" aria-hidden="true">
                                                </b-icon> <span>Back</span> </b-link>
                                        </b-button-group>
                                    </b-col>
                                </b-row>
                            </b-form>
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>

<!--                        <b-row>-->
<!--                            <b-card title="Edit Vendor">-->
<!--                                <hr style="margin-top: 2rem; border-top: 1px dashed #0000002e;">-->
<!--                                <b-card-text>-->
<!--                                    <form ref="form" @submit.prevent="assignProject">-->
<!--                                        <b-row>-->
<!--                                            <b-col md="6" class="offset-3">-->
<!--                                                <b-form-group-->
<!--                                                    id="project_id"-->
<!--                                                    label="Project Name"-->
<!--                                                    label-for="project_id">-->
<!--                                                    <b-form-select class="form-control"-->
<!--                                                                   name="project_id" id="project_id"-->
<!--                                                                   v-model="selectedOpt">-->
<!--                                                        <b-form-select-option :value="null">Please select an option</b-form-select-option>-->
<!--                                                        <b-form-select-option v-for="(project, idx) in projects"-->
<!--                                                                              :key="idx"-->
<!--                                                                              v-bind:value="project.id">-->
<!--                                                            {{ project.project_name }}-->
<!--                                                        </b-form-select-option>-->
<!--                                                    </b-form-select>-->
<!--                                                </b-form-group>-->
<!--                                            </b-col>-->

<!--                                            &lt;!&ndash; Emulate built in modal footer ok and cancel button actions &ndash;&gt;-->
<!--                                            <hr style="margin-top: 2rem; border-top: 1px dashed #0000002e;">-->
<!--                                            <b-col md="12" class="d-flex justify-content-end">-->
<!--                                                <b-button-group size="sm">-->
<!--                                                    <b-button type="submit" size="sm" variant="outline-primary">-->
<!--                                                        <b-icon icon="file-earmark-post-fill"-->
<!--                                                                scale="1" shift-v="1.25"-->
<!--                                                                aria-hidden="true">-->
<!--                                                        </b-icon> Save-->
<!--                                                    </b-button>-->
<!--                                                </b-button-group>-->
<!--                                            </b-col>-->
<!--                                        </b-row>-->
<!--                                    </form>-->
<!--                                </b-card-text>-->
<!--                            </b-card>-->
<!--                        </b-row>-->
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
    name: "edit-vendor",
    data() {
        return {
            form: new Form({
                    id: null,
                    project_id: null,
                    v_name: null,
                    v_phone: null,
                    v_email: null,
                    v_address: null,
                    v_type: null,
                }),
                hidenseek: true,
                addCoupon: false,
                addCouponField: false,
                rawInput: null,
                items: [],
                projects: [],
                selected: '',
                selectedOpt: null,
        }
    },
    computed: {
        customers() {
            return this.$store.getters.customers
        },
        currentValue() {
            return this.projects.find(option => option.value === this.form.option)
        }
    },
    mounted() {
        // By Mounted Hit A Method of actions option of js file
        // Whenever Load The Component Data will get from database
        // By The actions option of js file
        this.projectInfo();
        this.editVendor();
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
        updateVendor: function() {
            // console.log('test');
            let this_ = this;
            this.form.post('/update-vendor')
                .then((response) => {
                    // console.log(data)
                    Toast.fire({
                        icon: 'success',
                        title: 'Vendor'
                    })
                    toastr.success("Vendor Updated successfully")
                    this_.$router.push("/vendor")
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
        projectInfo: function() {
            const this_ = this;
            axios.get("/get-vendors/").then((response) => {
                // this_.form.fill(response.data[1])
                response.data.projects.map(function(e) {
                    this_.projects.push(e);
                    // this_.projects = response.data.projects;
                    console.log(e)
                });
            }).catch(() => {

            })
        },
        editVendor: function() {
            const this_ = this;
            axios.get("/edit-vendor/" + this.$route.params.id).then((response) => {
                this_.form.fill(response.data[1])
                // this_.projects = response.data[1].project;
                // console.log(response.data[1].project)
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
    .row {
        display: block;
    }
    .row[data-v-31758656] {
         display: flex!important;
    }
    .butt.btn-group {
        height: 2.3rem;
        margin-top: 2rem;
    }
</style>
