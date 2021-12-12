$(function () {
    let body = $("body"),
        $productSaleList = $("#final-products-list");


    body.on("click", ".btn-purchased-product", function (e) {
        e.preventDefault();
        let stocks = [];
        $.each($(this).data("stock"),function (id,name) {
            stocks.push(`<option value="${id}">${name}</option>`)
        });
        $productSaleList.append(productSaleList({
            id: $(this).data("id"),
            key: $(this).attr("id"),
            name: $(this).data("name"),
            weight: $(this).data("weight"),
            kilo: $(this).data("weight"),
            unitPrice: $(this).data("price"),
            totalPrice: $(this).data("price"),
            supplier: $(this).data("supplier"),
            quantity: $(this).data("quantity"),
            stocks: stocks.join().replace(",")
        })).persiaNumber('ar');
        $(this).attr("disabled","disabled");

        quantity();
        calcTotal()
    });




    body.on("click", ".btn-remove", function (e) {
        e.preventDefault();

        $(`#products-list #${ $(this).data("id") }`).prop("disabled",false).removeClass("disabled");

        $(this).closest("tr").remove();
        calcTotal()
    });

    body.on("change keyup","#postpaid",function () {
        let $this = parseFloat($(this).val()),

            totalPrice = parseFloat($(".total-price-input").val()),
            discountInput = $("#discount").val(),
            discount = Number.isNaN(discountInput) ? 0: discountInput,
            residual = totalPrice - $this - discount;

        $(".paid").text( $.number($this,2)  ).persiaNumber("ar");

        $(".residual").text( $.number(residual ,2) ).persiaNumber("ar");

        $("#debt").val( (residual >0 ? "postpaid" : "cash") ).change()

    });

    body.on("change keyup","#discount",function () {
        // let $this = parseFloat($(this).val()),
        //     totalPrice = parseFloat($(".total-price-input").val());
        //
        // $(".after-discount").text($.number( totalPrice-$this ,2)).persiaNumber("ar");

        calcTotal()

    });

    body.on("change keyup", ".quantity", function () {
        let totalPrice = $(this).val() * $(this).data("price");

        if ($(this).val() > $(this).attr("max") ){
            $(this).val($(this).attr("max"));
            $(document).Toasts("create",{
                class: 'bg-warning',
                title: 'تحذير الكمية',
                autohide: true,
                delay: 750,
                body: 'عفوا عدد الشكاير المدخل اكبر من العدد الموجود فى المخزن',
                // subtitle: 'أغلاق',
                position: 'topLeft'
            })
        }

       $(this).closest("tr").find(".price span")
           .text( `${$.number( totalPrice,2 )}  ج.م` )
           .parent().find("input").val(totalPrice).parent()
           .parent().find(".kilo").text( `${$.number( $(this).val() * $(this).data("weight") )} ك` )
           .parent().persiaNumber("ar");

        quantity();
        calcTotal()
    });



});

quantity();
calcTotal();

function calcTotal() {
    let totalPrice=0,
        discount = parseFloat($("#discount").val()),
        postpaid = parseFloat($("#postpaid").val());
    $("#final-products-list .price input").each(function (k) {
        // console.log($(this).val())
        totalPrice += parseFloat($(this).val())
    });

    $(".total-price-input").val(totalPrice);

    $(".total-price").text($.number(totalPrice,2)).persiaNumber("ar");

    $(".after-discount").text( $.number(totalPrice-discount,2) ).persiaNumber("ar");

    $(".paid").text( $.number(totalPrice,2) ).persiaNumber("ar");

    $(".residual").text($.number( ( totalPrice-postpaid-discount ) ,2)).persiaNumber("ar")
}

function quantity() {
    let quantity = 0;
    $(".quantity").each(function (k,v) {
        quantity += parseInt($(this).val())
    });
    $(".total-quantity").val(quantity);
}

function productSaleList(data = {}) {
    let html=`<tr>`;
            html += `<td class="info-color" ><input type="hidden" name="products[]" value="${data.id}">${data.name}</td>`;
            html += `<td class="stock"><select name="stock_id[]" class="form-control">${data.stocks}</select></td>`;
            html += `<td class="weight">${data.weight}</td>`;
            html += `<td><input type="number" class="form-control form-control-sm quantity" name="quantity[]" value="1" min="1" max="${ data.quantity }" data-weight="${data.weight}" data-price='${data.unitPrice}'"></td>`;
            html += `<td class="kilo">${data.kilo } </td>`;
            html += `<td><input type="hidden" value="${data.unitPrice}" name="unitPrice[]">${data.unitPrice}</td>`;
            html += `<td class="price"> <input type="hidden" name="price[]" value="${data.unitPrice}"> <span>${data.totalPrice ?? data.unitPrice} ج.م</span></td>`;
            html += `<td><span class="btn btn-danger btn-remove" data-id="${data.key}"><i class="fa fa-trash"></i></span></td>`;
    return html += `</tr>`;
}


