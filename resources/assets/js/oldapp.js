"use strict";
require('./bootstrap');
window.Vue = require('vue');
const axios = require('axios');
window.progress = require('nprogress');
require('./alertui.min.js');
import 'es6-promise/auto'
import Vuex from 'vuex'
import _ from 'lodash'
window.$ = require('jquery');
Vue.use(Vuex);

import VueRouter from 'vue-router';
Vue.use(VueRouter);

// import Shop from './components/shop.vue';
// const baseUrl = "http://localhost:8888/customerportal/public/api/";


Vue.component('categories', require('./components/categories.vue'));
Vue.component('categoryitems', require('./components/categoryitems.vue'));
Vue.component('productdetails', require('./components/productdetails.vue'));
Vue.component('contentloader', require('./components/contentloader.vue'));
Vue.component('sidecart', require('./components/sidecart.vue'));
Vue.component('activityindicator', require('./components/activityindicator.vue'));
Vue.component('cities', require('./components/cities.vue'));
// var cart = Vue.component('cart', require('./components/cart.vue'));
var shop = Vue.component('shop', require('./components/shop.vue'));


// const instance = axios.create({
//     baseURL: "http://localhost:8888/customerportal/public/api/",
//     // timeout: 1200
// });

const baseUrl = "http://rewardsboxnigeria.com/customer_portal/public/api/";

const instance = axios.create({
    baseURL: "http://rewardsboxnigeria.com/customer_portal/public/api/",
    // timeout: 1200
});
const store = new Vuex.Store({
    state: {
        categories: [],
        products: [],
        current_product_id: null,
        modal: false,
        productdetails: {},
        sidecart: false,
        carttotal:0,
        productsloading: false,
        showitems: false,
        combo:[],
        cart: [],
        updatingcart: false,
        cities: [],
        cartadding:false,
        currency:{}
    },
    mutations: {
        categories (state, payload){
            state.categories = payload
        },
        products (state, payload){
            state.products = payload
        },
        current_product_id (state, id){
            state.current_product_id = id
        },
        modal (state, status){
            state.modal = status
        },
        productdetails (state, data){
            state.productdetails = data
        },
        editproductdetailsprice (state, price){
            state.productdetails.price = price
        },
        sidecart (state, status){
            state.sidecart = status
        },
        carttotal (state, carttotal){
            state.carttotal = carttotal
        },
        popcart (state, index){
            console.log(Object.keys(state.cart));
            state.cart.splice(index, 1);
            // state.cart = state.cart.filter(
            //     cart => cart.product_code != code
            // )
        },
        addtocart(state, cart){
            // state.cart.push(cart);
            state.cartadding = false;
            state.modal = false;
            alertui.notify('success',
                'Item added to Cart',
            );
            location.reload();
        },
        productsloading (state, status){
            state.productsloading = status
        },
        showitems (state, status){
            state.showitems = status
        },
        combopush (state, comboitem){
            state.combo.push(comboitem);
        },
        comboclear (state){
            state.combo = [];
        },
        opensidecart(state, status){
            state.sidecart = status;
        },
        updatingcart(state, status){
            state.updatingcart = status;
        },
        loadcities(state, cities){
            state.cities = cities;
        },
        addcurrency(state, currency){
            state.currency = currency
        }
    },
    actions: {
        popcart (context, code){
            context.commit('popcart', code)
        },
        categories (context, payload) {
            self = this;
            axios.get(`${baseUrl}get_product_category`)
                .then(function (res) {
                    // handle success
                    if(!res){
                        alertui.alert('Error', 'Failed to load');
                        return false;
                    }
                    // console.log(res.data.data);
                    context.commit('categories', res.data.data);
                    store.dispatch('products',res.data.data[0].category_id);
                    progress.done()
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    alertui.alert('Error', 'Apologies, an error occurred. Failed to Load Categories');
                    progress.done()
                })
            },
        products (context, payload){
            let url = `${baseUrl}get_product_category_content/${payload}`;
            context.commit('current_product_id', payload);

                // progress.start()
                context.commit('productsloading', true);
                context.commit('showitems', false);
                axios.post(url)
                    .then(function (res) {
                        // handle success
                        // console.log(res.data.data.data);
                        // self.categories = res.data.data;
                        if(!res){
                            alertui.alert('Error', 'Failed to load');
                            return false;
                        }
                        context.commit('products', res.data.data.data);
                        context.commit('productsloading', false);
                        context.commit('showitems', true);
                        // loadClose();
                        progress.done()
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                        // loadClose();
                        progress.done()
                    })


        },
        productdetails (context, payload){
            let url = `${baseUrl}get_product_details`;
            alertui.load('Loading...', function(loadClose, loadEl){
                // progress.start()
                instance.post(url, {code: payload.data.code})
                    .then(function ( res) {
                        // handle success
                        if(!res){
                            alertui.alert('Error', 'Failed to load');
                            return false;
                        }
                        if(res.data.data.data.status == 0){
                            alertui.alert('Error', 'Apologies! Something went wrong. Try again.');
                            loadClose();
                            progress.done();
                            return false;
                        }
                        if(res.data.data.data == null){
                            alertui.alert('Error', 'Apologies! Something went wrong. Try again.');
                            loadClose();
                            progress.done();
                            return false;
                        }
                        context.commit('modal',true);
                        context.commit('productdetails', res.data.data.data);
                        loadClose();
                        progress.done()
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                        loadClose();
                        progress.done()
                    })

            });
        },
        addtocart({ commit, state }, payload){
            let url = `${baseUrl}add_to_cart`;
            state.cartadding = true;
            console.log(state.cartadding )
                axios.post(url, {payload, signature:state.productdetails.signature})
                    .then(function ( res) {

                        // handle success
                        if(!res){
                            alertui.notify('Error', 'Failed to save to cart');
                            return false;
                        }
                        commit('addtocart', payload);
                        state.cartadding = false;
                        progress.done();
                    })
                    .catch(function (error) {
                        // handle error
                        // console.log(error);
                        alertui.notify('Error', 'Failed to save to cart');
                        state.cartadding = false;
                        progress.done()
                    })
        },
        loadcities(context,payload){
            let url = `${baseUrl}load_cites`;
            progress.start();
                axios.post(url, {id:payload})
                    .then(function ( res) {
                        // handle success
                        if(!res){
                            alertui.notification('Error', 'Failed to load cities');
                            return false;
                        }
                        context.commit('loadcities', res.data);
                        progress.done()
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                        progress.done()
                    });
        }
    }
});

