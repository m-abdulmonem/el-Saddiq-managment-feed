<template>
    <div class="card-body">
        <table class="table table-striped table-hover table-bordered " id="productsTable">
            <thead>
            <tr class="">
                <th scope="col">#</th>
                <th scope="col" style="width: 120px">كود</th>
                <th scope="col">الصنف</th>
                <th scope="col">المخزن</th>
                <th scope="col">الكمية</th>
                <th scope="col">المتبقى</th>
                <th scope="col">سعر الوحدة</th>
                <th scope="col">الخصم</th>
                <th scope="col">الاجالى</th>
                <th scope="col">الصافى</th>
                <th scope="col">حذف</th>
            </tr>
            </thead>
            <tbody >
            <tr v-for="product in products">
                <th scope="row">1</th>
                <td><input type="text" ></td>
                <td>{{ product.name}}</td>
                <td>=</td>
                <td>@mdo</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>@mdo</td>
                <td><span id="item-product.id"><i class="fa fa-times"></i></span></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "DailyTableComponent",
        data:
            function () {

            return {
                products: [],

            }
        },
        mounted() {
            // this.loadProducts()

        },
        methods:{

            // loadProducts: function () {
            //     axios.get("ajax/products")
            //         .then((response) => {
            //             this.products = response.data.data
            //         })
            //         .catch(function (errors) {
            //             console.log(errors)
            //         })
            // }
        }
    }
</script>

<style scoped>

</style>
