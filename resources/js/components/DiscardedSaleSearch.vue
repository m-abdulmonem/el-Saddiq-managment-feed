<template>
    <div class="form-group">
        <label for="search">بحث عن فاتورة المرتجع</label>
        <input type="text" id="search" class="form-control" v-model="keywords">
        <ul class="search-list list-unstyled" v-if="results.length > 0" >
            <li class="d-flex pb-3"><div class="col-3">رقم الفاتورة</div> <div class="col-9">العميل</div></li>
            <li class="search-item d-flex pt-2 pb-2" style="cursor: pointer;" v-for="result in results" :id="result.id" @click="list">
                <div class="col-3"
                     :client="result.client"
                     :client-id="result.client_id"
                     :disocunt="result.discount"
                     :id="result.id"
                     :number="result.number"
                     :price="result.price"
                     :product="JSON.stringify(result.product)"
                     :quantity="result.quantity"
                     :status="result.status"
                     :stock="JSON.stringify(result.stock)"
                >{{ result.number}}</div>
                <div class="col-9"
                     :client="result.client"
                     :client-id="result.client_id"
                     :disocunt="result.discount"
                     :id="result.id"
                     :number="result.number"
                     :price="result.price"
                     :product="JSON.stringify(result.product)"
                     :quantity="result.quantity"
                     :status="result.status"
                     :stock="JSON.stringify(result.stock)"
                >{{ result.client}}</div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "DiscardedSaleSearch",
        data(){
            return {
                keywords : null,
                results: [],
            }
        },

        watch: {
            keywords (after,before){
                ($("#search").val().length < 1) ? $(".search-list").hide() : $(".search-list").show();
                this.search()
            },
        },
        methods: {
            search(){
                axios.get(`ajax/client/invoices/returned/invoices/search`,{params: {keywords: this.keywords}})
                    .then((response) => this.results = response.data[0])
                    .catch(error => {})
            },
            list(e){
                let i = 0,options = [],net,total;

                $("#client").select2("trigger", "select", {
                    data: { id: e.target.getAttribute("client-id"),text: e.target.getAttribute("client") }
                });

                $("#status").val(e.target.getAttribute("status")).change();
                $.each(JSON.parse(e.target.getAttribute("stock")),function (k,v) {
                    options.push(`<option value="${k}">${v}</option>`);
                });

                console.log(options)

                $.each(JSON.parse(e.target.getAttribute("product")),function (k,v) {
                    let html = `<tr class="product-${v.id}">`;
                        html += `<th>${i+1}</th>`;
                        html += `<td>${v.code}</td>`;
                        html += `<td><input type="hidden" class="id" name="products[]" value="${v.id}">${v.name}</td>`;
                        html += `<td><select name="stock_id[]" id="stocks" class="form-control">${options.join()}</select></td>`;
                        html += `<td><input type="number" class="form-control quantity" style="width: 80px" max="${parseInt(v.quantity)}" name="quantity[]" profit="${v.profit}" discount="${v.discount ?? 1}" price="${v.price}" value="${v.quantity}"></td>`;
                        html += `<td>${v.quantity * v.weight}</td>`;
                        html += `<td><input type="hidden" value="${v.price}" name="unitPrice[]">${formatter.format(v.price)}</td>`;
                        html += `<td>${parseInt(v.admin) === 1 ? '<input type="number" step="any" style="width: 80px" name="product_discount" max="" value="'+v.discount+'" class="form-control product-discount">' :formatter.format(v.discount)}</td>`;
                        html += `<td><input type="hidden" class="priceInput" name="price[]" value="${v.total + v.discount}"><span class="price">${formatter.format(v.total + v.discount)}</span></td>`;
                        html += `<td><input type="hidden" class="netInput" name="net[]" value="${v.total}"><span class="net">${formatter.format(v.total)}</span></td>`;
                        html += `<td><span id="product-${v.id}" class="btn btn-danger btn-remove"><i class="fa fa-times"></i></span></td>`;
                    html += '<tr>';
                    $("#productsTable").append(html);
                    $(".btn-paid").data("returned",true);
                    total += v.total;
                    net += v.total+v.discount;
                });
                $(".total-price").text(formatter.format(e.target.getAttribute("price")));
                $(".total-net").text(formatter.format(e.target.getAttribute("price")-e.target.getAttribute("discount")));

                $(".createInvoice").append(`<input type="hidden" id="invoiceId" value="${e.target.getAttribute("id")}" name="bill_id">`);
                $(".createInvoice").append(`<input type="hidden" id="invoiceType" value="discarded_sale" name="type">`);

                $(".btn-save").removeClass("btn-paid").addClass("btn-returned");

                $("#discardedModal").modal("hide");

                $("#totalPrice").val(e.target.getAttribute("price"));
                $("#totalQuantity").val(e.target.getAttribute("quantity"));

                $('body').removeClass('modal-open');

                $('.modal-backdrop').remove();
            }

        }
    }
</script>

<style scoped>
    li:nth-child(odd){
        color: #117a8b;
    }
    li:nth-child(evan){
        color: #212529;
    }
</style>
