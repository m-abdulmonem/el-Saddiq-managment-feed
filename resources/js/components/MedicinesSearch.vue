<template>
    <div class="form-group">
        <label for="medicineSearch">بحث عن دواء</label>
        <input type="text" id="medicineSearch" class="form-control" v-model="keywords">
        <ul class="medicines-search-list list-unstyled" v-if="results.length > 0" >
            <li class="d-flex pb-3"><div class="col-4">الاسم</div> <div class="col-2">الكمية</div><div class="col-2">السعر</div><div class="col-4">الاستخدام</div></li>
            <li class="medicines-search-item d-flex"
                @click="create"
                v-for="result in results"
                :id="result.id"
                :name="result.name"
                :code="result.code"
                :price="result.sale_price"
                :purchase="result.purchase_price"
                :quantity="result.quantity"
                :stock="result.stock_in"
                :profit="result.profit">
                <div class="col-4"
                     :id="result.id"
                     :name="result.name"
                     :code="result.code"
                     :price="result.sale_price"
                     :purchase="result.purchase_price"
                     :quantity="result.quantity"
                     :stock="result.stock_in"
                     :profit="result.profit">{{ result.name }}
                </div>
                <div class="col-2"
                     :id="result.id"
                     :name="result.name"
                     :code="result.code"
                     :price="result.sale_price"
                     :purchase="result.purchase_price"
                     :quantity="result.quantity"
                     :stock="result.stock_in"
                     :profit="result.profit">{{ result.quantity}}</div>
                <div class="col-2"
                     :id="result.id"
                     :name="result.name"
                     :code="result.code"
                     :price="result.sale_price"
                     :purchase="result.purchase_price"
                     :quantity="result.quantity"
                     :stock="result.stock_in"
                     :profit="result.profit">{{ currencies(result.sale_price)}}</div>
                <div class="col-4"
                     :id="result.id"
                     :name="result.name"
                     :code="result.code"
                     :price="result.sale_price"
                     :purchase="result.purchase_price"
                     :quantity="result.quantity"
                     :stock="result.stock_in"
                     :profit="result.profit">{{ result.for}}</div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "ProductSearchComponent",
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
                ($("#medicineSearch").val().length < 1) ? $(".medicines-search-list").hide() : $(".medicines-search-list").show();
                this.search()
            },
        },
        mounted(){
            this.calc();
            this.total();
            this.delete();
            if (!$("#medicineSearch").is(":focus")) $(".medicines-search-list").hide()
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
            total() {
                let price = 0;
                $(".medicine-quantity").each(function (k) {
                    price += parseFloat($(this).val()) * parseFloat($(this).attr("price"))
                });
                $(".medicine-total-price").text(formatter.format(price));
                this.prices = price;
            },
            calc(){
                let vm = this;
                $("body").on("change",".medicine-quantity",function () {
                    if ($(this).val() < 1) $(this).closest("tr").remove();
                    const price = $(this).val() * $(this).attr("price");

                    $(this).closest("tr").find(".medicine-price").text(formatter.format(price)) ;
                    vm.total();
                });
                $("body").on("change",".purchase-price",function () {
                    const tr = $(this).closest("tr"),
                        price = ( parseFloat($(this).val()) / parseInt(tr.find(".quantity").val())) + parseFloat($(this).attr("profit"));
                    tr.find(".sale_price").val(price);
                });

            },
            search(){
                axios.get(`/ajax/products/medicines/search`,{params: {keywords: this.keywords}})
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
                let html = `<tr class="medicine-${e.target.getAttribute("id")}">`;
                        html += `<td>${e.target.getAttribute("code")}</td>`;
                        html += `<td><input type="hidden" class="id" name="medicines[][${e.target.getAttribute("price")}]" value="${e.target.getAttribute("id")}">${e.target.getAttribute("name")}</td>`;
                        html += `<td><input type="number" class="form-control medicine-quantity" style="width: 80px" name="quantity[]"  price="${e.target.getAttribute("price")}" value="1"></td>`;
                        if (parseInt($("meta[name=medicines]").attr("content")) === 1) {
                            html += `<td><input type="number" step="any" class="form-control purchase-price" style="width: 80px" name="purchase_price[]"  value="${e.target.getAttribute("purchase")}" profit="${e.target.getAttribute("profit")}"></td>`;
                            html += `<td><input type="number" step="any" class="form-control sale-price" style="width: 80px" name="sale_price[]"  value="${e.target.getAttribute("price")}"></td>`;
                        }else
                            html += `<td class="medicine-price">${formatter.format(e.target.getAttribute("price"))}</td>`;
                html += `<td><span id="product-${e.target.getAttribute("id")}" class="btn btn-danger btn-remove"><i class="fa fa-times"></i></span></td>`;
                    html += '<tr>';
                $("#medicinesTable tbody").append(html);

                $(".medicines-search-list").hide().prev().val("");

                this.total();
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

    .medicines-search-list{
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