if(document.getElementById("shop")){

new Vue({
    store,
    data: {
    },
    mounted: function(){
        progress.start()
        this.getCurrency()
    },
    computed: {
        products() {
            return this.$store.state.products
        }
    },
    methods: {
        getCurrency: function(){
            let self = this;
            axios.get('http://localhost:8888/customerportal/public/appcurrency')
                .then(function (res) {
                    // handle success
                    store.commit('addcurrency', res);
                    store.dispatch('categories');
                    if(!res){
                        alertui.alert('Error', 'Failed to load');
                        return false;
                    }
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    progress.done()
                })
        },
        sidecart(){
            store.commit('sidecart', true)
        },
        closemodal(){
            store.commit('modal',false)
        },
        productdetails(event){
            console.log(event.currentTarget.id)
            let code = event.currentTarget.id;
            this.$store.dispatch({
                type: 'productdetails',
                data:{
                    id: this.$store.state.current_product_id,
                    code
                }
            })
        }
    }
}).$mount('#shop')
}

if(document.getElementById("cart")){
    new Vue({
        el:'#cart',
        store,
        data: {
            price:null
        },
        methods: {
            updatecart: _.debounce( function(id, event){
                this.$store.commit('updatingcart', true);
                let self = this;
                axios.post(`${baseUrl}update_cart`,{id,qty:event.target.value})
                    .then(function (res) {
                        self.$store.commit('updatingcart', false);
                        // handle success
                        console.log(res);
                        if(!res){
                            alertui.notify('error', 'Failed to update cart');
                            return false;
                        }
                        if(res.data.status == '400'){
                            alertui.notify('error', res.data.data);
                            return false;
                        }
                        alertui.notify('success','Success cart updated');
                        location.reload();
                    })
                    .catch(function (error) {
                        self.$store.commit('updatingcart', false);
                        // handle error
                        console.log(error);
                        alertui.notify('error', 'Apologies, an error occurred. Failed update cart');
                        progress.done()
                    })
            }, 1200),

            popcartitem(id){
                this.$store.commit('updatingcart', true);
                let self = this;
                alertui.confirm('Confirm', 'Do you want to delete this item ? ', function() {
                        axios.post(`${baseUrl}delete_cart_item`, {id})
                            .then(function (res) {
                                self.$store.commit('updatingcart', false);
                                // handle success
                                console.log(res);
                                if (!res) {
                                    alertui.notify('error', 'Failed to update cart');
                                    return false;
                                }
                                if (res.data.status == '400') {
                                    alertui.notify('error', res.data.data);
                                    return false;
                                }
                                alertui.notify('success', 'Success cart updated');
                                location.reload();
                            })
                            .catch(function (error) {
                                self.$store.commit('updatingcart', false);
                                // handle error
                                console.log(error);
                                alertui.notify('error', 'Apologies, an error occurred. Failed update cart');
                                progress.done()
                            })
                    }, function(){
                        // Notify success callback button default Cancel
                        alertui.notify('default', 'Item is safe in your Cart');
                    }
                );
            },

            paywithoutshiping(number){
                alertui.confirm('Confirm Payment', `You have ${number} items in your cart. Do you want to proceed to payment?`, function () {
                    alertui.notify('success', 'Processing Payment...');
                    this.checkout_redeem();
                }.bind(this), function(){
                    alertui.notify('default', 'Continue shopping')
                })
            },
            checkout_redeem(){
                let self = this;
                let subtotal_value = $(".subtotalvalue").data('subtotal');
                console.log(subtotal_value);

                axios.post(`${baseUrl}redeem_cart`, { deliveryprice:this.deliveryprice})
                    .then(function (res) {
                        // handle success
                        if(!res){
                            alertui.alert('Error', 'Failed to load');
                            self.processingpayment = false;
                            return false;
                        }
                        if(res.data.status === 'fail'){
                            alertui.notify('error', res.data.data);
                            self.processingpayment = false;
                            return false;
                        }
                        if(res.data.status === 'apifail'){
                            alertui.notify('error', res.data.data.message);
                            self.processingpayment = false;
                            return false;
                        }
                        if(res.data.status === 'networkfail'){
                            alertui.notify('error', res.data.data);
                            self.processingpayment = false;
                            return false;
                        }
                        if(res.data.status === 'complete'){
                            alertui.notify('success', res.data.data);
                            self.processingpayment = false;
                            return false;
                        }
                        self.processingpayment = false;
                        progress.done()
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                        self.processingpayment = false;
                        alertui.notify('error', 'Apologies, an error occurred.');
                        progress.done()
                    })
            }
        }
    });
}

