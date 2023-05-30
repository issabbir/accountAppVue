export default {
    state: {
        supplierData: [],
        projectData: [],
        creditVoucherData: [],
        debitVoucherData: [],
        productData: [],
        clientData: [],
        vendorData: [],
        headData: [],
        slipData: [],
    },
    getters: {
        projects(state) {
            return state.projectData
        },
        suppliers(state) {
            return state.supplierData
        },
        vouchers(state) {
            return state.creditVoucherData
        },
        dvouchers(state) {
            return state.debitVoucherData
        },
        products(state) {
            return state.productData
        },
        clients(state) {
            return state.clientData
        },
        vendors(state) {
            return state.vendorData
        },
        heads(state) {
            return state.headData
        },
        slips(state) {
            return state.slipData
        }
    },
    actions: {
        getProjects(data) {
            // console.log("text")
            axios.get("get-projects")
                .then((response) => {
                    // console.log(response.data)
                    data.commit("projects", response.data.projects)
                }).catch((error) => {

            })
        },
        getSuppliers(data) {
            // console.log("text")
            axios.get("get-suppliers")
                .then((response) => {
                    // console.log(response)
                    data.commit("suppliers", response.data.suppliers)
                }).catch((error) => {
            })
        },
        getcVouchers(data) {
            // console.log("text")
            axios.get("get-cvoucher")
                .then((response) => {
                    // console.log(response.data)
                    data.commit("vouchers", response.data.c_voucher)
                }).catch((error) => {
            })
        },
        getdVouchers(data) {
            console.log("text")
            axios.get("get-dvoucher")
                .then((response) => {
                    // console.log(response.data.d_voucher)
                    data.commit("dvouchers", response.data.d_voucher)
                }).catch((error) => {
            })
        },
        getProducts(data) {
            // console.log("text")
            axios.get("get-products")
                .then((response) => {
                    console.log(response.data.products)
                    data.commit("products", response.data.products)
                }).catch((error) => {
            })
        },
        getClients(data) {
            // console.log("text")
            axios.get("get-client")
                .then((response) => {
                    // console.log(response.data.clients)
                    data.commit("clients", response.data.clients)
                }).catch((error) => {
            })
        },
        getVendors(data) {
            // console.log("text")
            axios.get("get-vendors")
                .then((response) => {
                    // console.log(response.data)
                    data.commit("vendors", response.data.vendors)
                }).catch((error) => {
            })
        },
        getHeads(data) {
            // console.log("text")
            axios.get("get-heads")
                .then((response) => {
                    // console.log(response.data.head)
                    data.commit("heads", response.data.head)
                }).catch((error) => {
            })
        },
        getSlips(data) {
            // console.log("text")
            axios.get("get-slip")
                .then((response) => {
                    // console.log(response.data)
                    data.commit("slips", response.data[1])
                }).catch((error) => {
            })
        }
    },
    mutations: {
        projects(state, data) {
            state.projectData = data
        },
        suppliers(state, data) {
            state.supplierData = data
        },
        vouchers(state, data) {
            state.creditVoucherData = data
        },
        dvouchers(state, data) {
            state.debitVoucherData = data
        },
        products(state, data) {
            state.productData = data
        },
        clients(state, data) {
            state.clientData = data
        },
        vendors(state, data) {
            state.vendorData = data
        },
        heads(state, data) {
            state.headData = data
        },
        slips(state, data) {
            state.slipData = data
        }
    }
}
