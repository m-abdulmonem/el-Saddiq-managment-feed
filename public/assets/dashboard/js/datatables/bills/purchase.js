//variables
let supplier,
    finalProductList = $("#purchasedProductsTable"),
    body = $("body");




/**
 * search on products
 */
$("#search").keyup(function (e) {
    // stops the default action of a selected element from happening by a user
    e.preventDefault();
    //get new data
    // getProducts(supplier.val(),$(this).val())
});

/**
 * add product to sold product table
 */
body.on("click",".btn-purchased-product",function (e) {
    // stops the default action of a selected element from happening by a user
    e.preventDefault();
    //variables
    let product = $(this);

    //when click hide this button and add after it a span with class id
    product.attr("disabled",true);

    //add this html below to tables
    finalProductList.append(tableRowHtml({
        id: product.data("id"),
        name: product.data("name"),
        price: product.data('total-price'),
        weight: product.data('weight'),
        salePrice: product.data('sale-price'),
        query:  product.data("query"),
        value:  product.data("value"),
        unit: product.data("unit"),
        quantity: 1,
        unitSymbol: product.data("unit-symbol"),
        key: product.attr("id"),
        profitRatio:  product.data("profit"),
        discount: product.data("discount")
    }));

    //calculate purchase price of added product
    calcPurchasePrice(finalProductList);

    //calculate total
    calcTotal();
});

/**
 * when change quantity set the new value to
 * ton price with attribute on it
 */
body.on("keyup change",".quantity",function (e) {
    //variables
    let quantity = $(this).val();

    //find ton price in this quantity row and  set quantity attribute value
    $(this).closest("tr").find(".ton-price")
        .attr("data-quantity",(quantity < 1  ? 1: quantity ));

    quantity();
    //calculate total price
    calcTotal();
});

/**
 * calculate sale price and total price when change ton price
 */
body.on("keyup change",".ton-price",function (e) {
    calcSalePrice(this);
});

/**
 * calculate sale price and total price when change ton price
 */
body.on("keyup change","#discount",function (e) {
    calcTotal()
});

/**
 * calculate sale price and total price when change ton price
 */
body.on("keyup change","#postpaid",function (e) {
    calcTotal()
});

body.on("click",".btn-anther-stock",function (e) {
    // stops the default action of a selected element from happening by a user
    e.preventDefault();

    finalProductList.prepend($(this).closest("tr").clone())


});
/**
 * remove sold product
 */
body.on("click",".btn-product-remove",function (e) {
    e.preventDefault();

    $(` #productsListTable #${ $(this).data("id") }`).removeClass("disabled");

    //remove row from table
    $(this).closest("td").closest("tr").remove();

    //calculate total
    calcTotal()
});
/**
 * purchased products data rows
 *
 * @param data
 * @returns {string}
 */