if(document.getElementById("checkoutpage")){
    new Vue({
        el: '#checkoutpage',
        store,
        data: {
            city: null,
            checkout: {
                firstname: '',
                lastname: '',
                email: '',
                phone: '',
                address: '',
                state_id: '',
                city_id:''
            },
            location: [],
            locationid: null,
            errors: [],
            busy: false,
            loadingstate: false,
            processingpayment: false,
            shippingandcost:false,
            deliveryprice:0
        },
        computed: {
          cities(){
              return store.state.cities;
          },
            currency(){
                return(this.$store.state.currency)
            }
        },
        mounted(){
            axios.get(`${baseUrl}appcurrency`)
                .then(function (res) {
                    // handle success
                    store.commit('addcurrency', res);
                    if(!res){
                        alertui.notify('Error', 'Failed to load');
                        return false;
                    }
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    progress.done()
                })
        },
        methods: {
            loadcities (){
                this.$store.dispatch('loadcities', this.checkout.state_id)
            },
            getdeliveryprice (address_id){
                this.shippingandcost = false;
                let self = this;
                axios.post(`${baseUrl}get_delivery_price`, {address_id})
                    .then(function (res) {
                        // handle success
                        if(!res){
                            alertui.alert('Error', 'Failed to load');
                            return false;
                        }
                        let calcprice = (parseInt($(".subtotal_value").data('subtotal')) + (res.data.data.data.price));
                        let newprice = new Intl.NumberFormat('en-GB').format(calcprice);
                        self.deliveryprice = res.data.data.data.price;
                        self.processingpayment = false;
                        self.shippingandcost = true;
                        $(".updatedprice").html(newprice);
                        $(".checkoutbtn").html("Pay");


                        progress.done()
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                        self.processingpayment = false;
                        alertui.alert('Error', 'Apologies, an error occurred.');
                        progress.done()
                    })
            },
            submitaddress(e){
                let self=this;
                e.preventDefault();
                this.busy = true;
                this.errors = [];
                setTimeout(function () {
                    if(self.validateform()){
                        self.postaddress();
                        self.busy = false;
                    }else{
                        self.busy = false;
                        document.querySelector('.section-title-3').scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                },1200)

            },
            validateform(){
                let retval = true;
                if (!this.checkout.firstname) {
                    this.errors.push('Firstname required.');
                    retval = false;
                }
                if (!this.checkout.lastname) {
                    this.errors.push('Lastname required.');
                    retval = false;
                }
                if (!this.checkout.email) {
                    this.errors.push('Email required.');
                    retval = false;
                }
                if (!this.checkout.phone) {
                    this.errors.push('Phone number required.');
                    retval = false;
                }
                if (!this.checkout.address) {
                    this.errors.push('Address required.');
                    retval = false;
                }
                if (!this.checkout.state_id) {
                    this.errors.push('State required.');
                    retval = false;
                }
                if (!this.checkout.city_id) {
                    this.errors.push('City required.');
                    retval = false;
                }
                return retval;
            },
            postaddress(){
                let url = `${baseUrl}add_order_address`;
                progress.start();
                axios.post(url, this.checkout)
                    .then(function ( res) {
                        console.log(res);
                        // handle success
                        if(!res){
                            alertui.notify('error', 'Failed to save address');
                            return false;
                        }
                        alertui.notify('success', 'Address saved');
                        progress.done()
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                        progress.done()
                    });
            },
            processpayment(){
                if(this.shippingandcost){
                    this.processingpayment = true;
                    this.checkout_redeem();
                    return false;
                }
                this.processingpayment = true;
                this.getlocation()
            },
            toggleaddress(){
                $(".addresscontainer").toggle();
            },
            getlocation(){
                if(!$("input[name='shipaddress']:checked").val()){
                    alertui.notify('default', 'Please choose an address');
                    this.processingpayment = false;
                }else{
                    this.getdeliveryprice($("input[name='shipaddress']:checked").val())
                }

            },
            checkout_redeem(){
                let self = this;
                let address_id = $("input[name='shipaddress']:checked").val();
                let subtotal_value = $(".subtotal_value").data('subtotal');
                console.log(subtotal_value);
                axios.post(`${baseUrl}redeem_cart`, {address_id, deliveryprice:this.deliveryprice})
                    .then(function (res) {
                        // handle success
                        if(!res){
                            alertui.alert('Error', 'Failed to load');
                            self.processingpayment = false;
                            return false;
                        }
                        if(res.data.status === 'fail'){
                            alertui.notify('error', res.data.data);
                            self.processingpayment = false;
                            return false;
                        }
                        if(res.data.status === 'complete'){
                            alertui.notify('success', res.data.data);
                            self.processingpayment = false;
                            return false;
                        }
                        self.processingpayment = false;
                        progress.done()
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                        self.processingpayment = false;
                        alertui.notify('error', 'Apologies, an error occurred.');
                        progress.done()
                    })
            }
        }
    });
}
if(document.getElementById("product")){
    new Vue({
        el: '#product',
        store,
        data: function(){
            return {
                showlocation:false,
                delivery_method_delivery: null
            }
        },
        methods: {
            deliverylocation(){
                if(this.delivery_method_delivery == 1){
                    this.showlocation = true
                }else{
                    this.showlocation = false
                }
            }
        }

    });
}