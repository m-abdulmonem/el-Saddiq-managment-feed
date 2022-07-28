<template>
    <div class="form-group">
        <label for="search">بحث عن منتج</label>
        <input type="text" id="search" class="form-control" v-model="keywords">

        <ul class="search-list list-unstyled" v-if="results.length > 0" >
            <li class="d-flex pb-3"><div class="col-6">الصنف</div> <div class="col-2">الكمية المتوفرة</div><div class="col-2">السعر</div><div class="col-2">الوزن</div></li>
            <li class="search-item d-flex"
                @click="create"
                v-for="result in results"
                :id="result.id"
                :num="result.num"
                :name="result.name"
                :code="result.code"
                :price="result.price"
                :stocks="JSON.stringify(result.stocks)"
                :quantity="result.quantity"
                :profit="result.profit"
                :discount="result.discount">
                <div class="col-6">{{ result.name }}</div>
                <div class="col-2">{{ result.quantity}}</div>
                <div class="col-2">{{ currencies(result.price)}}</div>
                <div class="col-2">{{ result.weight ? result.weight + " ك ": ""}}</div>
            </li>
        </ul>

    </div>
</template>

<script>
    export default {
        name: "ProductSearch",
        data(){
            return {
                keywords : null,
                results: [],
                currency: [],
                totalPrice: [],
            }
        },
        watch: {
            keywords (after,before){
                ($("#search").val().length < 1) ? $(".search-list").hide() : $(".search-list").show();
                this.search()
            },
        },
        mounted(){
            this.calc();
            this.total();
            this.delete();
            this.discount();
            if (!$("#search").is(":focus")) $(".search-list").hide()
        },
        methods: {
            currencies(num) {
                const formatter  = Intl.NumberFormat("ar-EG",{
                    'style' : 'currency',
                    currency: 'EGP',
                    minimumFractionDigits: 2
                });
                return this.currency = formatter.format(num)
            },
            discount(){
                let vm = this;
                $("body").on("change",".product-discount",function () {

                    if (parseFloat($(this).val()) > parseFloat($(this).attr("max")) ) {
                        $(this).val($(this).attr("max"));
                        swal(` عفوا لايمكن قبول هذا الخصم الخصم المتاح هو ${ vm.currencies($(this).attr("max")) } `,{
                            icon: "info",
                            timer: 3000
                        });
                    }
                    vm.total();
                })
            },
            total() {
                let price = 0,net = 0,quantity = 0,discount = 0;
                $(".priceInput").each(function (k) {
                    price += parseFloat($(this).val())
                });
                $(".netInput").each(function (k) {
                    net += parseFloat($(this).val())
                });
                $(".quantity").each(function (k) {
                    const profit = parseFloat($(this).val()) * parseFloat($(this).attr("profit"));
                    $("#profitInput").val((profit / 2));
                    quantity += parseFloat($(this).val())
                });
                $(".product-discount").each(function (k) {
                    discount += parseFloat($(this).val()) * parseFloat($(this).closest("tr").find(".quantity").val())
                });
                //hidden inputs
                $("#totalQuantity").val(quantity);
                $("#totalPrice").val(price);
                //text
                console.log();
                $(".total-price").text(formatter.format(price));
                $(".total-net").text(formatter.format(price-discount));
                //
                this.prices = price;
            },
            calc(){
                let vm = this;
                $("body").on("change",".quantity",function () {
                    if ($(this).val() < 1) $(this).closest("tr").remove();
                    const price = $(this).val() * $(this).attr("price");

                    if (parseInt($(this).val()) > parseInt($(this).attr("max"))) {
                        $(this).val($(this).attr("max"));
                        swal("عفوا الكمية المطلوبة اكبر من الموجودة",{
                            icon: "warning",
                            timer: 3000
                        });
                    }

                    const net = price - ($(this).val() * $(this).attr("discount"));
                    $(this).closest("tr").find(".price").text(formatter.format(price))
                        .closest("tr").find(".priceInput").val(price) ;

                    $(this).closest("tr").find(".net").text(formatter.format(net))
                        .closest("tr").find(".netInput").val(net) ;

                    $(this).parent().closest("tr").find(".product-discount").attr("max",(parseFloat($(this).attr("profit")) * parseFloat($(this).val())) /2);
                    vm.total();

                    if (vm.prices > parseFloat($("#credit").val())) {
                        $(this).val(parseInt($(this).val()) - 1);
                    }
                });

            },
            search(){
                axios.get(`/ajax/products/search`,{params: {keywords: this.keywords,id: $("#client").val()}})
                    .then((response) => this.results = response.data[0])
                    .catch(error => {})
            },
            delete(){
                let vm = this;
                $("body").on("click",".btn-remove",function (e) {
                    $(this).closest("tr").remove();
                    vm.total();
                })
            },
            create(e){
                let options = [], maxDiscount = parseFloat(e.target.getAttribute("profit"))/2;

                $.each(JSON.parse(e.target.getAttribute("stocks")),function (k,v) {
                    options.push(`<option value="${k}">${v}</option>`);
                });

                let html = `<tr class="product-${e.target.getAttribute("id")}">`;
                        html += `<th>${e.target.getAttribute("num")}</th>`;
                        html += `<td>${e.target.getAttribute("code")}</td>`;
                        html += `<td><input type="hidden" class="id" name="products[]" value="${e.target.getAttribute("id")}">${e.target.getAttribute("name")}</td>`;
                        html += `<td><select name="stock_id[]" id="stocks" class="form-control">${options.join()}</select></td>`;
                        html += `<td><input type="number" class="form-control quantity" style="width: 80px" max="${parseInt(e.target.getAttribute("quantity"))}" name="quantity[]" profit="${e.target.getAttribute("profit")}" discount="${e.target.getAttribute("discount") ?? 1}" price="${e.target.getAttribute("price")}" value="1"></td>`;
                        html += `<td>${e.target.getAttribute("quantity")}</td>`;
                        html += `<td><input type="hidden" value="${e.target.getAttribute("price")}" name="unitPrice[]">${formatter.format(e.target.getAttribute("price"))}</td>`;
                        html += `<td>${parseInt(e.target.getAttribute("admin")) === 1 ? '<input type="number" step="any" style="width: 80px" name="product_discount" max="'+ maxDiscount +'"  class="form-control product-discount">' :formatter.format(0)}</td>`;
                        html += `<td><input type="hidden" class="priceInput" name="price[]" value="${e.target.getAttribute("price")}"><span class="price">${formatter.format(e.target.getAttribute("price"))}</span></td>`;
                        html += `<td><input type="hidden" class="netInput" name="net[]" value="${e.target.getAttribute("price")}"><span class="net">${formatter.format(e.target.getAttribute("price"))}</span></td>`;
                        html += `<td><span id="product-${e.target.getAttribute("id")}" class="btn btn-danger btn-remove"><i class="fa fa-times"></i></span></td>`;
                html += '<tr>';
                $("#productsTable").append(html);
                this.total();

                $(".search-list").hide().prev().val("");
                $(".btn-paid").data("returned",false);
                if ( this.prices >= parseFloat($("#credit").val()))
                    $(`.products-${e.target.getAttribute("id")}`)

            }
        }
    }
</script>

<style scoped >
    .form-group{
        position: relative;
    }
    #search:focus{
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        border-bottom: 0;
    }

    .search-list{
        background: #fff;
        display: block;
        min-height: 30px;
        position: absolute;
        padding: 1.5rem .75rem;
        width: 100%;
        margin-bottom: 1rem;
        z-index: 1;
        border: 1px solid #ced4da;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        font-weight: bold;
        cursor: pointer;
    }
    li:nth-child(even){
        color:#117a8b;
    }
    li:nth-child(odd){
        color:#212529;
    }
</style>
