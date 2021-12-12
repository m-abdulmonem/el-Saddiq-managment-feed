/**
 * add new key=>value to the HTML5 storage
 *
 * 
 * @param key
 * @param value
 * @constructor
 */
function SaveItem(key,value) {
    localStorage.setItem(key, value);
}

function SaveObject(key,value) {
    localStorage.setItem(key,JSON.stringify(value))
}

/**
 *
 * @param data
 * @constructor
 */
function Update(data) {
    let product = JSON.parse(localStorage.getItem(data.key)),d;

    if(product !== null) {
        d = $.extend({
            id: product.id,
            name: product.name,
            price: product.price,
            profitRatio: product.profitRatio,
            query: product.query,
            salePrice: product.salePrice,
            stock: product.stock,
            unit: product.unit,
            unitSymbol: product.unitSymbol,
            value: product.value,
            weight: product.weight,
            quantity: product.quantity,
            supplierDiscount: product.supplierDiscount
        },data);
        new SaveItem(data.key, JSON.stringify(d))
    }
    new SaveObject(data.key,d)
}

/**
 * dynamically populate the table with shopping list items
 * below step can be done via PHP and AJAX too.
 */
function getSavedProductsList() {

    if (CheckBrowser()) {
        //variables
        let key = "",
            data = "",
            price=0,
            tonPrice,
            paid = JSON.parse(localStorage.getItem("paid"));

        if (window.location.href.includes("create"))
            clear();

        //for more advance feature, you can set cap on max items in the cart
        for (let i = 0; i <= localStorage.length-1; i++) {
            key = localStorage.key(i);

            //check if there products saved or not
            if (key !== null){
                //get saved data in var data
                data = key !== null ?  JSON.parse( localStorage.getItem( key )) : null;

                //check if product price is number or not if not number set the ton price [1]
                tonPrice = Number.isInteger(data.price) ? parseInt(data.price) : 1;

                // get only saved products
                if (key !== "paid"){
                    //add the saved product to purchase products table
                    finalProductList.prepend(tableRowHtml({
                        id: data.id,
                        name: data.name,
                        price: parseInt(data.price),
                        weight: data.weight,
                        salePrice: data.salePrice,
                        key: key,
                        query: data.query,
                        unit: data.unit,
                        unitSymbol: data.unitSymbol,
                        value: data.value,
                        profitRatio: data.profitRatio,
                        quantity: data.quantity,
                        discount: data.supplierDiscount
                    }));

                    //collecting the all price together and put them in price var
                    price += (data.query === "*") ? data.price * data.quantity : data.price;
                }

                //set the product stock to saved stock
                changeStock(key, (!Number.isNaN(parseInt(data.stock)) ? data.stock :1) )
            }

        } //end of for loop

        //calculate purchase price of products
        calcPurchasePrice(finalProductList);
        //get paid value
        if (paid !== null) {
            $(".paid").text($.number(paid.paid));
            $("#transaction_id").val(paid.id);
            $(".residual").text($.number(price - paid.paid));
        }

        //calculate total price of saved products
        $(".total-price").text($.number(price));
        $(".total-price-input").text($.number(price));

    } else {
        alert('Cannot save shopping list as your browser does not support HTML 5');
    }
}

/**
 * change stock
 */
function changeStock(key , stock) {
    $(".stocks").each(function (v) {
        if ($(this).data("key") === key)
            $(this).find(`option[value=${stock}]`).prop("selected",true);
    })
}

/**
 * get saved items from localstorage
 * check if product are saved or not
 * to set the add product button to disabled
 *
 * @param button
 */
function getKeys(button) {
    if (CheckBrowser()) {
        let key = "";
        //for more advance feature, you can set cap on max items in the cart
        for (let i = 0; i <= localStorage.length-1; i++) {
            key = localStorage.key(i);
            button.find(`#${key}`).hide()
                .closest("td").prepend(`<span class='btn btn-default ${key}'><i class='fa fa-plus'></i></span>`);
        }
    } else {
        alert('Cannot save shopping list as your browser does not support HTML 5');
    }
}

/**
 * remove all  localstorage items
 */
function clear() {

    if (typeof finalProductList !== 'undefined' && window.location.href.indexOf("create") > 0)
        //remove old rows in purchase table
        finalProductList.children("tr").remove();
    // set total price to 0
    $(".total-price").text(0);
    // set total price hidden input to 0
    $(".total-price-input").val(null);
    //check add product button are disabled or not
    $(".products-list .btn-product-add").each(function (k) {
        //check if button has display:none property
        if ($(this).css("display") === "none")
            //show add product and hide disabled add button
            $(this).show().prev().hide();
    });
    //remove all items
    localStorage.clear();
}

/**
 * remove specified item from localstorage
 * @param key
 */
function remove(key) {
    //check if saved item is exist
    if (localStorage.getItem(key))
        //remove select item
        localStorage.removeItem(key)
}

/**
 *remove all localstorage item after specified time
 * @param time time in min
 */
function clearAfterTime(time = 30) {
    //repeat execution to remove all storage items
    setInterval(function () {
        if (!window.location.href.indexOf("edit") < 0)
            //clear all storage items
            clear();
    },time * 60 * 1000);//end of setInterVal
}

//below function may be redundant
/**
 * @return {boolean}
 */
function CheckBrowser() {
    return ('localStorage' in window && window['localStorage'] !== null);
}