function tableRowHtml(data = {}) {

    let html = "";

    html = `<tr >`;
        html += `<td><input type="hidden" name="product_id[]" value="${data.id}"> <input type="hidden" name="query[]" value="${data.query}">${data.name}</td>`;
        html += `<td><select class="stocks form-control"  name="stock[]" data-key="${data.key}">${stocks}</select></td>`;
        html += `<td><label class="form-inline"><input type='number' step="any" class='quantity form-control' style="width: 100px;" data-key="${data.key}" name='quantity[]' value="${data.quantity||1}"  data-price='${data.price}' placeholder='الكمية'> </label></td>`;
        html += `<td><label class="form-inline"><input type="number" step="any" class="ton-price form-control" style="width: 100px;" minlength="1" name='prices[]' data-weight="${data.weight}" data-discount="${data.discount}" data-key="${data.key}" data-profit-ratio="${data.profitRatio}" data-query="${data.query}" data-value="${data.value}" data-quantity="${data.quantity}" placeholder='سعر الوحدة' value="${Number.isInteger(data.price) ? data.price: 1}"/> ج.م </label></td>`;
        html += `<td class="purchase-price"> ج.م </td>`;
        html += `<td class="discount-price"></td>`;
        html += `<td><label class="form-inline"><input type="number" step="any" class="sale-price form-control" style="width: 100px;" name='sale_price[]' data-key="${data.key}" placeholder='سعر  بيع الشكارة' value="${data.salePrice}"/> ج.م </label></td>`;
        html += `<td><label class="date"><input type="datetime" class="expire_at form-control" style="width: 120px;" name='expired_at[]' data-key="${data.key}" value="${moment(addMonths(new Date(),3)).format("YYYY-MM-DD")}" title='تاريخ انتهاء المنتج' /> <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span> </label></td>`;
        html += `<td><span data-id="${data.key}" class="btn btn-info btn-anther-stock"  >أضافة</span></td>`;
        html += `<td><span class='btn btn-danger btn-product-remove' data-id="${data.key}"><i class='fa fa-trash'></i></span> </td>`;
    html += `</tr>`;

    return html;
}
function quantity() {
    let quantity = 0;
    $(".quantity").each(function (k,v) {
        quantity += parseInt($(this).val())
    });
    $(".total-quantity-input").val(quantity);
}
/**
 * calculate total price
 */
function calcTotal() {

    //variables
    let price = 0, discount = parseInt($("#discount").val()),totalQuantity = 0;

    finalProductList.find(".ton-price").each(function (k) {
        //variables
        let unitPrice = $(this).val(),
            query = $(this).data("query"),
            quantity = $(this).attr("data-quantity");

        price += ( (query === "*")
            ? unitPrice * quantity
            : unitPrice * 1  )

        console.log(unitPrice, quantity)

    });//end of each
    finalProductList.find(".quantity").each(function (k) {
        totalQuantity += parseInt($(this).val())
    });

    $("#totalQuantity").val(totalQuantity);

    $(".total-quantity-input").val(totalQuantity)
    // add the price to view in total-price class
    $(".net").text(`${$.number(price,2)} ج.م `);
    ////put total price to input hidden
    $(".total-price-input").val(price);
    //calculate total price after apply discount
    $(".after-discount").text( !Number.isNaN(discount) ? $.number(price - discount) : 0 );

    $("#postpaid").val(price);
}

/**
 * calculate sale price
 *
 * @param el element
 */
function calcSalePrice(el) {
    let tr=$(el).closest("tr"), // row
        price  = tr.find(".ton-price"), // ton price in this row
        quantity  = tr.find(".quantity"), // quantity in this row
        totalPrice, //(price.val() / (1000/weight.val()))
        pieceCount = (price.data("value")/price.data("weight")),
        discount = (price.val() - price.data("discount")) / pieceCount;

    //change if product is measured by ton or not
    totalPrice =  ( (price.data("query") === "*")
        ? ( price.val() / pieceCount )
        : ( price.val() / quantity.val() ) );

    //set new sale price to the sale price input
    tr.find(".sale-price").val(totalPrice + price.data("profit-ratio"));

    //set new purchase price to the sale price input
    tr.find(".purchase-price").html(`<span class="info-color">${totalPrice}</span> ج.م `);

    //set  price after apply discount to the sale price input
    tr.find(".discount-price").html( ( Number.isInteger(price.data("discount")) )
        ? `<span class="info-color">${ discount }</span> ج.م `
        : "-");

    //calculate total price
    calcTotal();
}

/**
 * calculate purchase price
 *
 * @param finalProductList
 */
function calcPurchasePrice(finalProductList) {

    //loop on purchase prices classes and call function calc sale price
    finalProductList.find(".purchase-price").each(function (index) {
        calcSalePrice(this);
    });

}

/**
 *
 * @param date
 * @param months
 * @returns {*}
 */
function addMonths(date, months) {
    var d = date.getDate();
    date.setMonth(date.getMonth() + +months);
    if (date.getDate() != d) {
        date.setDate(0);
    }
    return date;
}

//get total price when page is loaded
calcTotal();
