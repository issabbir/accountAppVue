import home from "../components/backend/home";
import projects from "../components/backend/b-projects/manage";
import viewProject from "../components/backend/b-projects/view-project";
import editProject from "../components/backend/b-projects/edit-project";
import suppliers from "../components/backend/suppliers/manage";
import editSupplier from "../components/backend/suppliers/edit-supplier";
import customers from "../components/backend/b-customers/manage";
import editCustomer from "../components/backend/b-customers/edit-customer";
import creditVoucher from '../components/backend/b-voucher/credit-voucher/manage';
import debitVoucher from '../components/backend/b-voucher/debit-voucher/manage';
import viewCreditVoucher from '../components/backend/b-voucher/credit-voucher/view-credit-voucher';
import viewDebitVoucher from '../components/backend/b-voucher/debit-voucher/view-debit-voucher';
import debitVoucherHistory from '../components/backend/b-voucher/debit-voucher/debit-voucher-history';
import editDebitVoucher from '../components/backend/b-voucher/debit-voucher/edit-debit-voucher';
import editProduct from '../components/backend/products/edit-product';
import client from '../components/backend/b-client/manage';
import editClient from '../components/backend/b-client/edit-client';
import vendor from '../components/backend/b-vendor/manage';
import editVendor from '../components/backend/b-vendor/edit-vendor';
import addSlip from '../components/backend/b-vendor/add-slip';
import debitedAmount from '../components/backend/home';
import head from '../components/backend/b-head/manage';
import editHead from '../components/backend/b-head/edit-head';

export const routes = [
    {path: '/', component: home},
    {path: '/projects', component: projects},
    {path: '/view-project/:id', component: viewProject},
    {path: '/edit-project/:id', component: editProject},
    {path: '/suppliers', component: suppliers},
    {path: '/edit-supplier/:slug', component: editSupplier},
    {path: '/edit-customer/:slug', component: editCustomer},
    {path: '/customers', component: customers},
    {path: '/credit-voucher', component: creditVoucher},
    {path: '/debit-voucher', component: debitVoucher},
    {path: '/view-credit-voucher/:id', component: viewCreditVoucher},
    {path: '/view-debit-voucher/:id', component: viewDebitVoucher},
    {path: '/view-debit-voucher-history/:id', component: debitVoucherHistory},
    {path: '/edit-debit-voucher/:id', component: editDebitVoucher},
    {path: '/edit-product', component: editProduct},
    {path: '/client', component: client},
    {path: '/edit-client/:id', component: editClient},
    {path: '/vendor', component: vendor},
    {path: '/edit-vendor/:id', component: editVendor},
    {path: '/get-slips/:id', component: addSlip},
    {path: '/get-vendor-debit-amount/:id', component: debitedAmount},
    {path: '/head', component: head},
    {path: '/edit-head/:id', component: editHead}

    // {path: '/edit-post/:slug', component: editPost},
    // {path:'/show-category/:slug', component: editCategory}
];
